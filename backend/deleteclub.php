<!-- Carter Cripe and Owen Sexton -->
<!-- Group 10 -->

<?php
// Show all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_log("InDel Form submitted with values: " . print_r($_POST, true));
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


// Connect to DB
$link = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs340_cripeca', '5036', 'cs340_cripeca');
if (!$link) {
    http_response_code(500);

echo "Error deleting event: " . mysqli_error($link);
exit;

}

error_log("InDel Form submitted with values: " . print_r($_POST, true));

// Get the event ID from the POST request
$clubID = intval($_POST['clubID']);

if ($clubID >= 0) {
    $userCount = -1;
    $check_query = "
    SELECT COUNT(*) as userCount
    FROM MEMBERSHIP
    WHERE clubID = $clubID";

    $result = mysqli_query($link, $check_query);
    if ($result) {
        // file_put_contents("debug.txt", "5.2\n", FILE_APPEND);
        // file_put_contents("debug.txt", $result, FILE_APPEND);

        $row = mysqli_fetch_assoc($result);
        $userCount = intval($row['userCount']);
        // file_put_contents("debug.txt", "5.3:\n", FILE_APPEND);

        // file_put_contents("debug.txt", $userCount, FILE_APPEND);

        
    }
    if ($userCount > 0) {
        $delete_eventclubs = "DELETE FROM EVENTCLUBS WHERE clubID = $clubID";
        mysqli_query($link, $delete_eventclubs);

        $delete_memberships = "
            DELETE FROM MEMBERSHIP
            WHERE clubID = $clubID";
        mysqli_query($link, $delete_memberships);
        $delete_user_rsvp = "
            DELETE FROM RSVP
            WHERE userID NOT IN (
                SELECT userID FROM MEMBERSHIP
            )";
        mysqli_query($link, $delete_user_rsvp);
        
        $delete_users = "
            DELETE FROM USERS
            WHERE userID NOT IN (
                SELECT userID FROM MEMBERSHIP
            )";
        mysqli_query($link, $delete_users);
    }
    // file_put_contents("debug.txt", "\nexit\n", FILE_APPEND);
    // file_put_contents("debug.txt", "6\n", FILE_APPEND);

    // Delete the event's MEMBERSHIP records first
    $delete_memb_query = "DELETE FROM MEMBERSHIP WHERE clubID = $clubID";
    mysqli_query($link, $delete_memb_query);

    // Then delete associated clubs from EVENTCLUBS
    $delete_eventclubs_query = "DELETE FROM EVENTCLUBS WHERE clubID = $clubID";
    mysqli_query($link, $delete_eventclubs_query);

    // Finally, delete the event itself
    $delete_club_query = "DELETE FROM CLUB WHERE clubID = $clubID";
    // file_put_contents("debug.txt", "7\n", FILE_APPEND);

    if (mysqli_query($link, $delete_club_query)) {
        header("Location: ../clubs.php");
        // file_put_contents("debug.txt", "8\n", FILE_APPEND);

        exit;
    } else {
        echo "Error deleting club: " . mysqli_error($link);
        // file_put_contents("debug.txt", "9\n", FILE_APPEND);

    }
} else {
    // file_put_contents("debug.txt", "10\n", FILE_APPEND);

    echo "Invalid club ID.";
}
// file_put_contents("debug.txt", "11\n", FILE_APPEND);

mysqli_close($link);
http_response_code(200); // success
exit;

?>
