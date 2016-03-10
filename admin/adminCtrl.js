angular.module('adminApp').controller('adminCtrl', function($scope, $http){

    $scope.formData = {};
    $scope.todayDate = new Date();
    $scope.submission = false;
    $scope.collapse = false;

    $scope.convertDate = function(date){
        return new Date(date);
    };

    var param = function(data) {
        var returnString = '';
        for (d in data){
            if (data.hasOwnProperty(d))
                returnString += d + '=' + data[d] + '&';
        }
        // Remove last ampersand and return
        return returnString.slice( 0, returnString.length - 1 );
    };

    var updateView = function (){
        $http.get("ajax/getConstructionSites.php").then(function (response) {$scope.locations = response.data;});
    };

    updateView();

    $scope.addEntry = function(){
        $http({
            method: 'POST',
            url: 'ajax/addConstructionSite.php',
            data: param($scope.formData),
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).success(function(data){
            if(!data.success){
                $scope.errorTitle = data.errors.title;
                $scope.errorAddress = data.errors.address;
                $scope.errorStartDate = data.errors.startDate;
                $scope.errorEndDate = data.errors.endDate;

                $scope.submissionMessage = data.messageError;
                $scope.errors = data.errors;
                $scope.submission = true; //shows the error message
            }else{
                $scope.errorTitle = false;
                $scope.errorAddress = false;
                $scope.errorStartDate = false;
                $scope.errorEndDate = false;
                $scope.submissionMessage = data.messageSuccess;
                $scope.formData = {}; // form fields are emptied with this line
                $scope.submission = true; //shows the success message
                updateView();
            }
        });
    };
    $scope.removeEntry = function(id){
        $http({
            method: 'POST',
            url: 'ajax/removeConstructionSite.php',
            data: 'id=' + id,
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).success(function(data){
            if(!data.success){
                $scope.submissionMessage = data.messageError;
                $scope.submission = true; //shows the error message
            }else{
                $scope.submissionMessage = data.messageSuccess;
                $scope.submission = true; //shows the success message
                updateView();
            }
        });
    };
});