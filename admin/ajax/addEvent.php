<?php

require '../../Database.php';

$errors = array(); // array to hold validation errors
$data = array(); // array to pass back data

// validate the variables ======================================================

if(empty($_POST['id'])){
    $errors['id'] = "Aucun chantier n'a été selectionné.";
}
if(empty($_POST['type'])){
    $errors['type'] = "Aucun type n'a été selectionné.";
}
if(empty($_POST['field1'])){
    $errors['field1'] = "Aucune information n'a été entrée.";
}
if ($_POST['startDate'] === 'null'){
    $errors['startDate'] = 'Il faut une date de debut.';
}
if (($_POST['endDate']) === 'null'){
    $errors['endDate'] = 'Il faut une date de fin.';
}
if($_POST['startDate'] !== 'null' && $_POST['endDate'] !== 'null'){
    //Date conversion to a nice SQL-friendly format
    $startDate = date("Y-m-d", strtotime(substr($_POST['startDate'], 4, 11)));
    $endDate = date("Y-m-d", strtotime(substr($_POST['endDate'], 4, 11)));
    if( $startDate > $endDate){
        $errors['endDate'] = 'La date de début doit être avant la date de fin';
    }
}

if(!empty($errors)){
    $data['success'] = false;
    $data['errors'] = $errors;
    $data['messageError'] = "Veuillez complèter les champs en subrillance.";
}else{
    $data['success'] = true;
    $data['messageSuccess'] = 'Evènement ajouté';

    $db = new Database();
    $db->query("INSERT INTO events (type, startDate, endDate, information, constructionSitesId)
                VALUES(:type, :startDate, :endDate, :information, :constructionSitesId)");
    $db->bind(':type', $_POST['type']);
    $db->bind(':startDate', $startDate);
    $db->bind(':endDate', $endDate);
    $db->bind(':information', $_POST['field1']);
    $db->bind(':constructionSitesId', $_POST['id']);
    $db->execute();

    if($db->rowCount() < 0){
        $data['success'] = false;
        $data['messageError'] = "Erreur lors de l'écriture dans la base de donnée.";
    }
}

echo json_encode($data);