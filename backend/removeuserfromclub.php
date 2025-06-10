<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_log("InDel Form submitted with values: " . print_r($_POST, true));
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// Establish a connection to the MySQL database.
// Parameters: hostname, username, password, database name.
$link = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs340_cripeca', '5036', 'cs340_cripeca');

// Check if the connection was successful.
// If not, stop the script and display the error message.
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve and sanitize input from the form submitted via POST.
// intval() ensures the inputs are treated as integers (helps prevent SQL injection).
$clubID = intval($_POST['clubID']);
$userID = intval($_POST['userID']);

// Proceed only if both values are valid integers greater than 0.
if ($clubID >= 0 && $userID >= 0) {

    // Prepare the SQL DELETE query to remove the association between the club and the event.
    $delete_query = "DELETE FROM MEMBERSHIP WHERE clubID = $clubID AND userID = $userID";
    
    // Attempt to execute the DELETE query.
    if (mysqli_query($link, $delete_query)) {
        // If the query succeeds, redirect the user back to the events page.
        header("Location: ../clubs.php");
        // $delete_user_rsvp = "
        //     DELETE FROM RSVP
        //     WHERE userID NOT IN (
        //         SELECT userID FROM MEMBERSHIP
        //     )";
        // mysqli_query($link, $delete_user_rsvp);
        // $delete_user_feedback = "
        //     DELETE FROM FEEDBACK
        //     WHERE userID NOT IN (
        //         SELECT userID FROM MEMBERSHIP
        //     )";
        // mysqli_query($link, $delete_user_rsvp);
        // $delete_users = "
        //     DELETE FROM USERS
        //     WHERE userID = $userID";
        // mysqli_query($link, $delete_users);
        $call_del_users = "delete_users_not_in_membership()";
        if (mysqli_query($link, $call_del_users)) {
            exit;
        }
        else {
            echo "Error removing users: " . mysqli_error($link);
        }
    } else {
        // If there's an error during the query, display the error message.
        echo "Error removing user: " . mysqli_error($link);
    }

} else {
    // If either ID is invalid or missing, show a generic error message.
    echo "Invalid input.";
}

// Close the database connection to free up system resources.
mysqli_close($link);
?>
