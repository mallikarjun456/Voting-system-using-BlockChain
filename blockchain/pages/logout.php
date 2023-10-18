<?php require_once '../includes/header.php' ?>

<?php session_destroy() ?>

<div class="container mt-5">
    <div class="row">
        <div class="col">
            <h1>Logout</h1>
            <p class="">
                You have been successfully logged out from the application.
            </p>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
        <a href="../index.php" class="btn btn-primary">Login</a>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php' ?>