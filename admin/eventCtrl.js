angular.module('adminApp').controller('eventCtrl', function($scope, $http){
    $scope.formData = [];
    $scope.noConstructionSites = false;
    $scope.collapse = false;
    $scope.typeSelect = {
        availableOptions: [
            {type: 'DELAI', name: 'Un délai'},
            {type: 'INTEMPERIE', name: 'Des intempéries'},
            {type: 'COUPURE', name: 'Une coupure réseau'},
            {type: 'MOBILITE', name: 'Un impact sur la mobilité'},
            {type: 'NUISANCE SONORE', name: 'Une nuisance sonore'},
            {type: 'HORRAIRES DE TRAVAIL', name: 'Les horraires de travail'},
            {type: 'ACTIONS CORRECTIVES', name: 'Les actions correctives'}
        ],
        selectedOption: {type: 'DELAI', name: 'Un délai'}
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
        $http.get("ajax/getEvents.php").then(function (response) {$scope.events = response.data;});
        $http.get("ajax/getConstructionSites.php").then(function (response) {
            $scope.constructionSites = response.data;
            if(($scope.constructionSites.length <= 0)){
                $scope.noConstructionSites = true;
            }else{
                $scope.constructionSelect = $scope.constructionSites[0];
            }
        });
    };
    updateView();

    $scope.addEntry = function(){
        $scope.formData.id = $scope.constructionSelect.id;
        $scope.formData.type = $scope.typeSelect.selectedOption.type;

        $http({
            method: 'POST',
            url: 'ajax/addEvent.php',
            data: param($scope.formData),
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).success(function(data){
            if(!data.success){
                $scope.errorTitle = data.errors.id;
                $scope.errorAddress = data.errors.address;
                $scope.errorStartDate = data.errors.startDate;
                $scope.errorEndDate = data.errors.endDate;
                $scope.errorField1 = data.errors.field1;

                $scope.submissionMessage = data.messageError;
                $scope.errors = data.errors;
                $scope.submission = true; //shows the error message
            }else{
                $scope.errorTitle = false;
                $scope.errorAddress = false;
                $scope.errorStartDate = false;
                $scope.errorEndDate = false;
                $scope.errorField1 = false;
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
            url: 'ajax/removeEvent.php',
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