<?php 
session_start();
?>
<?php 
$_SESSION['admin_online'] = 'offline';
header("Location: /");
?>