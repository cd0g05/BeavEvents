<?php
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
$eventID = intval($_POST['eventID']);
$userID = intval($_POST['userID']);

// Proceed only if both IDs are valid integers greater than 0
if ($eventID > 0 && $userID > 0) {
    
    // Prepare an SQL query to insert a new row into the EVENTCLUBS table,
    // effectively linking the selected club to the selected event.
    $insert_query = "INSERT INTO RSVP (eventID, userID, time) VALUES ($eventID, $userID, NOW())";

    // Execute the query.
    if (mysqli_query($link, $insert_query)) {
        // If insertion is successful, redirect the user back to the Events page.
        header("Location: events.php");
        exit;
    } else {
        // If the query fails, output the error for debugging.
        echo "Error adding rsvp to event: " . mysqli_error($link);
    }

} else {
    // If one or both IDs are invalid, show an error message.
    echo "Invalid event or user ID. $eventID + $userID";
}

// Close the database connection to free up resources.
mysqli_close($link);
?>
