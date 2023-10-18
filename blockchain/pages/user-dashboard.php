<?php require_once '../includes/header.php' ?>
<?php require_once '../includes/outernav.php' ?>
 <style>
.menus
{
	padding:5px;
	padding-left:10px;
	padding-right:10px;
	text-decoration:none;
	font-family:Cambria;
	display:inline-table;
	border-radius:15px;
	border:1px solid #DFDFDF;
	background-color:#FFFFFF;
	
}
</style>
<div class="container mt-5">
    <div class="row">
	<center><h3 style="font-weight:bold; color:#333333; ">Welcome - <?php echo $_SESSION['username']." - ".$_SESSION['first_name']; ?>
		

	</h3>
	<div>
		<a href="user-dashboard.php" class="menus">Dashboard</a>
		<a href="user-view-poll.php" class="menus">Vote Poll</a>
		<a href="logout.php" class="menus" style="color:red;">Logout</a>
	</div>
	<hr />
		<div class="col-3">
		
			<br />
			<br />
	
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">View Polls</h5>
                    <p class="card-text">List all the active Polls available for users to cast their vote.</p>
                    <a href="./user-view-poll.php" class="btn btn-primary">View Polls</a>
                </div>
            </div>
        </div>
		</center>
    </div>
</div>
<?php require_once '../includes/footer.php' ?>
