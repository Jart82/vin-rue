<?php 
require "../../action/conn.php";
?>
<?php 
require "../admin_core.php";
?>
<?php 
$pw = $conn -> real_escape_string( gpost('pw') );
$pw2 = $conn -> real_escape_string( gpost('pw2') );
$pw3 = $conn -> real_escape_string( gpost('pw3') );
if (login($conn,$pw)) {
    if ($pw2 == $pw3) {
        if (change_admin_pw($conn,$pw2)) {
            header("Location:../success");
        } else {
            header("Location:../500?msg=Could not perform action for some reason");
        }
    } else {
        header("Location:../500?msg=New passwords do not match");
    }
} else {
    header("Location:../500?msg=Old password is not correct");
}

function login($conn,$pw) {
    $pw_r = $conn->query("select password from password where id = 1")->fetch_assoc(); 
    if ($pw == $pw_r['password']) {
        return true;
    } else {
        return false;
    }
}
?>