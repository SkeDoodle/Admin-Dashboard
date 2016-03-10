<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Statistiques</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php session_start(); ?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header"><span class="navbar-brand">Admin</span></div>
        <ul class="nav navbar-nav">
            <li><a href="admin.php">Chantiers</a></li>
            <li><a href="events.php">&Eacute;vènements</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Se déconnecter</a></li>
        </ul>
    </div>
</nav>
<div class="container">
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

    <?php
        include '../Database.php';
        $db = new Database();

        if(isset($_GET['id'])){
            $id_chantier = $_GET['id'];
            $request = "SELECT N12345 FROM questionnaire WHERE id_chantier='".$id_chantier."'";
            $db->query($request);
            $data = $db->single();
            
            if (empty($data['N12345'])){
                echo 'Pas encore de réponses au questionnaire';
            }else {
                $NV = explode(";", $data['N12345'])[0];
                $N1 = explode(";", $data['N12345'])[1];
                $N2 = explode(";", $data['N12345'])[2];
                $N3 = explode(";", $data['N12345'])[3];
                $N4 = explode(";", $data['N12345'])[4];
                $N5 = explode(";", $data['N12345'])[5];

                $NG = ($N1+$N2+$N3+$N4+$N5)/5;
                echo '
                    <table class="table table-hover">
                      <tbody>
                      <tr>
                          <td>Nombre de répondants au quesionnaire à ce jour</td>
                          <td>'.$NV.'</td>
                        </tr>
                        <tr>
                          <td>Note de satisfaction globale du chantier</td>
                          <td>'.$NG.'</td>
                        </tr>
                        <tr>
                          <td>Problèmes reportés</td>
                          <td> </td>
                        </tr>
                        <tr>
                          <td>Propreté du chantier</td>
                          <td>'.$N1.'</td>
                        </tr>
                        <tr>
                          <td>Organisation de la circulation voirie et piéton</td>
                          <td>'.$N2.'</td>
                        </tr>
                        <tr>
                          <td>Impact sonore</td>
                          <td>'.$N3.'</td>
                        </tr>
                        <tr>
                          <td>Qualité des informations communiquées</td>
                          <td>'.$N4.'</td>
                        </tr>
                        <tr>
                          <td>Respect des délais</td>
                          <td>'.$N5.'</td>
                        </tr>
                      </tbody>
                    </table>';
            }
        }
    ?>
    <br><a href="statsDetails.php?id=<?php if(isset($_GET['id'])){echo $_GET['id'];}else{echo "#";} ?>"> <input type="button" value="   Détails   "> </a>
</div>
</body>
</html>