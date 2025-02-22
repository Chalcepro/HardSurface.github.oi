<?php
$page = "contact";

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

$success = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $insertSql = "INSERT INTO contact_messages (user_id, name, email, subject, message) 
                  VALUES ($user_id, '$name', '$email', '$subject', '$message')";
    if (mysqli_query($conn, $insertSql)) {
        $success = "Thank you for contacting us, $name! We will get back to you shortly.";
    } else {
        $success = "There was an error submitting your message. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Me</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../assets/Bootstrap/bootstrap/css/bootstrap.min.css">
  <!-- Your custom styling (if needed) -->
  <link rel="stylesheet" href="../css/styling.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    nav {
      background-color: #343a40 !important;
    }
    nav a {
      color: #ffffff !important;
    }
    .contact-section {
      padding: 60px 0;
    }
    .contact-form-container {
      margin-left: 0;
      margin-right: auto;
    }
    .background-video {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
    }
  </style>
</head>
<body>
<body>
    <!-- Background Video -->
    <video autoplay loop muted playsinline class="background-video">
      <source src="../assets/vid/orby2.mp4" type="video/mp4">
      Your browser does not support the video tag.
    </video>

  <!-- Optional Absolute Block (if needed) -->
  <?php include "./pageElements/absoluteblock.php"; ?>

  <!-- Navigation -->
  <?php require_once "./pageElements/navigation.php"; ?>

  <!-- Contact Form Section -->
  <div class="container contact-section text-light">
    <div class="row">
      <!-- Adjust the column width (e.g., col-md-6) to match the left alignment on your login page -->
      <div class="col-md-6 contact-form-container">
        <!-- <h2 class="mb-4">Contact Me</h2> -->
        <?php if ($success): ?>
          <div class="alert alert-success">
            <?php echo $success; ?>
          </div>
        <?php endif; ?>
        <form action="" method="POST">
          <div class="mb-3">
            <label for="name" class="form-label">Your Name</label>
            <input 
              type="text" 
              class="form-control" 
              id="name" 
              name="name" 
              placeholder="Enter your name" 
              required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Your Email</label>
            <input 
              type="email" 
              class="form-control" 
              id="email" 
              name="email" 
              placeholder="name@example.com" 
              required>
          </div>
          <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input 
              type="text" 
              class="form-control" 
              id="subject" 
              name="subject" 
              placeholder="Subject" 
              required>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Your Message</label>
            <textarea 
              class="form-control" 
              id="message" 
              name="message" 
              rows="5" 
              placeholder="Type your message here" 
              required></textarea>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-light btn-lg">Send Message</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include "../admin/pageElements/footer.php"; ?>

  <!-- Bootstrap JS -->
  <script src="../assets/Bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
