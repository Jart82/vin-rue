<?php 
require "../conn.php";

$name = $conn->real_escape_string(gpost('name'));
$email = $conn->real_escape_string(gpost('email'));
$phone = $conn->real_escape_string(gpost('phone'));
$guest = $conn->real_escape_string(gpost('guest'));
$date = $conn->real_escape_string(gpost('date'));
$h_id = $conn->real_escape_string(gpost('id'));

$error = '';

if (empty($name)) {
    $error = "Name is required.";
} elseif (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
    $error = "Only letters and white space allowed in name.";
}

if (empty($email)) {
    $error = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format.";
}

if (empty($phone)) {
    $error = "Phone number is required.";
} elseif (!preg_match("/^[0-9]{10,15}$/", $phone)) {
    //$error = "Invalid phone number format.";
}

if (empty($guest)) {
    $error = "Number of guests is required.";
} elseif (!is_numeric($guest) || $guest < 1) {
    $error = "Invalid number of guests.";
}

if ($error != '') {
    retmsg($error);
} else {
    $hotel = table_get('hotel',"id=$h_id", $conn)->fetch_assoc();
    $title = $hotel['title']; $price = $hotel['price']; 
    if (insert_data("hotel_id,title,price,duration,guests,email,phone,name,status", "$h_id,'$title', $price,'$date' , $guest, '$email', '$phone', '$name' , 'Pending'", 'orders',$conn)) {
        retmsg('yes');
    }
    retmsg('Unable to book appartment');
}

?>
