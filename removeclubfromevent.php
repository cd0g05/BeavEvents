<?php
$link = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs340_sextono', '0244', 'cs340_sextono');
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$eventID = intval($_POST['eventID']);
$clubID = intval($_POST['clubID']);

if ($eventID > 0 && $clubID > 0) {
    $delete_query = "DELETE FROM EVENTCLUBS WHERE eventID = $eventID AND clubID = $clubID";
    if (mysqli_query($link, $delete_query)) {
        header("Location: events.php");
        exit;
    } else {
        echo "Error removing club: " . mysqli_error($link);
    }
} else {
    echo "Invalid input.";
}

mysqli_close($link);
?>
