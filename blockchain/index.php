<?php require_once 'includes/outernav.php' ?>
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
	background-image:url('images/evoting.jpg') !important;
	background-repeat:no-repeat;
	background-size:100% 320%;
}
</style>

</head>
<body>
<center><img src="images/admin.png" style="height:100px; width:150px; margin-top:20px;"></center>
    <div class="container" style="margin-top:0px; width:500px;">
	
        <div class="row">
		
            <div class="col">
				<br />
                <center><h2>Admin Login</h2></center>

                <form method="post" action="pages/login.php">
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
						<center><a href="pages/create-user-outer.php" style="font-size:20px;font-weight:bold; color:Orangered;">Create New Voter account</a></center>
						<center><a href="pages/user-login.php" style="font-size:20px;font-weight:bold; color:Orangered;">Voter Login</a></center>
					</div>
                </form>
            </div>
        </div>
    </div>
    </body>
</html>