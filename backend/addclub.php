<!-- Carter Cripe and Owen Sexton -->
<!-- Group 10 -->
 
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Establish a connection to the MySQL database.
// Arguments: hostname, username, password, database name.
$link = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs340_cripeca', '5036', 'cs340_cripeca');


// Check if the connection was successful.
// If not, output an error message and terminate the script.
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the event ID and club ID from the POST request sent by a form.
// Use intval() to ensure the values are integers, which prevents SQL injection.
$title = mysqli_real_escape_string($link, $_POST['clubTitle']);
$advis = mysqli_real_escape_string($link, $_POST['clubAdvisor']);
$cat = mysqli_real_escape_string($link, $_POST['clubCategory']);


$query = "INSERT INTO CLUB (name, advisor, category) VALUES ('$title', '$advis', '$cat')";
if (mysqli_query($link, $query)) {
    header("Location: ../clubs.php");
    exit;
} else {
    echo "Error: " . mysqli_error($link);
}

mysqli_close($link);
?>

