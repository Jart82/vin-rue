<?php 
require "../../action/conn.php";
?>
<?php 
require "../admin_core.php";
?>
<?php 
if (edit_account($conn)) {
    header("Location:../success");
}
?>