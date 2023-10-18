<?php require_once '../includes/header.php' ?>
<?php require_once '../includes/nav.php' ?>

<?php require_once '../class/Block.php' ?>
<?php require_once '../class/Blockchain.php' ?>

<?php
$page_show = 0;
// check if user already voted for this poll
$blockchain = Blockchain::getChain();
$userVotedAlready = hasUserVoted($blockchain);

function hasUserVoted($blockchain) {
    foreach ($blockchain as $block) {
        if($block->pollID == $_SESSION['poll_id'] && $block->userID == $_SESSION['user_id']) {
            return true;
        }
    }

    return false;
}
$db = new BallotBoxDB();

$user_data = $db->get_user($_SESSION['user_id']);
$mobile_number	=	$user_data['mobile_number'];

if(!empty($_SESSION['poll_id']) || !empty($_POST['poll_id'])) {
    $temp_poll_id = !empty($_SESSION['poll_id']) ? $_SESSION['poll_id'] : $_POST['poll_id'];

    // todo: uncomment the below line
    // unset($_SESSION['poll_id'], $_POST['poll_id']);
    $db = new BallotBoxDB();
    $poll = $db->get_poll($temp_poll_id);
    $db->close();
}

if(!empty($_POST['radioVote']) && !empty($_POST['poll_id'])) 
{
	$_SESSION['w_radiovote']	=	$_POST['radioVote'];
	$_SESSION['w_poll_id']		=	$_POST['poll_id'];
	
	$random_val = rand(50000,100000);
		
	$_SESSION['vote_otp']	=	$random_val;
		
	$whatsapp_message = "
💥💥💥💥💥💥💥💥 \n
*BLOCKCHAIN VOTING SYSTEM*

Use OTP For Voting : $random_val

 \n\n Note:Automatic Software Message".
"\n💥💥💥💥💥💥💥💥";

	$url =	"http://web.cloudwhatsapp.com/wapp/api/send?apikey=9535e4d72c4f4c309d22ea0737578a29&mobile=$mobile_number&msg=".urlencode($whatsapp_message);
	$response = file_get_contents($url);
	$page_show = 1;	
}

if(isset($_POST['user_otp']))
{
	$otp 		= 	$_POST['user_otp'];
	$session_otp=	$_SESSION['vote_otp'];
	
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
		//$_SESSION['w_radiovote']	=	$_POST['radioVote'];
		//$_SESSION['w_poll_id']		=	$_POST['poll_id'];
	
		$block = new Block($_SESSION['w_poll_id'], $_SESSION['user_id'], $_SESSION['w_radiovote']);
		$voteSuccess = Blockchain::addBlock($block);
	}
}
?>

<div class="container mt-5">
<?php if(!empty($voteSuccess) && $voteSuccess) { ?>
    <div class="row mb-3">
        <div class="col">
            <div class="alert alert-success">
                The vote has been recorded successfully!
				<a href="user-dashboard.php">Back To Dashbaord</a>
            </div>
        </div>
    </div>
    <?php } ?>

    <?php if($userVotedAlready && empty($_POST['poll_id'])) { ?>
    <div class="row mb-3">
        <div class="col">
            <div class="alert alert-danger">
                You have already voted for this poll.
            </div>
        </div>
    </div>
    <?php } ?>
<style>
body{
	text-align:center;
}
.form-check
{
	border:1px solid #CCCCCC;
	background-color:#e6ffcc;
	padding:9px;
	padding-left:55px;
	font-size:25px;
	color:#333;
	width:45%;
	font-weight:bold;
	border-radius:25px;
	margin:auto;
	text-align:left;
	margin-top:25px;
}
</style>
<?php
		if($page_show==0)
		{
	?>
    <form action="vote.php" method="post">
        <!-- Hidden Field -->
        <input type="hidden" name="poll_id" value="<?php !empty($_SESSION['poll_id']) ? print($_SESSION['poll_id']) : print('') ?>">
        <!-- .Hidden Field -->

        <div class="row">
            <div class="col">
                <h3><?php echo $poll['poll_name'] ?></h3>
                <h5 class="mt-1"><?php echo $poll['poll_desc'] ?></h5>
            </div>
        </div>

        <!-- Options -->
        <div class="row mt-3">
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radioVote" id="radioVote1" value="<?php echo $poll['option_1'] ?>">
                    <label class="form-check-label" for="radioVote1">
                        <?php echo $poll['option_1'] ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radioVote" id="radioVote2" value="<?php echo $poll['option_2'] ?>">
                    <label class="form-check-label" for="radioVote2">
                        <?php echo $poll['option_2'] ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radioVote" id="radioVote3" value="<?php echo $poll['option_3'] ?>">
                    <label class="form-check-label" for="radioVote3">
                        <?php echo $poll['option_3'] ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radioVote" id="radioVote4" value="<?php echo $poll['option_4'] ?>">
                    <label class="form-check-label" for="radioVote4">
                        <?php echo $poll['option_4'] ?>
                    </label>
                </div>
            </div>
        </div>
        <!-- .Options -->

        <div class="row mt-3">
            <div class="col">
                <input type="submit" class="btn btn-primary" value="Vote" <?php $userVotedAlready || (!empty($voteSuccess) && $voteSuccess) ? print("disabled='true'") : print('') ?> style="width:300px; font-weight:bold; font-size:25px;">
            </div>
        </div>
    </form>
	<?php
		}
		else if($page_show==1)
		{
	?>
	  <form action="vote.php" method="post">
        <!-- hidden form field -->
        <input type="hidden" value="<?php echo !empty($userEnitityID) ? $userEnitityID: '' ?>" name="user_entity_id">
        <!-- .hidden form field -->
		<h3>OTP Verification For Voting</h3>
        <div class="row">
            <div class="col">
                <div class="form-group" style="width:45%; margin:auto;">
                    <label for="txtFName" style="float:left; font-weight:bold;">Enter OTP</label>
                    <input value="" required class="form-control" type="text" name="user_otp" id="" placeholder="Enter OTP" />
                </div>
            </div>
        </div>
		 <div class="row mt-3">
            <div class="col">
                <input class="btn btn-primary" type="submit" value="Submit">
            </div>
        </div>
	</form>
	<?php
		}
	?>
</div>

<?php require_once '../includes/footer.php' ?>