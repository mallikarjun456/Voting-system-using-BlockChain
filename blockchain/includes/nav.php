<?php require_once '../class/Blockchain.php' ?>

<?php 
// check the validity of the blockchain
if(!Blockchain::isChainValid()) {
    header('location:invalid-blockchain.php');
}
?>

<!-- navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light"  style="background-color:#666666 !important">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php" style="font-weight:bold; color:#FFFFFF;">Block Chain Voting System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown" style="float:right; font-weight:bold; color:#FFFFFF !important; position:absolute; right:10px;">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false" style="color:#FFFFFF !important;">
                        Polls
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="view-poll.php" style="color:#333333 !important;">List Polls</a></li>
                        <?php if(Auth::is_admin()) { ?>
                            <li><a class="dropdown-item" href="create-poll.php" style="color:#333333 !important;">Create</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php if(Auth::is_admin()) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false" style="color:#FFFFFF !important;">
                        Users
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="view-user.php" style="color:#333333 !important;">View</a></li>
                        <li><a class="dropdown-item" href="create-user.php" style="color:#333333 !important;">Create</a></li>
                    </ul>
                </li>
                <?php } ?>
            </ul>

            <span class="navbar-text float-end ms-auto mb-2 mb-lg-0" style="color:#FFFFFF !important;"> (<a href="logout.php"  style="color:#FF0000 !important;">Logout</a>)</span>
        </div>
    </div>
</nav>
<!-- .navigation -->