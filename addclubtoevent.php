<?php
$link = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs340_sextono', '0244', 'cs340_sextono');
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$eventID = intval($_POST['eventID']);
$clubID = intval($_POST['clubID']);

if ($eventID > 0 && $clubID > 0) {
    $insert_query = "INSERT INTO EVENTCLUBS (eventID, clubID) VALUES ($eventID, $clubID)";
    if (mysqli_query($link, $insert_query)) {
        header("Location: events.php"); // Redirect back to events page
        exit;
    } else {
        echo "Error adding club to event: " . mysqli_error($link);
    }
} else {
    echo "Invalid event or club ID.";
}

mysqli_close($link);
?>
