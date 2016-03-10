<?php

require '../../Database.php';

$errors = array(); // array to hold validation errors
$data = array(); // array to pass back data

if(empty($_POST['id'])){
    $data['success'] = false;
    $data['messageError'] = "L'ID du chantier n'existe pas ou plus.";
}else{
    $db = new Database();
    $db->query("DELETE FROM events WHERE id = :id");
    $db->bind(':id', $_POST['id'], PDO::PARAM_STR);
    $db->execute();

    if($db->rowCount() > 0){
        $data['success'] = true;
        $data['messageSuccess'] = 'Chantier supprimé';
    }else{
        $data['success'] = false;
        $data['messageError'] = "Le chantier demandé n'existe pas ou plus.";
    }
}

echo json_encode($data);