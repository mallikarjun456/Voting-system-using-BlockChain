<?php

require_once '../class/BallotBoxDB.php';
$db = new BallotBoxDB();
$user = $db->login($_POST['txtUsername'], $_POST['txtPassword']);
$db->close();


if(!empty($user)) {
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $_POST['txtUsername'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['middle_name'] = $user['middle_name'];
    $_SESSION['last_name'] = $user['last_name'];
    $_SESSION['is_admin'] = $user['is_admin'];
    
    header('location:dashboard.php');
}
else {
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>

    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <h1>Invalid User Credentials</h1>
                <p>Please navigate to the login and enter valid credentials.</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <a class="btn btn-primary" href="/">Go Back</a>
            </div>
        </div>
    </div>
</body>
<?php } ?>