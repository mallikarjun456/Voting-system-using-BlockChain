<?php require_once '../includes/headeruser.php' ?>
<?php require_once '../includes/outernav.php' ?>

<?php Auth::guard_admin() ?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$page_show = 0;
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
        $pwd = trim($_POST['txtPassword']);
        
        $db = new BallotBoxDB();
        $user_update_success = $db->updateUser($userEnitityID, $fName, $mName, $lName, $pwd);
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
		$mobile_number = trim($_POST['mobile_number']);
		
		$diff = (date('Y') - date('Y',strtotime($dob)));

		$exist_mob_no = 0;
		$user_data_new = $db->get_users_from_mob_no($mobile_number);
		if(!empty($user_data_new))
		{
			$exist_mob_no = 1;
		}
		
		if($exist_mob_no=="")
		{
			?>
<center><div class="alert alert-warning" role="alert" style="width:600px; font-weight:bold; margin-top:10px;">
	This mobile number is already registered
</div></center>
		
	<?php 
		}
		
	else if($diff < 18)
	{ ?>
<center><div class="alert alert-warning" role="alert" style="width:600px; font-weight:bold; margin-top:10px;">
	You are under age child. You need to complete your 18 Years To Vote.
</div></center>
		
	<?php 
	}
	else
	{
		$_SESSION['fName']	=	$fName;
		$_SESSION['mName']	=	$mName;
		$_SESSION['lName']	=	$lName;
		$_SESSION['mobile_number']	=	$mobile_number;
		$_SESSION['aadhar_no']	=	$aadhar_no;
		$_SESSION['voter_id_no']	=	$voter_id_no;
		$_SESSION['dob']	=	$dob;
		$_SESSION['usrName']	=	$usrName;
		$_SESSION['pwd']	=	$pwd;

		$random_val = rand(10000,50000);
		
		$_SESSION['mobile_number_otp']	=	$random_val;
		
		$whatsapp_message = "
💥💥💥💥💥💥💥💥 \n
*BLOCKCHAIN VOTING SYSTEM*

Dear $fName $lName,
You are creating account on blockchain based voting system. \n

Please verify your mobile number to create account: \n
OTP : $random_val
 \n\n Note:Automatic Software Message".
"\n💥💥💥💥💥💥💥💥";

	$url =	"http://web.cloudwhatsapp.com/wapp/api/send?apikey=9535e4d72c4f4c309d22ea0737578a29&mobile=$mobile_number&msg=".urlencode($whatsapp_message);
	$response = file_get_contents($url);
	$page_show = 1;	
	
         //$created_user_id = $db->create_user($fName, $mName, $lName, $usrName, $pwd);
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

if(isset($_POST['otp']))
{
	$otp = $_POST['otp'];
	$session_otp = $_SESSION['mobile_number_otp'];
	
	if($otp!=$session_otp)
	{
		?>
		<script>
		alert("Incorrect OTP");
		</script>
		<?php
		
		$page_show = 1;
	}
	else
	{
		$db = new BallotBoxDB();
		
		$fName	=	$_SESSION['fName'];
		$mName	=	$_SESSION['mName'];
		$lName	=	$_SESSION['lName'];
		$mobile_number	=	$_SESSION['mobile_number'];
		$aadhar_no	=	$_SESSION['aadhar_no'];
		$voter_id_no	=	$_SESSION['voter_id_no'];
		$dob	=	$_SESSION['dob'];
		$usrName	=	$_SESSION['usrName'];
		$pwd	=	$_SESSION['pwd'];
		
		
		$created_user_id = $db->create_user_outer($fName, $mName, $lName, $usrName, $pwd,$mobile_number,$aadhar_no,$voter_id_no,$dob);
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
	
	<?php
		if($page_show==0)
		{
	?>
    <form action="create-user-outer.php" method="post">
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
                    <label for="txtMName" style="float:left; font-weight:bold;">Middle Name</label>
                    <input value="<?php echo !empty($user_data) ? $user_data['middle_name'] : '' ?>" class="form-control" type="text" name="txtMName" id="txtMName" placeholder="Enter Middle Name" required>
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
                    <input  value="<?php echo !empty($user_data) ? $user_data['mobile_no'] : '' ?>"  type="number" required class="form-control" name="mobile_number" id="mobile_number" placeholder="Enter Mobile Number" />
                </div>
            </div>
        </div>
		<div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <label for="aadharno" style="float:left; font-weight:bold;">Aadhar Card No</label>
                    <input  value="<?php echo !empty($user_data) ? $user_data['aadhar_no'] : '' ?>"  type="number" required class="form-control" name="aadharno" id="aadharno" placeholder="Enter Aadhar Card No">
                </div>
            </div>
        </div>
		<div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <label for="voteridno" style="float:left; font-weight:bold;">Voter Id No</label>
                    <input  value="<?php echo !empty($user_data) ? $user_data['voter_id_no'] : '' ?>"  type="text" required class="form-control"  name="voteridno" id="voteridno" placeholder="Enter Voting Id No">
                </div>
            </div>
        </div>
		<div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <label for="dob" style="float:left; font-weight:bold;">Date Of Birth</label>
                    <input  value="<?php echo !empty($user_data) ? $user_data['dob'] : '' ?>" type="date" required class="form-control" name="dob" id="dob">
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
                <input class="btn btn-primary" type="submit" id="submit_btn_id" value="Submit">
            </div>
        </div>
    </form>
	
	
	<?php
		}
		else if($page_show==1)
		{
	?>
	  <form action="create-user-outer.php" method="post">
        <!-- hidden form field -->
        <input type="hidden" value="<?php echo !empty($userEnitityID) ? $userEnitityID: '' ?>" name="user_entity_id">
        <!-- .hidden form field -->
		<h3>Mobile Number OTP Verification</h3>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="txtFName" style="float:left; font-weight:bold;">Enter OTP</label>
                    <input value="" required class="form-control" type="text" name="otp" id="" placeholder="Enter OTP">
                </div>
            </div>
        </div>
		 <div class="row mt-3">
            <div class="col">
                <input class="btn btn-primary" onclick="functionToExecute()" type="submit" id="submit_btn_id" value="Submit" />
            </div>
        </div>
	</form>
	<?php
		}
	?>
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