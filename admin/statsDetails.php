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
//        if(isset($_GET['id'])) {
//            $id_chantier = $_GET['id'];
//            $request = "SELECT * FROM questionnaire WHERE id_chantier='" . $id_chantier . "'";
//            $db->query($request);
//            $data = $db->single();
//        }
    include '../Database.php';
    $db = new Database();
    $id_chantier = $_GET['id'];
    $request = "SELECT * FROM questionnaire WHERE id_chantier='" . $id_chantier . "'";
    $db->query($request);
    $data = $db->single();

        //Recupération des données
//    if (!empty($data['Q1'])){
//        $Q11 = explode(";",$data['Q1'])[0];
////        $Q12 = explode(";",$data['Q1'])[1];
//    }else{
//        $Q11 = 0;
//    }
//
//
//    if (!empty($data['Q2'])){
//        $Q21 = explode(";",$data['Q2'])[0];
//        $Q22 = explode(";",$data['Q2'])[1];
//        $Q23 = explode(";",$data['Q2'])[2];
//        $Q24 = explode(";",$data['Q2'])[3];
//    }else{
//        $Q21 = 0;
//        $Q22 = 0;
//        $Q23 = 0;
//        $Q24 = 0;
//    }

    if (!empty($data['Q3'])){
        $Q31 = explode(";",$data['Q3'])[0];
        $Q32 = explode(";",$data['Q3'])[1];
        $Q33 = explode(";",$data['Q3'])[2];
        $Q34 = explode(";",$data['Q3'])[3];
    }else{
        $Q31 = 0;
        $Q32 = 0;
        $Q33 = 0;
        $Q34 = 0;
    }
    if (!empty($data['Q4'])){
        $Q41 = explode(";",$data['Q4'])[0];
        $Q42 = explode(";",$data['Q4'])[1];
        $Q43 = explode(";",$data['Q4'])[2];
        $Q44 = explode(";",$data['Q4'])[3];
        $Q45 = explode(";",$data['Q4'])[4];
        $Q46 = explode(";",$data['Q4'])[5];
        $Q47 = explode(";",$data['Q4'])[6];
        $Q48 = explode(";",$data['Q4'])[7];
    }else{
        $Q41 = 0;
        $Q42 = 0;
        $Q43 = 0;
        $Q44 = 0;
        $Q45 = 0;
        $Q46 = 0;
        $Q47 = 0;
        $Q48 = 0;
    }
    if (!empty($data['Q5'])){
        $Q51 = explode(";",$data['Q5'])[0];
        $Q52 = explode(";",$data['Q5'])[1];
        $Q53 = explode(";",$data['Q5'])[2];
        $Q54 = explode(";",$data['Q5'])[3];
    }else{
        $Q51 = 0;
        $Q52 = 0;
        $Q53 = 0;
        $Q54 = 0;
    }

    if (!empty($data['Q6'])){
        $Q61 = explode(";",$data['Q6'])[0];
        $Q62 = explode(";",$data['Q6'])[1];
        $Q63 = explode(";",$data['Q6'])[2];
        $Q64 = explode(";",$data['Q6'])[3];
        $Q65 = explode(";",$data['Q6'])[4];
        $Q66 = explode(";",$data['Q6'])[5];
    }else{
        $Q61 = 0;
        $Q62 = 0;
        $Q63 = 0;
        $Q64 = 0;
        $Q65 = 0;
        $Q66 = 0;
    }

    if (!empty($data['Q7'])){
        $Q71 = explode(";",$data['Q7'])[0];
        $Q72 = explode(";",$data['Q7'])[1];
    }else{
        $Q71 = 0;
        $Q72 = 0;
    }

