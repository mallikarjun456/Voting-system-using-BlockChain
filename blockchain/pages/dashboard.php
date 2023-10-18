<?php require_once '../includes/header.php' ?>
<?php require_once '../includes/nav.php' ?>

<style>
.card{
	text-align:center;
}
.card-title
{
	text-transform:uppercase;
	color:orangered;
	font-weight:bold;
}
.btn
{
	font-weight:bold;
}
</style>
<div class="container mt-5">
    <div class="row">
    <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">View Polls</h5>
                    <p class="card-text">List all the active Polls available for users to cast their vote.</p>
                    <a href="./view-poll.php" class="btn btn-outline-primary">View Polls</a>
                </div>
            </div>
        </div>

        <?php if(Auth::is_admin()) { ?>
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create a Poll</h5>
                        <p class="card-text">Create a a Poll for your users to vote on.</p>
                        <a href="./create-poll.php" class="btn btn btn-outline-success">Create Poll</a>
                    </div>
                </div>
            </div>
            
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Voters</h5>
                        <p class="card-text">View all voters that are registered with the application.</p>
                        <a href="view-user.php" class="btn btn-outline-warning">View Voters</a>
                    </div>
                </div>
            </div>

            <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Create Voter</h5>
                    <p class="card-text">Create or register a voter for the application.</p>
                    <a href="create-user.php" class="btn btn-outline-primary">Create Voter</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php require_once '../includes/footer.php' ?>
