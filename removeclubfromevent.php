<?php
// Establish a connection to the MySQL database.
// Parameters: hostname, username, password, database name.
$link = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs340_sextono', '0244', 'cs340_sextono');

// Check if the connection was successful.
// If not, stop the script and display the error message.
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve and sanitize input from the form submitted via POST.
// intval() ensures the inputs are treated as integers (helps prevent SQL injection).
$eventID = intval($_POST['eventID']);
$clubID = intval($_POST['clubID']);

// Proceed only if both values are valid integers greater than 0.
if ($eventID > 0 && $clubID > 0) {

    // Prepare the SQL DELETE query to remove the association between the club and the event.
    $delete_query = "DELETE FROM EVENTCLUBS WHERE eventID = $eventID AND clubID = $clubID";

    // Attempt to execute the DELETE query.
    if (mysqli_query($link, $delete_query)) {
        // If the query succeeds, redirect the user back to the events page.
        header("Location: events.php");
        exit;
    } else {
        // If there's an error during the query, display the error message.
        echo "Error removing club: " . mysqli_error($link);
    }

} else {
    // If either ID is invalid or missing, show a generic error message.
    echo "Invalid input.";
}

// Close the database connection to free up system resources.
mysqli_close($link);
?>
