<?php
session_start();

session_unset();
session_destroy();
header("location: login.php");
// echo '<a class="nav-link" href="login.php">logout</a>';
exit();

?>