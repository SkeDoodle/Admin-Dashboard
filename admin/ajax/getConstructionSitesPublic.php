<?php

include '../../Database.php';

session_start();
$db = new Database();

$db->query('SELECT * FROM constructionSites');

$db->execute();

$results=$db->fetchAll();
$json=json_encode($results);
echo $json;