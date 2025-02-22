<?php
$page = "about";

session_start();
require_once "../html/config.php"; 

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];
$sql = "SELECT status FROM users WHERE id = $user_id LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $userData = mysqli_fetch_assoc($result);
    if ($userData['status'] != 1) { 
        echo "<h1>Access Denied</h1>";
        echo "<p>Your account has been blocked by the administrator. Please contact support if you believe this is an error.</p>";
        echo '<p><a href="logout.php">Logout</a></p>';
        exit;
    }
} else {
    echo "<p>Unable to verify user status.</p>";
    exit;
}

$query = "SELECT * FROM uploads";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- CSS Imports -->
  <link rel="stylesheet" href="../css/navbar.css">
  <link rel="stylesheet" href="../assets/Bootstrap/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/Bootstrap/bootstrap-5.3.3-examples/navbars/navbars.css">
  <link rel="stylesheet" href="../assets/Bootstrap/bootstrap-5.3.3-examples/heroes/index.css">
  <link rel="stylesheet" href="../assets/fontawesome-free-6.7.2-web/css/fontawesome.css">
  <link rel="stylesheet" href="../css/styling.css">
  
  <title>About</title>

  <style>
    /* Wrapper to ensure the footer stays at the bottom */
    .page-wrapper {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .page-content {
      flex: 1;
    }
    
    /* Existing Styles … */
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }
    .fa-whatsapp {
      --fa: "\f232";
    }
    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1),
                  inset 0 .125em .5em rgba(0, 0, 0, .15);
    }
    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }
    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }
    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }
    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }
    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }
    .bd-mode-toggle {
      z-index: 1500;
    }
    .bd-mode-toggle .dropdown-menu .active .bi {
      display: block !important;
    }
    .content1 {
      background-color: rgb(44, 44, 44);
      color: white;
    }
    /* Testimonial / Animation Styles */
    .marketing .col-lg-4 {
      margin-bottom: 1.5rem;
      text-align: center;
    }
    .mainMain::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: -1;
    }
    .mainMain {
      position: relative;
      z-index: 1;
    }
    .logo-container {
      text-align: center;
      color: white;
      position: relative;
    }
    .logo-text {
      font-family: Arial, sans-serif;
      font-size: 48px;
      font-weight: bold;
      text-transform: uppercase;
    }
    .logo-text .highlight {
      color: #b4ff00;
    }
    .divider {
      height: 2px;
      background-color: white;
      width: 100%;
      margin: 10px auto;
    }
    .divider1 {
      height: 0px;
      opacity: 0;
      background-color: white;
      width: 0%;
      margin: 10px auto;
      animation: devided 2s cubic-bezier(0.075, 1, 0.988, 1) forwards;
    }
    @keyframes devided {
      0% {
        width: 0;
        height: 0;
      }
      70% {
        height: 5px;
        width: 30%;
        opacity: 1;
      }
      100% {
        height: 2px;
        background-color: white;
        width: 100%;
        margin: 10px auto;
        opacity: 1;
        animation: devided 500ms cubic-bezier(0.075, 0.82, 0.165, 1) forwards;
      }
    }
    .profile-image {
      width: 100%;
      height: auto;
      opacity: 0;
      transform: translateX(-50px);
      transition: opacity 1.5s ease-in-out, transform 1.5s ease-in-out;
    }
    .profile-image.show {
      opacity: 1;
      transform: translateX(0);
    }
    #bg-video {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
      filter: blur(1px);
    }
    .artistic-bg {
      position: absolute;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 80%;
      height: 100%;
      background: url('../assets/img/hard-surface-pattern.png') no-repeat center center;
      background-size: cover;
      opacity: 0.3;
      z-index: 0;
    }
    .content-overlay {
      position: relative;
      z-index: 1;
    }
    .centered-content {
      position: relative;
      text-align: center;
      color: white;
      padding: 4rem 1rem;
    }
  </style>
</head>
<body>
  <video id="bg-video" class="bg-effect" autoplay loop muted>
    <source src="../assets/vid/clobe.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>

  <!-- Page Wrapper to keep the footer at the bottom -->
  <div class="page-wrapper">
    <!-- Main Content -->
    <div class="page-content">
      <?php include "./pageElements/absoluteblock.php"; ?>
      <div class="p-0 m-0">
        <?php require_once "./pageElements/navigation.php"; ?>

        <!-- Centralized Content with Artistic Overlay -->
        <div class="centered-content">
          <!-- Artistic Background (in front of video, behind text) -->
          <div class="artistic-bg"></div>
          
          <!-- Main Text Content -->
          <div class="content-overlay">
            <h2 class="display-4">Hard Surface 3D Modeler</h2>
            <p class="lead">
              Specialized in creating high-quality hard surface models for games and cinematic visuals.
              Experienced in <strong>Blender, Substance Painter, Unreal Engine, and After Effects</strong>.
              Passionate about pushing the limits of realism and optimization for real-time and pre-rendered workflows.
            </p>
            <!-- Additional Context Under the Title -->
            <p class="lead">
              With over a decade of experience, my approach focuses on precision, creativity, and the latest industry standards.
              My portfolio spans various projects—from indie games to blockbuster cinematic sequences—all rendered with incredible detail and artistic flair.
            </p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Footer (unchanged external file) -->
    <?php include "../admin/pageElements/footer.php"; ?>
  </div>

  <!-- Bootstrap and Custom Scripts -->
  <script src="../assets/Bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
