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
$title = mysqli_real_escape_string($link, $_POST['eventTitle']);
$date = $_POST['eventDate'];
$time = $_POST['eventTime'];
$desc = mysqli_real_escape_string($link, $_POST['eventDescription']);
$loc = mysqli_real_escape_string($link, $_POST['eventLocation']);

$get_max_query = "SELECT MAX(eventID) AS maxID FROM EVENTS";
$max_result = mysqli_query($link, $get_max_query);

if ($max_result && mysqli_num_rows($max_result) > 0) {
    $row = mysqli_fetch_assoc($max_result);
    $newEventID = $row['maxID'] + 1;
} else {
    $newEventID = 1; // First entry in the table
}
$query = "INSERT INTO EVENTS (eventID, title, description, eventDate, time, location) VALUES ('$newEventID', '$title', '$desc', '$date', '$time', '$loc')";
if (mysqli_query($link, $query)) {
    header("Location: events.php");
    exit;
} else {
    echo "Error: " . mysqli_error($link);
}

mysqli_close($link);
?>
?>
