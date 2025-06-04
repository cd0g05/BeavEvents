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
$link = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs340_sextono', '0244', 'cs340_sextono');

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}


//
$query = "SELECT * FROM CLUB";
$result = mysqli_query($link, $query) or die(mysqli_error($link));

echo "<table border='1'>
<tr>
    <th>Name</th>
    <th>Advisor</th>
    <th>Category</th>
    <th>clubID</th>
</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['advisor']."</td>";    
    echo "<td>".$row['category']."</td>";
    echo "<td>".$row['clubID']."</td>";
    echo "</tr>";
}

echo "</table>";


mysqli_close($link);
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
          <li class="menu-item active"><a href="clubs.php">Clubs</a></li>
          <li class="menu-item"><a href="events.php">Events</a></li>
          <li class="menu-item"><a href="tutorial.php">Help</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <div class="home-content">
    <div class="body-text">
      <strong class="sub-subheader">Create a Club: <button class="tut-btn">Add New Club</button></strong>
      
      <div class="all-club-box">
        <?php foreach ($clubs as $club): ?>
          <div class="club-box">
            <div class="club-header-row">
              <h2><?= htmlspecialchars($club['name']) ?></h2>
              <div class="table-button-box">
                <button class="table-button">Add new Member</button>
                <button class="table-button">Delete Club</button>
              </div>
            </div>
            <table style="width: 100%; border-collapse: collapse;">
              <thead class="club-headers">
                <tr>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Email</th>
                  <th>ID</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($club['members'] as $member): ?>
                  <tr>
                    <td><?= htmlspecialchars($member['name']) ?></td>
                    <td><?= htmlspecialchars($member['role']) ?></td>
                    <td><?= htmlspecialchars($member['email']) ?></td>
                    <td><?= htmlspecialchars($member['user_id']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
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

</body>
</html>
