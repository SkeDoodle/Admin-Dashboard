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
            <li class="active"><a href="#">Chantiers</a></li>
            <li><a href="events.php">&Eacute;vènements</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Se déconnecter</a></li>
        </ul>
    </div>
</nav>
<div class="container" ng-app="adminApp" ng-controller="adminCtrl">
    <div class="row hello-row">
        <div class="col-sm-6">Bonjour <?php echo $_SESSION['login']; ?></div>
        <div class="col-sm-6 text-right">
            <?php if ($_SESSION['role'] === 'A') : ?>
                <span>Connecté en tant qu'<strong>administrateur</strong></span>
            <?php elseif ($_SESSION['role'] === 'C') : ?>
                <span>Connecté en tant que <strong>chef de chantier</strong></span>
            <?php endif; ?>
        </div>
    </div>
    <?php if($_SESSION['role'] === 'A'): ?>
    <div class="well">
        <div id="addSite" class="collapse">
            <form class="form-group" role="form" ng-submit="addEntry()" novalidate>
                <div class="form-group">
                    <label for="title">Titre du chantier:</label>
                    <input type="text" class="form-control" name="title" ng-model="formData.title">
                    <div class="alert alert-danger ng-hide" ng-show="errorTitle">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <span>{{errors['title']}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Adresse:</label>
                    <label class="checkbox-inline pull-right"><input type="checkbox" name="format" checked ng-model="formData.format">Formatage d'adresse Google</label>
                    <input type="text" class="form-control" name="address" ng-model="formData.address">
                    <div class="alert alert-danger ng-hide" ng-show="errorAddress">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <span>{{errors['address']}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="startDate">Date de début:</label>
                    <input type="date" class="form-control" name="startDate" ng-model="formData.startDate">
                    <div class="alert alert-danger ng-hide" ng-show="errorStartDate">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <span>{{errors['startDate']}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="endDate">Date de fin:</label>
                    <input type="date" class="form-control" name="endDate" ng-model="formData.endDate">
                    <div class="alert alert-danger ng-hide" ng-show="errorEndDate">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <span>{{errors['endDate']}}</span>
                    </div>
                </div>
                <div class="form-group" ng-class="{'has-error' : errorField1}">
                    <label for="field1">But du projet :</label>
                    <textarea rows="4" cols="50" class="form-control" name="field1" ng-model="formData.field1"></textarea>
                </div>
                <div class="form-group" ng-class="{'has-error' : errorField2}">
                    <label for="field2">Les apports du projet :</label>
                    <textarea rows="4" cols="50" class="form-control" name="field2" ng-model="formData.field2"></textarea>
                </div>
                <div class="form-group" ng-class="{'has-error' : errorField3}">
                    <label for="image">Image du projet :</label>
<!-- TODO Handle image uploads                    -->
                    <input type="file" class="form-control" name="field3" ng-model="formData.field3">
                </div>
                <div class="form-group" ng-class="{'has-error' : errorField4}">
                    <label for="field4">Rues concernées par le projet :</label>
                    <textarea rows="3" cols="50" class="form-control" name="field4" ng-model="formData.field4"></textarea>
                </div>
                <div class="form-group" ng-class="{'has-error' : errorField5}">
                    <label for="field5">Responsable des travaux :</label>
                    <input type="text" class="form-control" name="field5" ng-model="formData.field5">
                </div>
                <div class="form-group" ng-class="{'has-error' : errorField6}">
                    <label for="field6">Coût des travaux :</label>
                    <input type="text" class="form-control" name="field6" ng-model="formData.field6">
                </div>
                <div class="form-group" ng-class="{'has-error' : errorField7}">
                    <label for="field7">Qui finance le projet :</label>
                    <input type="text" class="form-control" name="field7" ng-model="formData.field7">
                </div>
                <button type="submit" name="submit" class="btn btn-success">Ajouter</button>
                <div ng-class="{'submissionMessage' : submission}" ng-bind="submissionMessage"></div>
        </form>
    </div>
        <button data-toggle="collapse" data-target="#addSite" type="button" class="btn" ng-click="collapse=!collapse"><span class="glyphicon" ng-class="{'glyphicon-chevron-down' : !collapse, 'glyphicon-chevron-up' : collapse}"></span> Ajouter un chantier</button>
    </div>
    <?php endif; ?>
<div class="row">
    <div class="col-sm-12 well"><span>Tous les chantiers</span><input type="text" class="pull-right" autocomplete="off" placeholder="Recherche" ng-model="searchBox"></div>
    <table class="table">
        <thead>
        <tr>
            <th class="col-md-3">Titre</th>
            <th class="col-md-3">Adresse</th>
            <th class="col-md-2">Date de début</th>
            <th class="col-md-2">Date de fin</th>
        </tr>
        </thead>
        <tr ng-repeat="location in locations | filter:searchBox">
            <td><a href="stats.php?id={{location.id}}">{{ location.title }}</a></td>
            <td>{{ location.address }}</td>
            <td>{{ location.startDate }}</td>
            <td>{{ location.endDate }}</td>
            <?php if($_SESSION['role'] === 'A'): ?>
            <td><button class="btn btn-danger" ng-click="removeEntry(location.id)">Supprimer</button></td>
            <?php endif; ?>
        </tr>
    </table>
</div>

<div class="row">
    <div class="col-sm-12 well">Les chantiers en cours</div>
    <table class="table">
        <thead>
        <tr>
            <th class="col-md-3">Titre</th>
            <th class="col-md-3">Adresse</th>
            <th class="col-md-2">Date de début</th>
            <th class="col-md-2">Date de fin</th>
        </tr>
        </thead>
        <tr ng-repeat="location in locations | filter:searchBox" ng-if="todayDate >= convertDate(location.startDate)&& (location.endDate == null || todayDate <= convertDate(location.endDate))">
            <td><a href="stats.php?id={{location.id}}">{{ location.title }}</a></td>
            <td>{{ location.address }}</td>
            <td>{{ location.startDate }}</td>
            <td>{{ location.endDate }}</td>
            <?php if($_SESSION['role'] === 'A'): ?>
            <td><button class="btn btn-danger" ng-click="removeEntry(location.id)">Supprimer</button></td>
            <?php endif; ?>
        </tr>
    </table>
</div>
<div class="row">
    <div class="col-sm-12 well">Les chantiers à venir</div>
    <table class="table">
        <thead>
        <tr>
            <th class="col-md-3">Titre</th>
            <th class="col-md-3">Adresse</th>
            <th class="col-md-2">Date de début</th>
            <th class="col-md-2">Date de fin</th>
        </tr>
        </thead>
        <tr ng-repeat="location in locations | filter:searchBox" ng-if="todayDate < convertDate(location.startDate)">
            <td><a href="stats.php?id={{location.id}}">{{ location.title }}</a></td>
            <td>{{ location.address }}</td>
            <td>{{ location.startDate }}</td>
            <td>{{ location.endDate }}</td>
            <?php if($_SESSION['role'] === 'A'): ?>
            <td><button class="btn btn-danger" ng-click="removeEntry(location.id)">Supprimer</button></td>
            <?php endif; ?>
        </tr>
    </table>
</div>
<div class="row">
    <div class="col-sm-12 well">Les chantiers passés</div>
    <table class="table">
        <thead>
        <tr>
            <th class="col-md-3">Titre</th>
            <th class="col-md-3">Adresse</th>
            <th class="col-md-2">Date de début</th>
            <th class="col-md-2">Date de fin</th>
        </tr>
        </thead>
        <tr ng-repeat="location in locations | filter:searchBox" ng-if="todayDate > convertDate(location.endDate) && location.endDate != null">
            <td><a href="stats.php?id={{location.id}}">{{ location.title }}</a></td>
            <td>{{ location.address }}</td>
            <td>{{ location.startDate }}</td>
            <td>{{ location.endDate }}</td>
            <?php if($_SESSION['role'] === 'A'): ?>
            <td><button class="btn btn-danger" ng-click="removeEntry(location.id)">Supprimer</button></td>
            <?php endif; ?>
        </tr>
    </table>
</div>
</div>
<script src="app.js"></script>
<script src="adminCtrl.js"></script>
</body>
</html>