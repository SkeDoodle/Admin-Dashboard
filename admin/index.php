<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administration</title>
    <link rel="stylesheet" href="admin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>

<?php

include_once dirname(__DIR__) . '/Database.php';
$passwordError = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (!empty($login) || !empty($password)) {
        $db = new Database();
        $db->query("SELECT login, password, role, id FROM users WHERE login = :login");
        $db->bind(':login', $login);
        $row = $db->single();

        if($row && $password === $row['password']){
            session_start();
            $_SESSION['login'] = $login;
            $_SESSION['role'] = $row['role'];
            $_SESSION['id'] = $row['id'];
            header('Location: admin.php');
        }else{
            $passwordError = true;
        }
    }
}
?>
<div class="container">
    <div class="Absolute-Center is-Responsive">
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="login" placeholder="Identifiant" autocomplete="off" required value="Thomas">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" autocomplete="off" required value="pomme">
                <?php if($passwordError) : ?>
                    <div class="alert alert-danger">
                        <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Attention!</strong> Identifiant ou mot de passe incorrect.
                    </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <label><input type="checkbox" name="remember-me"> Se souvenir de moi</label>
                </div>
                <div class="col-sm-6 text-right">
                    <input type="submit" class="btn btn-default" value="Se connecter">
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>