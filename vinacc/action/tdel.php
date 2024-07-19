<?php 
require "../../action/conn.php";
?>
<?php 
require "../admin_core.php";
?>
<?php 
$id = $conn -> real_escape_string( gget('id') );
$table = $conn -> real_escape_string( gget('table') );
if (tdel($conn, $table,$id)) {
    header("Location: ".$_SERVER['HTTP_REFERER']);
} else {
    header("Location:../500?msg=Unable to delete");
}
?>