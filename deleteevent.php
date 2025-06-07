<?php
// Show all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to DB
$link = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs340_cripeca', '5036', 'cs340_cripeca');
if (!$link) {
    http_response_code(500);
echo "Error deleting event: " . mysqli_error($link);
exit;

}

// Get the event ID from the POST request
$eventID = intval($_POST['eventID']);

if ($eventID > 0) {
    $delete_feedback_query = "DELETE FROM FEEDBACK WHERE eventID = $eventID";
    mysqli_query($link, $delete_feedback_query);
    // Delete the event's RSVP records first (if your schema enforces foreign key constraints)
    $delete_rsvp_query = "DELETE FROM RSVP WHERE eventID = $eventID";
    mysqli_query($link, $delete_rsvp_query);

    // Then delete associated clubs from EVENTCLUBS
    $delete_eventclubs_query = "DELETE FROM EVENTCLUBS WHERE eventID = $eventID";
    mysqli_query($link, $delete_eventclubs_query);

    // Finally, delete the event itself
    $delete_event_query = "DELETE FROM EVENTS WHERE eventID = $eventID";

    if (mysqli_query($link, $delete_event_query)) {
        header("Location: events.php");
        exit;
    } else {
        echo "Error deleting event: " . mysqli_error($link);
    }
} else {
    echo "Invalid event ID.";
}

mysqli_close($link);
http_response_code(200); // success
exit;

?>
