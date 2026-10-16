<?php
require_once 'config.php';
if (isLoggedIn()) {
    session_destroy();
}
redirect('/giris.php');
?>
