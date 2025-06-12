<!-- Carter Cripe and Owen Sexton -->
<!-- Group 10 -->

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

mysqli_report(MYSQLI_REPORT_OFF);

$link = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs340_cripeca', '5036', 'cs340_cripeca');
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$eventID = isset($_POST['clubID']) ? intval($_POST['clubID']) : 0;  // still being passed as "clubID"
$userID = isset($_POST['userID']) ? intval($_POST['userID']) : 0;
$feedback = isset($_POST['feedback']) ? mysqli_real_escape_string($link, $_POST['feedback']) : '';
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

if ($eventID <= 0 || $userID <= 0 || $rating < 1 || $rating > 5 || empty($feedback)) {
    die("Invalid input.");
}
file_put_contents("debug.txt", "6\n", FILE_APPEND);

$query = "
  INSERT INTO FEEDBACK (userID, eventID, comment, rating)
  VALUES ($userID, $eventID, '$feedback', $rating)
  ON DUPLICATE KEY UPDATE
    comment = VALUES(comment),
    rating = VALUES(rating)
";
file_put_contents("debug.txt", "7\n", FILE_APPEND);

$result = mysqli_query($link, $query);

if ($result) {
    file_put_contents("debug.txt", "8\n", FILE_APPEND);
    header("Location: ../events.php");
    exit;
} else {
    $error_message = mysqli_error($link);
    file_put_contents("debug.txt", "Error: " . $error_message . "\n", FILE_APPEND);

    if (strpos($error_message, 'User has already submitted feedback') !== false) {
        header("Location: ../events.php?error=duplicate_feedback");
        exit;
    } else {
        echo "Error submitting feedback: " . $error_message;
    }
}

mysqli_close($link);
?>
