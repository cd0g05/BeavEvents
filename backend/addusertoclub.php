<?php
$link = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs340_cripeca', '5036', 'cs340_cripeca');
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$clubID = intval($_POST['clubID']);
$name = mysqli_real_escape_string($link, $_POST['name']);
$email = mysqli_real_escape_string($link, $_POST['email']);
$role = mysqli_real_escape_string($link, $_POST['role']);

$insert_user = "INSERT INTO USERS (name, email, role) VALUES ('$name', '$email', '$role')";
if (mysqli_query($link, $insert_user)) {
    $userID = mysqli_insert_id($link);
    $add_to_club = "INSERT INTO MEMBERSHIP (userID, clubID) VALUES ($userID, $clubID)";
    mysqli_query($link, $add_to_club);
    header("Location: ../clubs.php");
    exit;
} else {
    echo "Error: " . mysqli_error($link);
}

mysqli_close($link);
?>
