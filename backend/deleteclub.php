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
$clubID = intval($_POST['clubID']);

if ($clubID >= 0) {
    
    $club_users_query = "
    DELETE FROM USERS u
    JOIN MEMBERSHIP m ON u.userID = m.userID
    WHERE m.clubID = $clubID";
  
    $club_users_result = mysqli_query($link, $club_users_query);

    // Delete the event's MEMBERSHIP records first (if your schema enforces foreign key constraints)
    $delete_memb_query = "DELETE FROM MEMBERSHIP WHERE clubID = $clubID";
    mysqli_query($link, $delete_memb_query);

    // Then delete associated clubs from EVENTCLUBS
    $delete_eventclubs_query = "DELETE FROM EVENTCLUBS WHERE clubID = $clubID";
    mysqli_query($link, $delete_eventclubs_query);

    // Finally, delete the event itself
    $delete_club_query = "DELETE FROM CLUB WHERE clubID = $clubID";

    if (mysqli_query($link, $delete_club_query)) {
        header("Location: ../clubs.php");
        exit;
    } else {
        echo "Error deleting club: " . mysqli_error($link);
    }
} else {
    echo "Invalid club ID.";
}

mysqli_close($link);
http_response_code(200); // success
exit;

?>
