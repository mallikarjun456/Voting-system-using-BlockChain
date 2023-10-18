<?php require_once '../includes/header.php' ?>
<?php require_once '../includes/nav.php' ?>

<?php Auth::guard_admin() ?>

<?php
if(!empty($_POST['txtOperation']) && !empty($_POST['txtId'])) {
    $operation = $_POST['txtOperation'];
    $userEntity = $_POST['txtId'];
    $_SESSION['user_entity_id'] = $userEntity;

    switch($operation) {
        case 'edit':
            header('location:create-user.php');
            break;
        case 'delete':
            $db = new BallotBoxDB();
            $delete_usr_success = $db->deleteUser($userEntity);

            $db->close();
            break;
    }
}
?>

<div class="container mt-5">
    <!-- hidden field -->
    <form method="POST" action="view-user.php" class="d-none">
        <input type="hidden" id="txtOperation" name="txtOperation">
        <input type="hidden" id="txtId" name="txtId">

        <input type="submit" value="userHiddenSubmit" id="userHiddenSubmit">
    </form>
    <!-- .hidden field -->

    <?php if(!empty($delete_usr_success)) { ?>
    <div class="row">
        <div class="col">
            <div class="alert alert-success">
                The user was deleted successfully
            </div>
        </div>
    </div>
    <?php } ?>

    <div class="row">
        <div class="col">
            <center><h1>View Users</h1></center>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            
            <table class="table">
                <thead>
                    <tr style="font-weight:bold;">
                        <td>ID</td>
                        <td>Username</td>
                        <td>First Name</td>
                        <td>Middle Name</td>
                        <td>Last Name</td>
						<td>Mobile Number</td>
						<td>Aadhar Number</td>
						<td>Voter ID Number</td>
						<td>DOB</td>
                        <!--<td>Admin</td>-->
                        <td>Actions</td>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    $db = new BallotBoxDB();
                    $rows = $db->get_users();
                    $user_exists = false;
                    ?>
                    <?php while($row = $rows->fetchArray(SQLITE3_ASSOC)) {
                    $user_exists = true; 
                    ?>
                    <tr>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['first_name'] ?></td>
                        <td><?php echo $row['middle_name'] ?></td>
                        <td><?php echo $row['last_name'] ?></td>
						<td><?php echo $row['mobile_number'] ?></td>
                        <td><?php echo $row['aadhar_no'] ?></td>
                        <td><?php echo $row['voter_id'] ?></td>
                        <td><?php echo $row['dob'] ?></td>
                        <!--<td><?php echo $row['is_admin'] ? "Yes" : "No" ?></td>-->
                        <td>
                            <button onclick="userAction(this)" class="btn btn-primary" userid="<?php echo $row['id'] ?>">Edit</button>
                            <button onclick="userAction(this)" class="btn btn-danger" userid="<?php echo $row['id'] ?>">Delete</button>
                        </td>
                    </tr>
                    <?php }; $db->close(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="../scripts/user.js"></script>
<? require_once '../includes/footer.php' ?>