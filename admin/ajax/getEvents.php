<?php

include '../../Database.php';

session_start();
$db = new Database();
if($_SESSION['role'] === 'A'){
    $db->query('SELECT events.*, constructionsites.title
            FROM events
            INNER JOIN constructionsites
            ON events.constructionSitesId = constructionsites.id');
}else{
    $db->query('SELECT events.*, constructionsites.title
                FROM events
                INNER JOIN constructionsites
                INNER JOIN users
                ON (events.constructionSitesId = constructionsites.id AND constructionsites.id = users.constructionSitesId)
                WHERE users.id = :id');
    $db->bind(':id', $_SESSION['id']);
}

$db->execute();

$results=$db->fetchAll();

$json=json_encode($results);
echo $json;