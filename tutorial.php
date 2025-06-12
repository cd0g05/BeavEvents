<!-- Carter Cripe and Owen Sexton -->
<!-- Group 10 -->

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Meta info and page title -->
  <meta charset="UTF-8">
  <title>BeavEvents</title>

  <!-- Link to external CSS stylesheet -->
  <link rel="stylesheet" href="assets/style.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="assets/InnerBgLogo.png">
</head>

<body>

  <!-- Main wrapper for the entire page -->
  <div class="home-wrapper">

    <!-- Header section: includes logo and navigation menu -->
    <header class="home-header">
      <img src="assets/NoBackLogo.png" alt="BeavEvents Logo" class="logo" />

      <div class="head-col">
        <!-- Site title with color branding -->
        <h1 class="home-title">
          <span style="color: #D63F09; font-size: 80px;">Beav</span>
          <span style="color: #000000; font-size: 80px;">Events</span>
        </h1>

        <!-- Navigation bar with active page highlighted -->
        <nav class="menu-bar">
          <ul class="menu-list">
            <li class="menu-item"><a href="home.php">Home</a></li>
            <li class="menu-item"><a href="clubs.php">Clubs</a></li>
            <li class="menu-item"><a href="events.php">Events</a></li>
            <li class="menu-item active"><a href="tutorial.php">Help</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <!-- Section for Clubs Page instructions -->
    <div class="home-content">
      <div class="body-text">
        <strong class="subheader">How to use the Clubs Page:</strong><br />
        <ul class="bullet-list">
          <li>When you go to the clubs page, you will see a list of clubs sorted by membership</li>
          <li>To join a club, click 'Add Member', and fill out the form</li>
          <li>To create your own club, click the 'New Club' button</li>
        </ul>

        <!-- Button to navigate to Clubs page -->
        <a href="clubs.php"><button class="tut-btn">Go To Clubs</button></a>
      </div>

      <!-- Placeholder image related to the clubs page -->
      <div class="fris-wrap">
        <img src="assets/ClubsExample.png" alt="Example image of club page" class="help-photo" />
        <p class="caption">Example image showing possible use of the Clubs page</p>
      </div>
    </div>

    <!-- Section for Events Page instructions -->
    <div class="home-content-alt">
      <div class="body-text">
        <strong class="subheader">How to use the Events Page:</strong><br />
        <ul class="bullet-list">
          <li>When you go to the events page, you will see a list of events with the soonest at the top</li>
          <li>To create your own event, click the 'New Event' button and fill out the form</li>
          <li>To add your club to an event, click the join event button and fill out the form</li>
          <li>Users can RSVP to the event by selecting their name from the dropdown menu of club members</li>
          <li>To leave feedback on an event, scroll to the bottom of the page where you will see all the past events. From there, click 'Give Feedback', and fill out the form</li>
        </ul>

        <!-- Button to navigate to Events page -->
        <a href="events.php"><button class="tut-btn">Go To Events</button></a>
      </div>

      <!-- Placeholder image related to the events page -->
      <div class="fris-wrap">
        <img src="assets/EventsExample.png" alt="Example image of events page" class="help-photo" />
        <p class="caption">Example image showing possible use of the Events page</p>
      </div>
    </div>

    <!-- Footer section with author info, contact, social links, and image credits -->
    <footer class="footer">
      <div class="footer-main">

        <!-- Author information -->
        <div class="footer-column">
          <h4>Authors</h4>
          <p>Website by Carter Cripe, Owen Sexton</p>
          <p>Phone: (970) 581-8720</p>
        </div>

        <!-- Contact emails -->
        <div class="footer-column">
          <h4>Contact</h4>
          <p>Carter's Email: cripeca@oregonstate.edu</p>
          <p>Owen's Email: sextono@oregonstate.edu</p>
        </div>

        <!-- Social media links -->
        <div class="footer-column">
          <h4>Social</h4>
          <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">Instagram</a>
          <a href="https://x.com/carter_cripe" target="_blank"><p>Twitter</p></a>
        </div>

        <!-- Logo and media credit -->
        <div class="footer-column">
          <h4>Image credit</h4>
          <p>BeavEvents Logo created by DALL-e</p>
        </div>
      </div>

      <!-- Copyright -->
      <div class="footer-bar">
        <p>© 2025 BeavEvents — All rights reserved.</p>
      </div>
    </footer>

  </div> <!-- End of home-wrapper -->

</body>
</html>
