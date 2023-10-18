<?php require_once '../includes/header.php' ?>
<?php require_once '../includes/nav.php' ?>
<?php require_once '../class/Blockchain.php' ?>

<?php Auth::guard_admin() ?>

<?php
$poll_id = $_SESSION['poll_id'];
$db = new BallotBoxDB();
$poll_details = $db->get_poll($poll_id);
$db->close();

$blockchain = Blockchain::getChain();
$optVotes = array();
$totalVotes = 0;

foreach ($blockchain as $block) {
    if($block->pollID == $poll_id) {
        $totalVotes++;

        if(isset($optVotes[$block->data])) {
            $optVotes[$block->data] += 1; 
        }
        else {
            $optVotes[$block->data] = 1;
        }
    }
}

?>

<div class="container mt-5">
    <div class="row">
        <div class="col">
            <center><h1>Report</h1></center>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <label for="txtPollName">Poll Name</label>
                <input type="text" class="form-control" name="txtPollName" id="txtPollName" disabled value ="<?php echo $poll_details['poll_name'] ?>">
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <label for="txtPollDesc">Poll Descritption</label>
                <textarea id="txtPollDesc" name="txtPollDesc" class="form-control" disabled><?php echo $poll_details['poll_desc'] ?></textarea>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <label for="txtTotalVotes">Total Votes</label>
                <input type="text" class="form-control" name="txtTotalVotes" id="txtTotalVotes" disabled value ="<?php echo $totalVotes ?>">
            </div>
        </div>
    </div>
<style>
thead tr td{
	font-weight:bold;
	color:orangered !important;
	text-align:center;
}
tbody tr td{
	font-weight:bold;
	color:green !important;
	text-align:center;
}
</style>
    <div class="row mt-3">
        <div class="col">
            <h5>Vote Tally</h5>
            <table class="table">
                <thead>
                    <tr>
                        <td><?php echo $poll_details['option_1'] ?></td>
                        <td><?php echo $poll_details['option_2'] ?></td>
                        <td><?php echo $poll_details['option_3'] ?></td>
                        <td><?php echo $poll_details['option_4'] ?></td>
                    <tr>
                </thead>
                <tbody>
                    <?php if($totalVotes == 0) { ?>
                        <tr>
                            <td colspan="4">No votes has been casted for this poll.</td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td><?php !empty($optVotes[$poll_details['option_1']]) ? print($optVotes[$poll_details['option_1']]) : print(0) ?></td>
                            <td><?php !empty($optVotes[$poll_details['option_2']]) ? print($optVotes[$poll_details['option_2']]) : print(0) ?></td>
                            <td><?php !empty($optVotes[$poll_details['option_3']]) ? print($optVotes[$poll_details['option_3']]) : print(0) ?></td>
                            <td><?php !empty($optVotes[$poll_details['option_4']]) ? print($optVotes[$poll_details['option_4']]) : print(0) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php' ?>