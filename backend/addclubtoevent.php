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
$clubID = intval($_POST['clubID']);

// Proceed only if both IDs are valid integers greater than 0
if ($eventID >= 0 && $clubID >= 0) {
    
    // Prepare an SQL query to insert a new row into the EVENTCLUBS table,
    // effectively linking the selected club to the selected event.
    $insert_query = "INSERT INTO EVENTCLUBS (eventID, clubID) VALUES ($eventID, $clubID)";

    // Execute the query.
    if (mysqli_query($link, $insert_query)) {
        // If insertion is successful, redirect the user back to the Events page.
        header("Location: ../events.php");
        exit;
    } else {
        // If the query fails, output the error for debugging.
        echo "Error adding club to event: " . mysqli_error($link);
    }

} else {
    // If one or both IDs are invalid, show an error message.
    echo "Invalid event or club ID. $eventID + $clubID";
}

// Close the database connection to free up resources.
mysqli_close($link);
?>
