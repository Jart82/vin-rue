<?php 
require "../../action/conn.php";
?>
<?php 
require "../admin_core.php";
?>
<?php 
if (set_apy($conn)) {
    header("Location:../success");
}
?>