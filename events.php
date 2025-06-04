

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BeavEvents</title>
  <link rel="stylesheet" href="assets/style.css">
  <link rel="icon" type="image/png" href="assets/InnerBgLogo.png">

</head>
<body>
  
<div class="home-wrapper">
  <header class="home-header">
    <img src="assets/NoBackLogo.png" alt="BeavEvents Logo" class="logo" />
    <div class="head-col">
      <h1 class="home-title">
        <span style="color: #D63F09; font-size: 80px;">Beav</span>
        <span style="color: #000000; font-size: 80px;">Events</span>
      </h1>
      <nav class="menu-bar">
        <ul class="menu-list">
          <li class="menu-item"><a href="home.php">Home</a></li>
          <li class="menu-item"><a href="clubs.php">Clubs</a></li>
          <li class="menu-item active"><a href="events.php">Events</a></li>
          <li class="menu-item"><a href="tutorial.php">Help</a></li>
        </ul>
      </nav>
    </div>
  </header>

<main class="home-content">
  <div class="body-text">
    <strong class="sub-subheader">Create an Event: <button class="tut-btn">Add New Event</button></strong>
    <div class="all-club-box">
      <strong class="subheader">Upcoming Events:</strong>

      <?php
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);

      $link = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs340_sextono', '0244', 'cs340_sextono');
      if (!$link) {
          die("Connection failed: " . mysqli_connect_error());
      }

      $events_query = "SELECT * FROM EVENTS ORDER BY eventDate ASC";
      $events_result = mysqli_query($link, $events_query);

      while ($event = mysqli_fetch_assoc($events_result)) {
          $eventID = $event['eventID'];

          // Get total RSVP count for the event
          $total_rsvps_query = "SELECT COUNT(*) AS total FROM RSVP WHERE eventID = $eventID";
          $total_rsvps_result = mysqli_query($link, $total_rsvps_query);
          $total_rsvps = mysqli_fetch_assoc($total_rsvps_result)['total'];

          echo "<div class='club-box'>";
          echo "<div class='club-header-row'>";
          echo "<h2>" . htmlspecialchars($event['title']) . "</h2>";
          echo "<p><strong>Date:</strong> " . htmlspecialchars($event['eventDate']) . "</p>";
          echo "<p><strong>Location:</strong> " . htmlspecialchars($event['location']) . "</p>";
          echo "<p><strong>Total RSVPs:</strong> $total_rsvps</p>";
          echo "<div class='table-button-box'>";
          echo "<button class='table-button' type='button' onclick='toggleForm($eventID)'>Add New Club</button>";
          echo "<button class='table-button'>RSVP</button>";
          echo "<button class='table-button'>Delete Event</button>";
          echo "</div>";
          echo "</div>";

          // Clubs registered to the event
          $clubs_query = "
              SELECT 
                  c.clubID, c.name, c.advisor,
                  COUNT(r.userID) AS club_rsvp_count
              FROM EVENTCLUBS ec
              JOIN CLUB c ON ec.clubID = c.clubID
              LEFT JOIN MEMBERSHIP m ON c.clubID = m.clubID
              LEFT JOIN RSVP r ON r.userID = m.userID AND r.eventID = ec.eventID
              WHERE ec.eventID = $eventID
              GROUP BY c.clubID
          ";
          $clubs_result = mysqli_query($link, $clubs_query);

          echo "<table style='width: 100%; border-collapse: collapse;'>";
          echo "<thead class='club-headers'>
              <tr>
                  <th>Club</th>
                  <th>Advisor</th>
                  <th>Club ID</th>
                  <th>#RSVPs</th>
              </tr>
          </thead>
          <tbody>";

          while ($club = mysqli_fetch_assoc($clubs_result)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($club['name']) . "</td>";
              echo "<td>" . htmlspecialchars($club['advisor']) . "</td>";
              echo "<td>" . htmlspecialchars($club['clubID']) . "</td>";
              echo "<td>" . htmlspecialchars($club['club_rsvp_count']) . "</td>";
              echo "</tr>";
          }

          echo "</tbody></table>";

          // Add Club Form (moved outside the club loop)
          $available_clubs_query = "
              SELECT clubID, name
              FROM CLUB
              WHERE clubID NOT IN (
                  SELECT clubID FROM EVENTCLUBS WHERE eventID = $eventID
              )
          ";
          $available_clubs_result = mysqli_query($link, $available_clubs_query);

          if (!$available_clubs_result) {
              echo "<p>SQL Error: " . mysqli_error($link) . "</p>";
          } else if (mysqli_num_rows($available_clubs_result) > 0) {
            echo "<div id='add-club-form-$eventID' class='add-club-form-container'>";
            echo "<form action='addclubtoevent.php' method='POST'>";              echo "<input type='hidden' name='eventID' value='" . htmlspecialchars($eventID) . "'>";
              echo "<label for='clubID-$eventID'><strong>Add Club to Event:</strong></label> ";
              echo "<select name='clubID' id='clubID-$eventID'>";
              while ($club_option = mysqli_fetch_assoc($available_clubs_result)) {
                  echo "<option value='" . htmlspecialchars($club_option['clubID']) . "'>" . htmlspecialchars($club_option['name']) . "</option>";
              }
              echo "</select> ";
              echo "<button type='submit' class='table-button'>Add</button>";
              echo "</form>";
              echo "</div>";
          }

          echo "</div>"; // end .club-box
      }

      mysqli_close($link);
      ?>
    </div>
  </div>   
</main>


  <footer class="footer">
    <div class="footer-main">
      <div class="footer-column">
        <h4>Authors</h4>
        <p>Website by Carter Cripe, Owen Sexton</p>
        <p>Phone: (970) 581-8720</p>
      </div>
      <div class="footer-column">
        <h4>Contact</h4>
        <p>Carter's Email: cripeca@oregonstate.edu</p>
        <p>Owen's Email: sextono@oregonstate.edu</p>
      </div>
      <div class="footer-column">
        <h4>Social</h4>
        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">Instagram</a>
        <a href="https://x.com/carter_cripe" target="_blank"><p>Twitter</p></a>
      </div>
      <div class="footer-column">
        <h4>Image credit</h4>
        <p>BeavEvents Logo created by DALL-e</p>
      </div>
    </div>
    <div class="footer-bar">
      <p>© 2025 BeavEvents — All rights reserved.</p>
    </div>
  </footer>
</div>
<script>
  function toggleForm(eventID) {
    const formDiv = document.getElementById('add-club-form-' + eventID);
    if (formDiv.style.display === 'none') {
      formDiv.style.display = 'block';
    } else {
      formDiv.style.display = 'none';
    }
  }
</script>
<script>
function toggleForm(eventID) {
  const formDiv = document.getElementById('add-club-form-' + eventID);
  formDiv.classList.toggle('open');
}
</script>
</body>
</html>
