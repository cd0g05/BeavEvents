<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta and page settings -->
  <meta charset="UTF-8">
  <title>BeavEvents</title>

  <!-- Link to external stylesheet -->
  <link rel="stylesheet" href="assets/style.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="assets/InnerBgLogo.png">
</head>

<body>
  <!-- Wrapper for entire page content -->
  <div class="home-wrapper">

    <!-- Header section with logo and navigation menu -->
    <header class="home-header">
      <img src="assets/NoBackLogo.png" alt="BeavEvents Logo" class="logo" />
      
      <div class="head-col">
        <!-- Main title -->
        <h1 class="home-title">
          <span style="color: #D63F09; font-size: 80px;">Beav</span>
          <span style="color: #000000; font-size: 80px;">Events</span>
        </h1>

        <!-- Navigation bar -->
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

    <!-- Main content section -->
    <main class="home-content">
      <div class="body-text">
        <div class="create-event">
        <!-- Create Event Button -->
          <strong class="sub-subheader">Create an Event: <button class="tut-btn" onclick="toggleEventForm()">Add New Event</button></strong>
          <div id="add-event-form-container">
            <form action="backend/addevent.php" method="POST" class="event-form">
              <label>
                Event Name: <input type="text" name="eventTitle" required>
              </label><br>
              <label>
                Event Date: <input type="date" name="eventDate" required>
              </label><br>
              <label>
                Event Time: <input type="time" name="eventTime" required>
              </label><br>
              <label>
                Event Location: <input type="location" name="eventLocation" required>
              </label><br>
              <label>
                Description (optional): <input type="text" name="eventDescription">
              </label><br>
              <button type="submit" class="tut-btn">Submit Event</button>
            </form>
          </div>

        </div>
        <div class="all-club-box">
          
          <strong class="subheader">Upcoming Events:</strong>

          <?php
          // Enable error reporting

          ini_set('display_errors', 1);
          ini_set('display_startup_errors', 1);
          error_reporting(E_ALL);

          // Connect to MySQL database
          $link = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs340_cripeca', '5036', 'cs340_cripeca');
          if (!$link) {
              die("Connection failed: " . mysqli_connect_error());
          }

          // Query to get all events sorted by date
          $events_query = "SELECT * FROM EVENTS WHERE eventDate > NOW() ORDER BY eventDate ASC";
          $events_result = mysqli_query($link, $events_query);

          // Loop through each event
          while ($event = mysqli_fetch_assoc($events_result)) {
              $eventID = $event['eventID'];

              // Query to get total number of RSVPs for this event
              $total_rsvps_query = "SELECT COUNT(*) AS total FROM RSVP WHERE eventID = $eventID";
              $total_rsvps_result = mysqli_query($link, $total_rsvps_query);
              $total_rsvps = mysqli_fetch_assoc($total_rsvps_result)['total'];

              // Display event details
              echo "<div id='event-box-$eventID' class='club-box'>";

              echo "<div class='club-header-row'>";
              echo "<h2>" . htmlspecialchars($event['title']) . "</h2>";
              echo "<p><strong>Date:</strong> " . htmlspecialchars($event['eventDate']) . "</p>";
              echo "<p><strong>Location:</strong> " . htmlspecialchars($event['location']) . "</p>";
              echo "<p><strong>Total RSVPs:</strong> $total_rsvps</p>";

              // Event action buttons
              echo "<div class='table-button-box'>";
              echo "<button class='table-button' type='button' onclick='toggleForm($eventID)'>Add New Club</button>";
              echo "<button class='table-button' type='button' onclick='toggleRSVPForm($eventID)'>RSVP</button>";
              

              echo "<button type='button' class='table-button' onclick='deleteEvent(event, $eventID)'>Delete Event</button>";

              echo "</div>";
              echo "</div>";

              // Query clubs attending this event and their RSVP count
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

              // Display clubs table
              echo "<table style='width: 100%; border-collapse: collapse;'>";
              echo "<thead class='club-headers'>
                        <tr>
                          <th>Club</th>
                          <th>Advisor</th>
                          <th>Club ID</th>
                          <th>#RSVPs</th>
                          <th> </th>
                        </tr>
                    </thead>
                    <tbody>";

              // Loop through clubs for this event
              while ($club = mysqli_fetch_assoc($clubs_result)) {
                  echo "<tr id='club-row-{$eventID}-{$club['clubID']}'> ";
                  echo "<td>" . htmlspecialchars($club['name']) . "</td>";
                  echo "<td>" . htmlspecialchars($club['advisor']) . "</td>";
                  echo "<td>" . htmlspecialchars($club['clubID']) . "</td>";
                  echo "<td>" . htmlspecialchars($club['club_rsvp_count']) . "</td>";

                  // Form to remove club from event
                  echo "<td>";
                  echo "<form onsubmit='removeClub(event, {$eventID}, {$club['clubID']})' class='remove-club-form'>";
                  echo "<button type='submit' class='small-table-button'>Remove</button>";
                  echo "</form>";
                  echo "</td>";
                  echo "</tr>";
              }

              echo "</tbody></table>";

              // Query available clubs not already added to this event
              $available_clubs_query = "
                  SELECT clubID, name
                  FROM CLUB
                  WHERE clubID NOT IN (
                      SELECT clubID FROM EVENTCLUBS WHERE eventID = $eventID
                  )
              ";
              $available_clubs_result = mysqli_query($link, $available_clubs_query);

              // If available clubs found, display form to add them
              if (!$available_clubs_result) {
                  echo "<p>SQL Error: " . mysqli_error($link) . "</p>";
              } else if (mysqli_num_rows($available_clubs_result) > 0) {
                  echo "<div id='add-club-form-$eventID' class='add-club-form-container'>";
                  echo "<form action='backend/addclubtoevent.php' method='POST'>";
                  echo "<input type='hidden' name='eventID' value='" . htmlspecialchars($eventID) . "'>";
                  echo "<label for='clubID-$eventID'><strong>Add Club to Event:</strong></label> ";
                  echo "<select name='clubID' id='clubID-$eventID'>";

                  // Dropdown menu for selecting a club
                  while ($club_option = mysqli_fetch_assoc($available_clubs_result)) {
                      echo "<option value='" . htmlspecialchars($club_option['clubID']) . "'>" . htmlspecialchars($club_option['name']) . "</option>";
                  }

                  echo "</select> ";
                  echo "<button type='submit' class='table-button'>Add</button>";
                  echo "</form>";
                  echo "</div>";
              }
              // SQL Query returns all userid and names of users within the clubs attatched to the event
              $club_users_query = "
                CALL get_users_in_clubs($eventID);
              ";
              // stores names and ids from the above query into club_users_result
              $club_users_result = mysqli_query($link, $club_users_query);
              while (mysqli_more_results($link) && mysqli_next_result($link)) {
                // discard extra results from stored procedure
            }
              // echo "<p>RSVP query returned " . mysqli_num_rows($club_users_result) . " users for event $eventID</p>";

              // verifies that query worked
              if (!$club_users_result) {
                echo "<p>SQL Error: " . mysqli_error($link) . "</p>";
              } else {
                echo "<div id='rsvp-form-$eventID' class='rsvp-form-container'>";
                echo "<form action='backend/rsvptoevent.php' method='POST'>";
                echo "<input type='hidden' name='eventID' value='" . htmlspecialchars($eventID) . "'>";
                echo "<label for='userID-$eventID'><strong>RSVP to Event:</strong></label> ";
                echo "<select name='userID' id='userID-$eventID'>";
            
                if (mysqli_num_rows($club_users_result) === 0) {
                  echo "<option disabled selected>No users available</option>";
                  $disable_rsvp_button = true;
                } else {
                    $disable_rsvp_button = false;
                    while ($rsvp_option = mysqli_fetch_assoc($club_users_result)) {
                        echo "<option value='" . htmlspecialchars($rsvp_option['userID']) . "'>" . htmlspecialchars($rsvp_option['name']) . "</option>";
                    }
                }
            
                echo "</select> ";
                echo "<button type='submit' class='table-button' " . ($disable_rsvp_button ? "disabled" : "") . ">Submit RSVP</button>";
                echo "</form>";
                echo "</div>";
              }


              echo "</div>"; // End of .club-box
          }

          // Close database connection
          mysqli_close($link);
          ?>
        </div>

        <!-- Past Events -->

        <div class="all-club-box">
          
          <strong class="subheader">Past Events:</strong>

          <?php
          // Enable error reporting

          ini_set('display_errors', 1);
          ini_set('display_startup_errors', 1);
          error_reporting(E_ALL);

          // Connect to MySQL database
          $link = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs340_cripeca', '5036', 'cs340_cripeca');
          if (!$link) {
              die("Connection failed: " . mysqli_connect_error());
          }

          // Query to get all events sorted by date
          $events_query = "SELECT * FROM EVENTS WHERE eventDate < NOW() ORDER BY eventDate ASC;";
          $events_result = mysqli_query($link, $events_query);

          // Loop through each event
          while ($event = mysqli_fetch_assoc($events_result)) {
              $eventID = $event['eventID'];
              $event_rsvps_query = "
                  SELECT u.userID, u.name
                  FROM RSVP r
                  JOIN USERS u ON r.userID = u.userID
                  WHERE r.eventID = $eventID;
                ";
                // stores names and ids from the above query into club_users_result
                $event_rsvps_result = mysqli_query($link, $event_rsvps_query);

                // echo "<p>RSVP query returned " . mysqli_num_rows($club_users_result) . " users for event $eventID</p>";

                // verifies that query worked
                if (!$event_rsvps_result) {
                  echo "<p>SQL Error: " . mysqli_error($link) . "</p>";
                  file_put_contents("debug.txt", "ERROR with club users query", FILE_APPEND);

                }
              // Query to get total number of RSVPs for this event
              $total_rsvps_query = "SELECT COUNT(*) AS total FROM RSVP WHERE eventID = $eventID";
              $total_rsvps_result = mysqli_query($link, $total_rsvps_query);
              $total_rsvps = mysqli_fetch_assoc($total_rsvps_result)['total'];

              // Display event details
              echo "<div id='event-box-$eventID' class='club-box'>";

              echo "<div class='club-header-row'>";
              echo "<h2>" . htmlspecialchars($event['title']) . "</h2>";
              echo "<p><strong>Date:</strong> " . htmlspecialchars($event['eventDate']) . "</p>";
              echo "<p><strong>Location:</strong> " . htmlspecialchars($event['location']) . "</p>";
              echo "<p><strong>Attended:</strong> $total_rsvps</p>";

              // Event action buttons
              echo "<div class='table-button-box'>";
              

              echo "<button type='button' class='table-button' onclick='leaveFeedback(" . htmlspecialchars($eventID) . ")'>Leave Feedback</button>";

              echo "</div>";
              echo "</div>";

              // Query clubs attending this event and their RSVP count
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

              // Display clubs table
              echo "<table style='width: 100%; border-collapse: collapse;'>";
              echo "<thead class='club-headers'>
                        <tr>
                          <th>Club</th>
                          <th>Advisor</th>
                          <th>Club ID</th>
                          <th>#Attended</th>
                          <th> </th>
                        </tr>
                    </thead>
                    <tbody>";

              // Loop through clubs for this event
              while ($club = mysqli_fetch_assoc($clubs_result)) {
                
                

                echo "<tr id='club-row-{$eventID}-{$club['clubID']}'> ";
                echo "<td>" . htmlspecialchars($club['name']) . "</td>";
                echo "<td>" . htmlspecialchars($club['advisor']) . "</td>";
                echo "<td>" . htmlspecialchars($club['clubID']) . "</td>";
                echo "<td>" . htmlspecialchars($club['club_rsvp_count']) . "</td>";
                // file_put_contents("debug.txt", "5.3:\n", FILE_APPEND);

                // file_put_contents("debug.txt", $event_rsvps_result, FILE_APPEND);

                // Form to remove club from event
                // if (mysqli_num_rows($available_clubs_result) > 0) {
                  echo "<div id='user-form-$eventID' class='user-form' style='display: none;'>";
                  echo "<form method='POST' action='backend/leaveeventfeedback.php'>";
                  echo "<input type='hidden' name='clubID' value='" . htmlspecialchars($eventID) . "'>";

                  // User selection dropdown
                  echo "<label for='userID-$eventID'>Select User:</label>";
                  echo "<select name='userID' id='userID-$eventID' required>";
                  if (mysqli_num_rows($event_rsvps_result) === 0) {
                    echo "<option disabled selected>No users available</option>";
                    $disable_rsvp_button = true;
                  } else {
                      $disable_rsvp_button = false;
                      while ($rsvp_option = mysqli_fetch_assoc($event_rsvps_result)) {
                          echo "<option value='" . htmlspecialchars($rsvp_option['userID']) . "'>" . htmlspecialchars($rsvp_option['name']) . "</option>";
                      }
                  }
                  echo "</select>";
                  echo "<br>";

                  echo "<input type='text' name='feedback' placeholder='Feedback' required>";
                  // echo "<br></br>";

                  // Rating dropdown (1–5)
                  echo "<label for='rating-$eventID'>Rating: ";
                  echo "<select name='rating' id='rating-$eventID' required>";
                  for ($i = 5; $i > 0; $i--) {
                      echo "<option value='$i'>$i</option>";
                  }
                  echo "</select>";
                  echo "<p>    </p>";

                  echo "<button type='submit' class='small-table-button'>Submit</button>";
                  echo "</label>";

                  
                  echo "</form>";
                  echo "</div>";
              // }
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
      </div>   
    </main>

    <!-- Footer content with contact and attribution -->
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

  <!-- JavaScript for toggling the add club form visibility -->
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
    function leaveFeedback(eventID) {
      // console.log("Couldn't find eventid form for feedback:", eventID);
      const form = document.getElementById(`user-form-${eventID}`);
      if (form.style.display === "none") {
        form.style.display = "block";
      } else {
        form.style.display = "none";
      }
    }
  </script>

  <!-- Alternate toggle function using class toggling -->
  <script>
    function toggleForm(eventID) {
      const formDiv = document.getElementById('add-club-form-' + eventID);
      formDiv.classList.toggle('open');
    }
  </script>

  <script>
    function toggleRSVPForm(eventID) {
      const formDiv = document.getElementById('rsvp-form-' + eventID);
      if (formDiv) {
        formDiv.classList.toggle('open');
      } else {
        console.log("Couldn't find RSVP form for event:", eventID);
      }
    }
  </script>
  <script>
    function deleteEvent(e, eventID) {
      e.preventDefault();
      fetch('backend/deleteevent.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `eventID=${eventID}`
      })
      .then(response => {
        if (response.ok) {
          const box = document.getElementById(`event-box-${eventID}`);
          if (box) {
            box.classList.add('fade-out');
            setTimeout(() => box.remove(), 400);
          }
        } else {
          return response.text().then(text => { throw new Error(text); });
        }
      })
      .catch(err => {
        alert("Failed to delete event: " + err.message);
      });
    }

    </script>
    <!-- Add event script -->
    <script>
      function toggleEventForm() {
        const form = document.getElementById('add-event-form-container');
        form.classList.toggle('open');
      }
    </script>
    <script>
    function removeClub(e, eventID, clubID) {
      e.preventDefault();
      console.log("Doing remove club animation")
      fetch('backend/removeclubfromevent.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `eventID=${eventID}&clubID=${clubID}`
      })
      .then(response => {
        if (response.ok) {
          const row = document.getElementById(`club-row-${eventID}-${clubID}`);
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

</body>
</html>
