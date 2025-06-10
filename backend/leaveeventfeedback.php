<?php
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

$query = "
  INSERT INTO FEEDBACK (userID, eventID, comment, rating)
  VALUES ($userID, $eventID, '$feedback', $rating)
  ON DUPLICATE KEY UPDATE
    comment = VALUES(comment),
    rating = VALUES(rating)
";

if (mysqli_query($link, $query)) {
    header("Location: ../events.php");
    exit;
} else {
    echo "Error submitting feedback: " . mysqli_error($link);
}

mysqli_close($link);
?>
