<?php require_once '../class/BallotBoxDB.php' ?>
<?php require_once '../class/Auth.php' ?>

<?php
session_start();
if(empty($_SESSION['username'])) {
    header('location:../index.php');
}

if(empty($title)) {
    $title = "Ballot Box";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Block Chain Voting System</title>

    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	
	<style>
body{
 background-image:url('../images/votebackimg.jpg')!important;
 background-repeat:no-repeat;
 background-size:100% 350%;

}
</style>
</head>
<body>