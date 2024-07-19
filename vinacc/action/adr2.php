<?php 
require "../../action/conn.php";
?>
<?php 
require "../admin_core.php";
?>
<?php 
if (edit_adr2($conn)) {
    header("Location:../success");
}
?>