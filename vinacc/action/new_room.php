<?php 
require "../../action/conn.php";
?>
<?php 
require "../admin_core.php";
?>
<?php 
if (add_new_room($conn)) {
    header("Location:../success");
}
?>