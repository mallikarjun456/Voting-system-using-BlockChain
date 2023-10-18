<?php require_once '../includes/header.php' ?>
<?php require_once '../includes/nav.php' ?>

<?php Auth::guard_admin() ?>

<?php

// get info from an existing poll
// todo: use a hidden field value to store the poll id for existing
if (!empty($_SESSION['poll_id']) || !empty($_POST['hiddenPollID'])) {
    $temp_poll_id = !empty($_SESSION['poll_id']) ? $_SESSION['poll_id'] : $_POST['hiddenPollID'];

    unset($_SESSION['poll_id']);

    $db = new BallotBoxDB();
    $edit_poll = $db->get_poll($temp_poll_id);
    $db->close();

}  

if(!empty($edit_poll) && isset($_POST['txtPollName']) && isset($_POST['txtPollDesc'])) {
    // update poll details
    $opt1 = trim($_POST['txtOption1']);
    $opt2 = trim($_POST['txtOption2']);
    $opt3 = trim($_POST['txtOption3']);
    $opt4 = trim($_POST['txtOption4']);

    $db = new BallotBoxDB();
    $poll_updated = $db->update_poll($edit_poll['id'], trim($_POST['txtPollName']), trim($_POST['txtPollDesc']), $opt1, $opt2, $opt3, $opt4);
    $edit_poll = $db->get_poll($temp_poll_id);
    $db->close();

    $_POST = array();

} else if (empty($edit_poll) && isset($_POST['txtPollName']) && isset($_POST['txtPollDesc'])) {
    // creating for new poll
    $db = new BallotBoxDB();
    $opt1 = trim($_POST['txtOption1']);
    $opt2 = trim($_POST['txtOption2']);
    $opt3 = trim($_POST['txtOption3']);
    $opt4 = trim($_POST['txtOption4']);

    $poll_id = $db->create_poll(trim($_POST['txtPollName']), trim($_POST['txtPollDesc']), $opt1, $opt2, $opt3, $opt4);

    $db->close();
    $_POST = array();
}

?>
<center><div style="width:800px;">
<div class="container mt-5">
    <?php if (empty($edit_poll) && isset($poll_id) && $poll_id) { ?>
        <div class="row mb-3">
            <div class="col">
                <div class="alert alert-success">
                    Poll #
                    <?php echo $poll_id ?> has been created successfully.
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if(!empty($edit_poll) && !empty($poll_updated)) { ?>
        <div class="row mb-3">
            <div class="col">
                <div class="alert alert-success">
                    Poll # 
                    <?php echo $edit_poll['id'] ?> has been updated successfully.
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col">
            <h1>
                <?php empty($edit_poll) ? print("Create a Poll") : print("Update Poll") ?>
            </h1>
        </div>
    </div>

    <form action="create-poll.php" method="post">
        <!-- hidden field -->
        <input type="hidden" name="hiddenPollID" 
            value="<?php empty($edit_poll['id']) ? print('') : print($edit_poll['id']) ?>">
        <!-- .hidden field -->

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="txtPollName" style="float:left; font-weight:bold;">Poll Name</label>
                    <input required class="form-control"
                        value="<?php empty($edit_poll['poll_name']) ? print('') : print($edit_poll['poll_name']) ?>"
                        type="text" name="txtPollName" id="txtPollName" placeholder="Enter Poll Name">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <label for="txtPollDesc" style="float:left; font-weight:bold;">Poll Description</label>
                    <textarea required class="form-control" name="txtPollDesc" id="txtPollDesc" rows="5" placeholder="Poll Description"><?php empty($edit_poll['poll_desc']) ? print('') : print($edit_poll['poll_desc']) ?></textarea>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <label for="txtOption1" style="float:left; font-weight:bold;">Option 1</label>
                    <input required value="<?php empty($edit_poll['option_1']) ? print('') : print($edit_poll['option_1']) ?>" class="form-control" type="text" name="txtOption1" id="txtOption1" placeholder="option 1 ">
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="txtOption2" style="float:left; font-weight:bold;">Option 2</label>
                    <input required value="<?php empty($edit_poll['option_2']) ? print('') : print($edit_poll['option_2']) ?>" class="form-control" type="text" name="txtOption2" id="txtOption2" placeholder="option 2">
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="txtOption3" style="float:left; font-weight:bold;">Option 3</label>
                    <input required value="<?php empty($edit_poll['option_3']) ? print('') : print($edit_poll['option_3']) ?>" class="form-control" type="text" name="txtOption3" id="txtOption3" placeholder="option 3">
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="txtOption4" style="float:left; font-weight:bold;">Option 4</label>
                    <input required value="<?php empty($edit_poll['option_4']) ? print('') : print($edit_poll['option_4']) ?>" class="form-control" type="text" name="txtOption4" id="txtOption4" placeholder="option 4">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <input class="btn btn-primary" type="submit" value="<?php empty($edit_poll) ? print("Create Poll") : print("Update Poll") ?>">
            </div>
        </div>
    </form>
</div>
                         

<?php require_once '../includes/footer.php' ?>