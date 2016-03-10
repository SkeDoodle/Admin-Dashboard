<?php

require '../../Database.php';

$errors = array(); // array to hold validation errors
$data = array(); // array to pass back data

// validate the variables ======================================================
if (empty($_POST['title'])){
    $errors['title'] = 'Un titre est requis.';
}
if (empty($_POST['address'])){
    $errors['address'] = 'Une adresse est requise.';
}
if ($_POST['startDate'] === 'null'){
    $errors['startDate'] = 'Il faut une date de debut.';
}
if (($_POST['endDate']) === 'null'){
    $endDate = null;
}else{
    $endDate = $_POST['endDate'];
}
//Date conversion to a nice SQL-friendly format
$startDate = date("Y-m-d", strtotime(substr($_POST['startDate'], 4, 11)));
if(!is_null($endDate)){
    $endDate = date("Y-m-d", strtotime(substr($_POST['endDate'], 4, 11)));
}

if(!is_null($endDate )&& $startDate > $endDate){
    $errors['endDate'] = 'La date de début doit être après la date de fin';
}
for($i = 1; $i <= 7; $i++){
    if (empty($_POST['field' . $i]))
        $_POST['field' . $i] = '';
}

// return a response ===========================================================
// response if there are errors
if (!empty($errors)) {
    // if there are items in our errors array, return those errors
    $data['collapse'] = false;
    $data['success'] = false;
    $data['errors'] = $errors;
    $data['messageError'] = 'Veuillez complèter les champs en subrillance.';
} else {
    // if there are no errors, return a message
    $data['collapse'] = true;
    $data['success'] = true;
    $data['messageSuccess'] = 'Chantier ajouté';

    //Geocoding
    $address = $_POST['address'];
    $address = urlencode($address);
    $url = "http://maps.google.com/maps/api/geocode/json?address={$address}";
    $resp_json = file_get_contents($url);
    $resp = json_decode($resp_json, true);

    $db = new Database();
    $db->query("INSERT INTO constructionsites (title, address, latitude, longitude, startDate, endDate, PurposeOfTheProject, EarningsOfTheProject, PictureOfTheProjectAtTheEnd, StreetsConcernedByTheProject, RulerOfTheProject, CostsOfTheProject, WhoIsFundingTheProject)
                VALUES (:title, :address, :latitude, :longitude, :startDate, :endDate, :PurposeOfTheProject, :EarningsOfTheProject, :PictureOfTheProjectAtTheEnd, :StreetsConcernedByTheProject, :RulerOfTheProject, :CostsOfTheProject, :WhoIsFundingTheProject)");


    if($resp['status'] === 'OK'){

        $latitude = $resp['results'][0]['geometry']['location']['lat'];
        $longitude = $resp['results'][0]['geometry']['location']['lng'];
        $formatted_address = $resp['results'][0]['formatted_address'];

        //If user wants formatted google addresses
        if(isset($_POST['format']) && $formatted_address){
            $address = $formatted_address;
        }else{
            $address = $_POST['address'];
        }
    }else{
        $longitude  = '';
        $latitude = '';
    }

    $db->bind(':title', $_POST['title'], PDO::PARAM_STR);
    $db->bind(':address', $address, PDO::PARAM_STR);
    $db->bind(':latitude', $latitude, PDO::PARAM_STR);
    $db->bind(':longitude', $longitude, PDO::PARAM_STR);
    $db->bind(':startDate',$startDate, PDO::PARAM_STR);
    $db->bind(':endDate', $endDate, PDO::PARAM_STR);
    $db->bind(':PurposeOfTheProject', $_POST['field1'] , PDO::PARAM_STR);
    $db->bind(':EarningsOfTheProject', $_POST['field2'] , PDO::PARAM_STR);
    $db->bind(':PictureOfTheProjectAtTheEnd', $_POST['field3'] , PDO::PARAM_STR);
    $db->bind(':StreetsConcernedByTheProject', $_POST['field4'] , PDO::PARAM_STR);
    $db->bind(':RulerOfTheProject', $_POST['field5'] , PDO::PARAM_STR);
    $db->bind(':CostsOfTheProject', $_POST['field6'] , PDO::PARAM_STR);
    $db->bind(':WhoIsFundingTheProject', $_POST['field7'] , PDO::PARAM_STR);
    $db->execute();

    //if the previous query didn't fail
    if($db->rowCount() > 0){
        $id_chantier = $db->lastInsertId();
        $db->query("INSERT INTO questionnaire (id_chantier) VALUES (:id_chantier)");
        $db->bind(':id_chantier', $id_chantier, PDO::PARAM_INT);
        $db->execute();
    }
}

// return all our data to an AJAX call
echo json_encode($data);