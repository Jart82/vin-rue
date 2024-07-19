<?php 
require "../../action/conn.php";
?>
<?php 
require "../admin_core.php";
?>
<?php 
$id = $conn -> real_escape_string( gget('id') );
if (adel($conn, $id)) {
    header("Location:../");
} else {
    header("Location:../500?msg=Unable to delete");
}
?>