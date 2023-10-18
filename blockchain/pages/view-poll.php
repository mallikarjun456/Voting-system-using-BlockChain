<?php require_once '../includes/header.php' ?>
<?php require_once '../includes/nav.php' ?>

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

<div class="container mt-5">
    <div class="row">
        <div class="col">
            <center><h1>View Polls</h1></center>
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

    <?php if(!empty($deleted)) { ?>
        <div class="row mb-3">
            <div class="col">
                <div class="alert alert-success">
                    Poll #<?php echo $pollID ?> has been deleted successfully.
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="row mt-3">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
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

                while($row = $rows->fetchArray(SQLITE3_ASSOC)) {
                    $poll_exists = true;
                ?>
                    <tr>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['poll_name'] ?></td>
                        <td><?php echo $row['poll_desc'] ?></td>
                        <td>
                            <button pollid="<?php echo $row['id'] ?>" class="btn btn-success" onclick="pollAction(this)">Vote</button>
                            <?php if(Auth::is_admin()) { ?>
                                <button pollid="<?php echo $row['id'] ?>" class="btn btn-primary" onclick="pollAction(this)">Edit</button>
                                <button pollid="<?php echo $row['id'] ?>" class="btn btn-primary" onclick="pollAction(this)">Report</button>
                                <button pollid="<?php echo $row['id'] ?>" class="btn btn-danger" onclick="pollAction(this)">Delete</button>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } $db->close(); ?>

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