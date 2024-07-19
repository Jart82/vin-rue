<?php 
require "../../action/conn.php";
?>
<?php 
require "../admin_core.php";
?>
<?php 
if (edit_adr($conn)) {
    header("Location:../success");
}
?>