<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BeavEvents</title>
  <link rel="stylesheet" href="assets/style.css">
  <link rel="icon" type="image/png" href="assets/InnerBgLogo.png">

</head>
<body>
<?php
$events = [
  [
    'event_id' => 1,
    'name' => 'Beaver Brawl',
    'clubs' => [
      [ 'club_id' => '001', 'advisor' => 'Darth Vader', 'name' => 'OSU Ultimate Frisbee Club - Beavs', 'rsvps' => '18' ],
      [ 'club_id' => '002', 'advisor' => 'Proffessor Dumbledor', 'name' => 'OSU Ultimate Frisbee Club - Dwarves', 'rsvps' => '11' ]
    ]
  ],
  [
    'event_id' => 2,
    'name' => 'Chess Tournament',
    'clubs' => [
      [ 'club_id' => '003', 'advisor' => 'Carter Cripe', 'name' => 'Chess Club', 'rsvps' => '27' ],
    ]
  ],
  [
    'event_id' => 3,
    'name' => 'Pickleball Tournamnet',
    'clubs' => [
      [ 'club_id' => '004', 'advisor' => 'Anakin Skywalker', 'name' => 'OSU Pickleball Club', 'rsvps' => '17' ],
      [ 'club_id' => '005', 'advisor' => 'Gandalf the Grey', 'name' => 'UO Pickleball Club', 'rsvps' => '34' ]
    ]
  ],
  [
    'event_id' => 4,
    'name' => 'Robotics club dinner',
    'clubs' => [
      [ 'club_id' => '006', 'advisor' => 'Clara Kim', 'name' => 'Robotics Club', 'rsvps' => '26' ],
    ]
  ]
];
?>
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
        <?php foreach ($events as $event): ?>
          <div class="club-box">
            <div class="club-header-row">
              <h2><?= htmlspecialchars($event['name']) ?></h2>
              <div class="table-button-box">
                <button class="table-button">Add new Club</button>
                <button class="table-button">Delete Event</button>
              </div>
            </div>
            <table style="width: 100%; border-collapse: collapse;">
              <thead class="club-headers">
                <tr>
                  <th>Club</th>
                  <th>Advisor</th>
                  <th>Club ID</th>
                  <th>#RSVPs</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($event['clubs'] as $club): ?>
                  <tr>
                    <td><?= htmlspecialchars($club['name']) ?></td>
                    <td><?= htmlspecialchars($club['advisor']) ?></td>
                    <td><?= htmlspecialchars($club['club_id']) ?></td>
                    <td><?= htmlspecialchars($club['rsvps']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endforeach; ?>
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

</body>
</html>
