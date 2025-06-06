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
          <li class="menu-item active"><a href="clubs.php">Clubs</a></li>
          <li class="menu-item"><a href="events.php">Events</a></li>
          <li class="menu-item"><a href="tutorial.php">Help</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <div class="home-content">
    <div class="body-text">
    <div class="create-event">
        <!-- Create Event Button -->
          <strong class="sub-subheader">Create a Club: <button class="tut-btn" onclick="toggleEventForm()">Add New Club</button></strong>
          <div id="add-event-form-container">
            <form action="addclub.php" method="POST" class="event-form">
              <label>
                Club Name: <input type="text" name="clubTitle" required>
              </label><br>
              <label>
                Club Advisor: <input type="text" name="clubAdvisor" required>
              </label><br>
              <label>
                Club Category: <input type="text" name="clubCategory" required>
              </label><br>
              
              <button type="submit" class="tut-btn">Submit Club</button>
            </form>
          </div>

        </div>
        <div class="all-club-box">
        <?php
        $link = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs340_sextono', '0244', 'cs340_sextono');

        if (!$link) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $query = "SELECT * FROM CLUB";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        while ($club = mysqli_fetch_assoc($result)) {
            $clubID = $club['clubID'];

            // Query to get total number of RSVPs for this event
            

            // Display event details
            echo "<div id='event-box-$clubID' class='club-box'>";

            echo "<div class='club-header-row'>";
            echo "<h2>" . htmlspecialchars($club['name']) . "</h2>";
            echo "<p><strong>Advisor:</strong> " . htmlspecialchars($club['advisor']) . "</p>";
            echo "<p><strong>Category:</strong> " . htmlspecialchars($club['category']) . "</p>";

            // Event action buttons
            echo "<div class='table-button-box'>";
            echo "<button class='table-button' type='button' onclick='toggleForm($clubID)'>Add New Club</button>";
            echo "<button class='table-button' type='button' onclick='toggleRSVPForm($clubID)'>RSVP</button>";
            

            echo "<button type='button' class='table-button' onclick='deleteEvent(event, $clubID)'>Delete Event</button>";

            echo "</div>";
            echo "</div>";

            

            // Display clubs table
            echo "<table style='width: 100%; border-collapse: collapse;'>";
            echo "<thead class='club-headers'>
                      <tr>
                        <th>Club Member</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>UserID</th>
                        <th> </th>
                      </tr>
                  </thead>
                  <tbody>";
            
            $club_users_query = "
              SELECT u.*
              FROM USERS u
              JOIN MEMBERSHIP m ON u.userID = m.userID
              WHERE m.clubID = $clubID";
            
            $club_users_result = mysqli_query($link, $club_users_query);

            while ($user = mysqli_fetch_assoc($club_users_result)) {
              echo "<tr id='club-row-{$clubID}-{$user['userID']}'>";
              echo "<td>" . htmlspecialchars($user['name']) . "</td>";
              echo "<td>" . htmlspecialchars($user['role']) . "</td>";
              echo "<td>" . htmlspecialchars($user['email']) . "</td>";
              echo "<td>" . htmlspecialchars($user['userID']) . "</td>";

              // Form to remove club from event
              echo "<td>";
              echo "<form onsubmit='removeUser(event, {$clubID}, {$user['userID']})' class='remove-club-form'>";
              echo "<button type='submit' class='small-table-button'>Remove</button>";
              echo "</form>";
              echo "</td>";
              echo "</tr>";
            }



            echo "</tbody></table>";

            // Query available clubs not already added to this event
            


            echo "</div>"; // End of .club-box
        }

        // Close database connection
        mysqli_close($link);
        ?>
      </div>

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
    function removeUser(e, clubID, userID) {
      e.preventDefault();

      fetch('removeuserfromclub.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `clubID=${clubID}&userID=${userID}`
      })
      .then(response => {
        if (response.ok) {
          const row = document.getElementById(`club-row-${clubID}-${userID}`);
          if (row) {
            row.classList.add('fade-out');
            setTimeout(() => row.remove(), 200);
          }
        } else {
          return response.text().then(text => { throw new Error(text); });
        }
      })
      .catch(err => {
        alert("Failed to remove club: " + err.message);
      });
    }
  </script>
  <script>
      function toggleEventForm() {
        const form = document.getElementById('add-event-form-container');
        form.classList.toggle('open');
      }
    </script>
</body>
</html>
