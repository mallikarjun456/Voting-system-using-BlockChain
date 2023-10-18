<?php require_once '../includes/header.php' ?>
<?php require_once '../includes/outernav.php' ?>

<?php
if(!empty($_POST['txtOperation']) && !empty($_POST['txtId'])) {
    $pollID = trim($_POST['txtId']);
    $action = trim($_POST['txtOperation']);

    $_SESSION['poll_id'] = $pollID;

    switch($action) {
        case 'vote':
            header('location:vote.php');
            break;
        case 'edit':
            header('location:create-poll.php');
            break;
        case 'report':
            header('location:poll-report.php');
            break;
        case 'delete':
            $db = new BallotBoxDB();
            $deleted = $db->delete_poll($pollID);
            $db->close();
            break;
    }

    $_POST = array();
}

?>
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
	
        <div class="col">
           <center> <h1>View Polls</h1></center>
        </div>
    </div>

    <!-- Hidden form -->
    <div class="d-none">
        <form method="POST" action="view-poll.php">
            <input type="hidden" name="txtOperation" id="txtOperation">
            <input type="hidden" name="txtId" id="txtId">

            <input type="submit" id="pollHiddenSubmit" value="hidden submit">
        </form>
    </div>
    <!-- .Hidden form -->

    <div class="row mt-3">
        <div class="col">
            <table class="table">
                <thead>
                    <tr style="font-weight:bold;">
                        <td>ID</td>
                        <td>Poll Name</td>
                        <td>Poll Description</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                $db = new BallotBoxDB();
                $rows = $db->get_polls();
                
                $poll_exists = false;
				$counter = 0;
                while($row = $rows->fetchArray(SQLITE3_ASSOC)) {
                    $poll_exists = true;
                ?>
                    <tr>
                        <td><?php echo $counter +1; //$row['id'] ?></td>
                        <td><?php echo $row['poll_name'] ?></td>
                        <td><?php echo $row['poll_desc'] ?></td>
                        <td>
                            <button pollid="<?php echo $row['id'] ?>" class="btn btn-success" onclick="pollAction(this)">Vote</button>
                            
                        </td>
                    </tr>
                <?php $counter++; } $db->close(); ?>

                <?php if(!$poll_exists) { ?>
                    <tr>
                        <td colspan="4">No records found.</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="../scripts/poll.js"></script>

<? require_once '../includes/footer.php' ?>