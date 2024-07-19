<?php 
require "../../action/conn.php";
?>
<?php 
require "../admin_core.php";
?>
<?php 
if (order($conn)) {
    header("Location:../success");
}
?>