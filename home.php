<?php 
session_start();
echo "Welcome ".$_SESSION['email'];
 ?>
 <a href="logout.php">Logout</a>