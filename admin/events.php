<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-route.min.js"></script>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php session_start(); ?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header"><span class="navbar-brand">Admin</span></div>
        <ul class="nav navbar-nav">
            <li><a href="admin.php">Chantiers</a></li>
            <li class="active"><a href="events.php">&Eacute;vènements</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Se déconnecter</a></li>
        </ul>
    </div>
</nav>
<div class="container" ng-app="adminApp" ng-controller="eventCtrl">
    <div class="row hello-row">
        <div class="col-sm-6">Bonjour <?php echo $_SESSION['login']; ?></div>
        <div class="col-sm-6 text-right">
            <?php if ($_SESSION['role'] == 'A') : ?>
                <span>Connecté en tant qu'<strong>administrateur</strong></span>
            <?php elseif ($_SESSION['role'] == 'C') : ?>
                <span>Connecté en tant que <strong>chef de chantier</strong></span>
            <?php endif; ?>
        </div>
    </div>
    <div class="ng-hide alert alert-info" ng-show="noConstructionSites">Aucun chantier affecté à votre compte.</div>
    <div class="well" ng-hide="noConstructionSites">
    <div id="addEvent" class="collapse">
        <form class="form-group" role="form" ng-submit="addEntry()" novalidate>
            <div class="form-group">
                <label for="title">Liste des chantiers :</label>
                <select class="form-control" name="title" ng-options="option.title for option in constructionSites track by option.id" ng-model="constructionSelect"></select>
                <div class="alert alert-danger ng-hide" ng-show="errorTitle">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <span>{{errors['title']}}</span>
                </div>
            </div>
            <div class="form-group">
                <label for="type">Type :</label>
                <select class="form-control" name="type" ng-options="option.name for option in typeSelect.availableOptions track by option.type" ng-model="typeSelect.selectedOption"></select>
                <div class="alert alert-danger ng-hide" ng-show="errorTitle">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <span>{{errors['type']}}</span>
                </div>
            </div>
            <div class="form-group">
                <label for="startDate">Date de début :</label>
                <input type="date" class="form-control" name="startDate" ng-model="formData.startDate">
                <div class="alert alert-danger ng-hide" ng-show="errorStartDate">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <span>{{errors['startDate']}}</span>
                </div>
            </div>
            <div class="form-group">
                <label for="endDate">Date de fin :</label>
                <input type="date" class="form-control" name="endDate" ng-model="formData.endDate">
                <div class="alert alert-danger ng-hide" ng-show="errorEndDate">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <span>{{errors['endDate']}}</span>
                </div>
            </div>
            <div class="form-group">
                <label for="field1">Informations :</label>
                <textarea rows="4" cols="50" class="form-control" name="field1" ng-model="formData.field1"></textarea>
                <div class="alert alert-danger ng-hide" ng-show="errorField1">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <span>{{errors['field1']}}</span>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-success">Ajouter</button>
            <div ng-class="{'submissionMessage' : submission}" ng-bind="submissionMessage"></div>
        </form>
        </div>
    <button data-toggle="collapse" data-target="#addEvent" type="button" class="btn" ng-click="collapse=!collapse"><span class="glyphicon" ng-class="{'glyphicon-chevron-down' : !collapse, 'glyphicon-chevron-up' : collapse}"></span> Ajouter un évènement</button>
    </div>
    <div class="row">
        <div class="col-sm-12 well"><span>Tous les évènements</span><input type="text" class="pull-right" autocomplete="off" placeholder="Recherche" ng-model="searchBox"></div>
        <table class="table">
            <thead>
            <tr>
                <th class="col-md-2">Type</th>
                <th class="col-md-2">Date de début</th>
                <th class="col-md-2">Date de fin</th>
                <th class="col-md-4">Chantier</th>
            </tr>
            </thead>
            <tr ng-repeat="event in events | filter:searchBox">
                <td>{{ event.type }}</td>
                <td>{{ event.startDate }}</td>
                <td>{{ event.endDate }}</td>
                <td>{{ event.title }}</td>
                <td><button class="btn btn-danger" ng-click="removeEntry(event.id)">Supprimer</button></td>
            </tr>
        </table>
    </div>
</div>
<script src="app.js"></script>
<script src="eventCtrl.js"></script>
</body>
</html>