//    if (!empty($data['Q8'])){
//        $Q81 = explode(";",$data['Q8'])[0];
//        $Q82 = explode(";",$data['Q8'])[1];
//        $Q83 = explode(";",$data['Q8'])[2];
//        $Q84 = explode(";",$data['Q8'])[3];
//    }else{
//        $Q81 = 0;
//        $Q82 = 0;
//        $Q83 = 0;
//        $Q84 = 0;
//    }

    if (!empty($data['N12345'])){
        $NV = explode(";", $data['N12345'])[0];
    }else{
        $NV = 1;
    }
        $matrice = array();

        // Premiere colonne
        $matrice[0] = array('Détails des problèmes reportés','Nombre de personnes ayant recencé un problème en %');
        $matrice[1] = array('<strong>Propreté du chantier</strong>','');
        $matrice[2] = array('Une mauvaise gestion des poussières',round((($Q31/$NV)*100),1));
        $matrice[3] = array('La présence de gravats sur la chaussée',round((($Q32/$NV)*100),1));
        $matrice[4] = array('Un problème concernant la zone de stockage',round((($Q33/$NV)*100),1));
        $matrice[5] = array('Un mauvais état des clôtures ou balisages de chantier',round((($Q34/$NV)*100),1));
        $matrice[6] = array('<strong>Organisation de la circulation voirie piéton</strong>','');
        $matrice[7] = array('Un trottoir encombré',round((($Q41/$NV)*100),1));
        $matrice[8] = array('Un problème de passage piéton',round((($Q42/$NV)*100),1));
        $matrice[9] = array('Un mauvais balisage du chemin à emprunter',round((($Q43/$NV)*100),1));
        $matrice[10] = array('Un accès commerce encombré',round((($Q44/$NV)*100),1));
        $matrice[11] = array('Un problème de stationnement',round((($Q45/$NV)*100),1));
        $matrice[12] = array('Un problème d\'itinéraire de déviation',round((($Q46/$NV)*100),1));
        $matrice[13] = array('Un accès PMR encombré',round((($Q47/$NV)*100),1));
        $matrice[14] = array('Une place PMR non disponible',round((($Q48/$NV)*100),1));
        $matrice[15] = array('<strong>Impact sonore</strong>','');
        $matrice[16] = array('Une nuisance sonore tôt le matin',round((($Q51/$NV)*100),1));
        $matrice[17] = array('Une nuisance due au matériel de chantier',round((($Q52/$NV)*100),1));
        $matrice[18] = array('Un dispositif piéton bruyant',round((($Q53/$NV)*100),1));
        $matrice[19] = array('Une nuisance sonore tard le soir',round((($Q54/$NV)*100),1));
        $matrice[20] = array('<strong>Qualité des informations communiquées</strong>','');
        $matrice[21] = array('Un manque de communication en amont du chantier',round((($Q61/$NV)*100),1));
        $matrice[22] = array('Une réunion d\'information incomplète',round((($Q62/$NV)*100),1));
        $matrice[23] = array('Un problème d\'itinéraire de déviation',round((($Q63/$NV)*100),1));
        $matrice[24] = array('Un tract érroné ou incomplet',round((($Q64/$NV)*100),1));
        $matrice[25] = array('Une incompréhension des plans de déviation',round((($Q65/$NV)*100),1));
        $matrice[26] = array('Une information ponctuelle non transmise par la bandeau',round((($Q66/$NV)*100),1));
        $matrice[27] = array('<strong>Respect des délais</strong>','');
        $matrice[28] = array('Un planning annoncé non respecté',round((($Q71/$NV)*100),1));
        $matrice[29] = array('Une coupure d\'eau ou de gaz non respectée',round((($Q72/$NV)*100),1));



    $taille = sizeof($matrice);
        //      // table en html
        echo'<table class="table table-condensed">
                <thead>
                    <tr>
                        <th>'.$matrice[0][0].'</th>
                        <th>'.$matrice[0][1].'</th>
                    </tr>';

        for ($i=1;$i <=$taille-1; $i++){
            echo '  <tr>
                        <td>'.$matrice[$i][0].'</td>
                        <td>'.$matrice[$i][1].'</td>
                    </tr>';
        }
        echo'</tbody></table>';
    ?>
</div>
</body>
</html>