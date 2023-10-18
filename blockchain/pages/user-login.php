<?php
require_once '../class/BallotBoxDB.php';
$db = new BallotBoxDB();

if(isset($_POST['txtUsername']))
{
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
		echo 878787;
		header('location:user-dashboard.php');
	}
	else {
	}
}
?>
<?php require_once '../includes/outernav.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<style>
body
{
	background-image:url('../images/evoting.jpg') !important;
	background-repeat:no-repeat;
	background-size:100% 320%;
}
</style>

</head>
<body>




<center><img src="../images/user.png" style="height:150px; width:200px; margin-top:20px;"></center>
    <div class="container" style="margin-top:40px; width:500px;">
        <div class="row">
            <div class="col">
                
<center><h2>USER LOGIN</h2></center>

                <form method="post" action="user-login.php">
                    <div class="form-group">
                        <label for="txtUsername">Username</label>
                        <input class="form-control" required type="text" name="txtUsername" id="txtUsername" placeholder="User name">
                    </div>

                    <div class="form-group">
                        <label for="txtPassword">Password</label>
                        <input class="form-control" required type="password" name="txtPassword" id="txtPassword" placeholder="Password">
                    </div>

                    <div class="form-group mt-3">
                        <center><input class="btn btn-primary" type="submit" value="Submit"></center>
                    </div>
					<div>
					<br />
						<center><a href="create-user-outer.php" style="font-size:20px; font-weight:bold; color:Orangered;">Create New Voter account</a></center>
					</div>
                </form>
            </div>
        </div>
    </div>
    </body>
</html>