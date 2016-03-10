<?php

include '../../Database.php';

session_start();
$db = new Database();

if($_SESSION['role'] === 'A'){
    $db->query('SELECT * FROM constructionSites');
}else{
    $db->query('SELECT *
            FROM constructionsites INNER JOIN users
            ON constructionsites.id = users.constructionSitesId
            WHERE users.id = :id');
    $db->bind(':id', $_SESSION['id']);
}

$db->execute();

$results=$db->fetchAll();
$json=json_encode($results);
echo $json;