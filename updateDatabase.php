<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update database</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $config = parse_ini_file('config.ini');
    $filename = 'database.sql';
    $success = false;

    // Connect to MySQL server
    $db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
    // Temporary variable, used to store current query
    $templine = '';
    // Read in entire file
    $lines = file($filename);
    // Loop through each line
    foreach ($lines as $line) {
        // Skip it if it's a comment
        if (substr($line, 0, 2) == '--' || $line == '')
            continue;

        // Add this line to the current segment
        $templine .= $line;
        // If it has a semicolon at the end, it's the end of the query
        if (substr(trim($line), -1, 1) == ';') {
            // Perform the query
            $stmt = $db->prepare($templine);
            $success = $stmt->execute();

            // Reset temp variable to empty
            $templine = '';
        }
    }
    if($success){
        echo '<div class="alert alert-success">
                <strong>Success!</strong> Database successfuly updated!
            </div>';
    }else{
        echo '<div class="alert alert-danger">
                <strong>Fail!</strong> Database failed to update!
            </div>';
    }
}
?>

<div class="container">
    <div class="jumbotron">
        <h1>Update Database</h1>
        <form action="" method="post">
            <button type="submit" class="btn btn-danger">UPDATE DATABASE</button>
        </form>
    </div>
</div>

</body>
</html>