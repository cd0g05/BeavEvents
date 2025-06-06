<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Establish a connection to the MySQL database.
// Arguments: hostname, username, password, database name.
$link = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs340_sextono', '0244', 'cs340_sextono');


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

$get_max_query = "SELECT MAX(clubID) AS maxID FROM CLUB";
$max_result = mysqli_query($link, $get_max_query);

if ($max_result && mysqli_num_rows($max_result) > 0) {
    $row = mysqli_fetch_assoc($max_result);
    $newClubID = $row['maxID'] + 1;
} else {
    $newClubID = 1;
}
$query = "INSERT INTO CLUB (name, advisor, category) VALUES ('$title', '$advis', '$cat')";
if (mysqli_query($link, $query)) {
    header("Location: clubs.php");
    exit;
} else {
    echo "Error: " . mysqli_error($link);
}

mysqli_close($link);
?>

