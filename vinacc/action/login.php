<?php 
require "../../action/conn.php";
?>
<?php 
function login($conn,$pw) {
    $pw_r = $conn->query("select password from password where id = 1")->fetch_assoc(); 
    if ($pw == $pw_r['password']) {
        $_SESSION['admin_online'] = 'online';
        return true;
    } else {
        return false;
    }
}
?>
<?php 
$pw = $conn -> real_escape_string( gpost('pw') );
if (login($conn,$pw)) {
    header("Location:../");
} else {
    header("Location:../login_error");
}
?>