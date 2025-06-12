<!-- Carter Cripe and Owen Sexton -->
<!-- Group 10 -->

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Character encoding and page title -->
  <meta charset="UTF-8">
  <title>BeavEvents</title>

  <!-- Link to external CSS stylesheet -->
  <link rel="stylesheet" href="assets/style.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="assets/InnerBgLogo.png">
</head>

<body>

  <!-- Wrapper for the entire homepage -->
  <div class="home-wrapper">

    <!-- Header section with logo and site navigation -->
    <header class="home-header">
      <img src="assets/NoBackLogo.png" alt="BeavEvents Logo" class="logo" />

      <div class="head-col">
        <!-- Site title with OSU-themed styling -->
        <h1 class="home-title">
          <span style="color: #D63F09; font-size: 80px;">Beav</span>
          <span style="color: #000000; font-size: 80px;">Events</span>
        </h1>

        <!-- Navigation menu -->
        <nav class="menu-bar">
          <ul class="menu-list">
            <li class="menu-item active"><a href="home.php">Home</a></li>
            <li class="menu-item"><a href="clubs.php">Clubs</a></li>
            <li class="menu-item"><a href="events.php">Events</a></li>
            <li class="menu-item"><a href="tutorial.php">Help</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <!-- Main content area -->
    <main class="home-content">

      <!-- Introductory paragraph explaining the website purpose -->
      <p class="body-text">
        <strong class="subheader">About this website:</strong><br />
        Our project, BeavEvents, is a website that helps students at Oregon State University find and get involved in campus events and clubs. 
        Clubs can post and manage their events, and students can browse what's coming up, RSVP, and leave feedback afterward. 
        Students can also join clubs through the site, making it easy to stay connected with what’s happening around campus. 
        Club officers can track attendance and feedback, while students get a personalized view of events they care about. 
        The goal is to make it easier for everyone to get involved and stay connected at OSU. 
        <br /><br />
        For more information about how to use the website, click the "Tutorial" button below.
        <!-- Tutorial button link -->
        <a href="tutorial.php"><button class="tut-btn">Tutorial</button></a>
      </p>

      <!-- Image section showcasing an OSU Ultimate Frisbee event -->
      <div class="fris-wrap">
        <img 
          src="assets/OSUFrisbeeBeaverBrawl.jpg" 
          alt="A frisbee player from the Oregon State Men's Ultimate Frisbee Club makes a great catch at the annual Beaver Brawl event" 
          class="frisbee-photo" 
        />
        <p class="caption">
          (Figure 1) A player makes a great catch at the 'Beaver Brawl', an annual tournament hosted by the OSU Men's Ultimate Frisbee Club
        </p>
      </div>
    </main>

    <!-- Footer section with author info, contact, and image credits -->
    <footer class="footer">
      <div class="footer-main">

        <!-- Author information -->
        <div class="footer-column">
          <h4>Authors</h4>
          <p>Website by Carter Cripe, Owen Sexton</p>
          <p>Phone: (970) 581-8720</p>
        </div>

        <!-- Contact information -->
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

        <!-- Image and media credits -->
        <div class="footer-column">
          <h4>Image credit</h4>
          <p>BeavEvents Logo created by DALL-e</p>
          <p>Figure 1 by Robert Scherle</p>
        </div>
      </div>

      <!-- Footer bar with copyright -->
      <div class="footer-bar">
        <p>© 2025 BeavEvents — All rights reserved.</p>
      </div>
    </footer>

  </div> <!-- End of .home-wrapper -->

</body>
</html>
