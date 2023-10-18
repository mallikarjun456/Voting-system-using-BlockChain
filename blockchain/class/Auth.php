<?php
class Auth {
    public static function is_admin() {
        return $_SESSION['is_admin'] == 1;
    }

    public static function guard_admin() {
        if(!self::is_admin()) {
            if(!empty($_SESSION['username'])) {
                // user logged but is not admin then route to 
                header('location:dashboard.php');
            }
        }
    }
}

?>