<?php require_once '../includes/header.php' ?>
<?php require_once '../includes/nav.php' ?>

<?php Auth::guard_admin() ?>

<?php
function fetch_user_details($userEnitityID) {
    $db = new BallotBoxDB();
    $user_data = $db->get_user($userEnitityID);
    $db->close();

    return $user_data;
}

// edit an existing user
if(!empty($_SESSION['user_entity_id']) || !empty($_POST['user_entity_id'])) {
    $userEnitityID = !empty($_SESSION['user_entity_id']) ?  $_SESSION['user_entity_id'] : $_POST['user_entity_id'];

    // modify the data of the existing data
    if(!empty($_POST['txtUsername']) && !empty('txtPassword')) {
        $fName = trim($_POST['txtFName']);
        $mName = trim($_POST['txtMName']);
        $lName = trim($_POST['txtLName']);
		$aadhar_no = trim($_POST['aadharno']);
		$voter_id_no = trim($_POST['voteridno']);
		$dob = trim($_POST['dob']);
        $usrName = trim($_POST['txtUsername']);
        $pwd = trim($_POST['txtPassword']);
		$mobile_number = trim($_POST['mobile_number']);
        
        $db = new BallotBoxDB();
        $user_update_success = $db->updateUser($userEnitityID, $fName, $mName, $lName, $pwd,$mobile_number,$aadhar_no,$voter_id_no,$dob);
        $db->close();
    }
    $user_data = fetch_user_details($userEnitityID);
    unset($_SESSION['user_entity_id']);
}

if(empty($_POST['user_entity_id']) && !empty($_POST['txtUsername']) && !empty('txtPassword')) {
    set_error_handler(
        function ($severity, $message, $file, $line) {
            throw new ErrorException($message, $severity, $severity, $file, $line);
        }
    );
    
    $db = new BallotBoxDB();
    try {
        $fName = trim($_POST['txtFName']);
        $mName = trim($_POST['txtMName']);
        $lName = trim($_POST['txtLName']);
		$aadhar_no = trim($_POST['aadharno']);
		$voter_id_no = trim($_POST['voteridno']);
		$dob = trim($_POST['dob']);
        $usrName = trim($_POST['txtUsername']);
        $pwd = trim($_POST['txtPassword']);
		
		
	 
   $diff = (date('Y') - date('Y',strtotime($dob)));
   
	if($diff < 18)
	{ ?>
<center><div class="alert alert-warning" role="alert" style="width:600px; font-weight:bold; margin-top:10px;">
	You are under age child. You need to complete your 18 Years To Vote.
</div></center>
		
	<?php }
	else
	{	
         $created_user_id = $db->create_user($fName, $mName, $lName, $usrName, $pwd);
    }
	}	
	catch(Exception $ex) 
	{
        $errorMsg = $ex->getMessage();
    } 
	finally 
	{
        $db->close();

        //restore the previous error handler
        restore_error_handler();
    }
}
?>
<center><div style="width:800px;">
<div class="container mt-5">
    <div class="row">
        <div class="col">
            <h1><?php !empty($userEnitityID) ? "Update User" : "Create User" ?></h1>
        </div>
    </div>

    <?php if(!empty($created_user_id)) { ?>
        <div class="row mb-3">
            <div class="col">
                <div class="alert alert-success">
                    The user has been created successfully with ID #<?php echo $created_user_id ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if(!empty($user_update_success)) { ?>
        <div class="row mb-3">
            <div class="col">
                <div class="alert alert-success">
                    The user has been updated successfully.
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if(!empty($errorMsg)) { ?>
        <div class="row mb-3">
            <div class="col">
                <div class="alert alert-danger">
                    <?php echo "Operation Failed: $errorMsg" ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <form action="create-user.php" method="post" id="form-id">
        <!-- hidden form field -->
        <input type="hidden" value="<?php echo !empty($userEnitityID) ? $userEnitityID: '' ?>" name="user_entity_id">
        <!-- .hidden form field -->
		<h3>Voter Registration</h3>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="txtFName" style="float:left; font-weight:bold;">First Name</label>
                    <input value="<?php echo !empty($user_data) ? $user_data['first_name'] : '' ?>" required class="form-control" type="text" name="txtFName" id="txtFName" placeholder="Enter First Name">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <label for="mobile-number-field" style="float:left; font-weight:bold;">Middle Name</label>
                    <input value="<?php echo !empty($user_data) ? $user_data['middle_name'] : '' ?>" class="form-control" type="text" name="txtMName" id="txtMName" placeholder="Enter Middle Name">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <label for="txtLName" style="float:left; font-weight:bold;">Last Name</label>
                    <input value="<?php echo !empty($user_data) ? $user_data['last_name'] : '' ?>" required class="form-control" type="text" name="txtLName" id="txtLName" placeholder="Enter Last Name">
                </div>
            </div>
        </div>
		<div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <label for="aadharno" style="float:left; font-weight:bold;">Mobile No</label>
                    <input  value="<?php echo !empty($user_data) ? $user_data['mobile_number'] : '' ?>" type="number" required class="form-control" name="mobile_number" id="mobile_number" placeholder="Enter Mobile Number" />
                </div>
            </div>
        </div>
		<div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <label for="aadharno" style="float:left; font-weight:bold;">Aadhar Card No</label>
                    <input  value="<?php echo !empty($user_data) ? $user_data['aadhar_no'] : '' ?>"   type="number" required class="form-control" name="aadharno" id="aadharno" placeholder="Enter Aadhar Card No">
                </div>
            </div>
        </div>
		<div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <label for="voteridno" style="float:left; font-weight:bold;">Voter Id No</label>
                    <input value="<?php echo !empty($user_data) ? $user_data['voter_id'] : '' ?>"   type="text" required class="form-control"  name="voteridno" id="voteridno" placeholder="Enter Voting Id No">
                </div>
            </div>
        </div>
		<div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <label for="dob" style="float:left; font-weight:bold;">Date Of Birth</label>
                    <input value="<?php echo !empty($user_data) ? $user_data['dob'] : '' ?>"  type="date" required class="form-control" name="dob" id="dob">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <label for="txtUsername" style="float:left; font-weight:bold;">Username</label>
                    <input name="txtUsername" placeholder="Enter username"
                    class="form-control" type="text" id="txtUsername"
                    value="<?php echo !empty($user_data) ? $user_data['username'] : '' ?>" 
                    <?php echo !empty($user_data) ? 'readonly' : '' ?> required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="txtPassword" style="float:left; font-weight:bold;">Password</label>
                    <input placeholder="Enter password" value="<?php echo !empty($user_data) ? $user_data['password'] : '' ?>" required class="form-control" type="password" name="txtPassword" id="txtPassword">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <input class="btn btn-primary" type="submit" value="Submit" id="submit_btn_id" />
            </div>
        </div>
    </form>
</div>
</div></center>
<?php require_once '../includes/footer.php' ?>
<script src="code.jquery.com_jquery-1.9.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#submit_btn_id").click(function(){
	var mob_no_length = $("#mobile_number").val().length;
	var aadhar_no_length = $("#aadharno").val().length;
	
	if(mob_no_length!=10)
	{
		alert("Please enter 10 digit mobile number");
		$("#mobile_number").focus();
		return false;
	}
	else if(aadhar_no_length!=12)
	{
		alert("Please enter 12 digit Aadhar number");
		$("#aadharno").focus();
		return false;
	}
});

});
</script>