<?php

$page = "home";

session_start();
require_once "../html/config.php";  // This file should define $conn

// If the user is not logged in, redirect to login.
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Re-check the user's status from the database to enforce block/allow changes.
$user_id = $_SESSION['id'];
$sql = "SELECT status FROM users WHERE id = $user_id LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $userData = mysqli_fetch_assoc($result);
    if ($userData['status'] != 1) {  // 1 = Allowed, 0 = Blocked
        echo "<h1>Access Denied</h1>";
        echo "<p>Your account has been blocked by the administrator. Please contact support if you believe this is an error.</p>";
        echo '<p><a href="logout.php">Logout</a></p>';
        exit;
    }
} else {
    echo "<p>Unable to verify user status.</p>";
    exit;
}

// Now that the user is allowed, fetch data from the uploads table.
// (Assuming your config.php already established the $conn connection)
$query = "SELECT * FROM uploads";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../assets/Bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/Bootstrap/bootstrap-5.3.3-examples/navbars/navbars.css">
    <link rel="stylesheet" href="../assets/Bootstrap/bootstrap-5.3.3-examples/heroes/index.css">
    <link rel="stylesheet" href="../assets/fontawesome-free-6.7.2-web/css/fontawesome.css">
    <link rel="stylesheet" href="../css/styling.css">
    <title>Home</title>

    <style>
        body {
          scroll-behavior: smooth;
        }

        .bd-placeholder-img {
          font-size: 1.125rem;
          text-anchor: middle;
          -webkit-user-select: none;
          -moz-user-select: none;
          user-select: none;
        }
        
        .fa-whatsapp {
          --fa: "\f232"; }

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
          box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
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

        .content1{
          background-color: rgb(44, 44, 44);
          color: white;
        }

        /* testim */
        /* Center align the text within the three columns below the carousel */
          .marketing .col-lg-4 {
            margin-bottom: 1.5rem;
            text-align: center;
          }

          /* Add a dark overlay */
          .mainMain::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Black with 50% opacity */
            z-index: -1; /* Ensure it stays above the background but below the content */
          }
          /* Ensure content inside .mainMain is visible */
          .mainMain {
            position: relative;
            z-index: 1; /* Keep content above the overlay */
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
            color: #b4ff00; /* Bright green */
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
            0%{
              width: 0;
              height: 0;
            }
            70%{
              height: 5px;
              width: 30%;
              opacity: 1;
            }
            100%{
            height: 2px;
            background-color: white;
            width: 100%;
            margin: 10px auto;
            opacity: 1;
            animation: devided 500ms cubic-bezier(0.075, 0.82, 0.165, 1) forwards;
            }
          }
    /* New: Video Background Style */
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
    /* Ensure the card is positioned relatively so the overlay can be positioned absolutely */
    .card {
      position: relative;
      overflow: hidden; /* Prevent the scaled image from overflowing the card */
    }

    /* Transition effects for the image */
    .card img {
      transition: transform 0.3s ease, filter 0.3s ease;
    }

    /* On hover, scale up and darken the image */
    .card:hover img {
      transform: scale(1.05);
      filter: brightness(0.8);
    }

    /* The overlay that holds the hover button */
    .hover-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      /* Center the button inside the overlay */
      display: flex;
      justify-content: center;
      align-items: center;
      /* Start hidden */
      opacity: 0;
      transition: opacity 0.3s ease;
      /* Allow clicks on the button only, not the overlay */
      pointer-events: none;
    }

    /* Make the overlay visible on hover */
    .card:hover .hover-overlay {
      opacity: 1;
    }

    /* The button style within the overlay */
    .hover-overlay .hover-button {
      pointer-events: all; /* Enable clicking on the button */
      background-color: rgba(0, 0, 0, 0.5);
      border: none;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: background-color 0.3s cubic-bezier(0.075, 0.82, 0.165, 1);
    }

    /* Change the button background on hover */
    .hover-overlay .hover-button:hover {
      background-color: rgba(0, 0, 0, 0.7);
    }
    /* Style the modal */
    /* .modal {
        display: block;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 20px;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.3);
        z-index: 1000;
    } */
    </style>

</head>
<body>
    <!-- Video Background -->
    <video id="bg-video" class="bg-effect" autoplay loop muted>
        <source src="../assets/vid/clobe.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div>
        <?php include "./pageElements/absoluteblock.php"; ?>

        <div class="p-0 m-0">
            <?php require_once "./pageElements/navigation.php"; ?>
            <!-- hero -->
            <div class="p-5 my-5 text-center text-white">
                <div class="logo-container">
                    <div class="logo-text">
                        <span>HARDSURFACE</span>
                    </div>
                    <div class="divider1"></div>
                </div>
                <div class="col-lg-6 mx-auto">
                    <p class="lead mb-4">A dedicated portfolio platform created for a 3D artist to showcase his high-quality hard surface designs. Tailored for precision and clarity, it presents the artist’s work in a professional and engaging format. With streamlined management tools, the platform makes it easy to update content and receive feedback, ensuring that every piece of art stands out and resonates with potential clients and industry peers</p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <button type="button" class="btn btn-dark btn-lg px-4 gap-3">
                            <a href="explore.php" class="text-decoration-none text-light">Discover</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-dark">
            <div class="container mt-5 explorepane">
                <div class="row row-cols-1 row-cols-md-3 g-4 pb-5"> 
                <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col">
  <div class="card shadow-sm">
    <!-- Display image -->
    <img class="bd-placeholder-img card-img-top object-fit-cover" width="100%" height="225" src="../admin/<?php echo htmlspecialchars($row['image_path']); ?>" alt="Image">
    
            <!-- Hover overlay with button -->
            <div class="hover-overlay">
            <button type="button"
                    class="hover-button btn btn-primary p-0 open-modal-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#objectModal"
                    data-image="../admin/<?php echo htmlspecialchars($row['image_path']); ?>"
                    data-title="<?php echo htmlspecialchars($row['title']); ?>"
                    data-description="<?php echo htmlspecialchars($row['description']); ?>"
                    data-uploadtime="<?php echo date("M j, Y, g:i A", strtotime($row['uploaded_at'])); ?>"
                    data-viewurl="view.php?id=<?php echo $row['id']; ?>">
              <svg xmlns="http://www.w3.org/2000/svg" width="5em" height="5em" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z"/>
              </svg>
            </button>
            </div>
            
            <div class="card-body">
              <!-- Display title -->
              <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
              
              <!-- Display description -->
              <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
              
              <!-- Display upload time -->
              <small class="text-muted"><?php echo date("M j, Y, g:i A", strtotime($row['uploaded_at'])); ?></small>
              
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                </div>
              </div>
            </div>
          </div>
        </div>
                <?php
            }
        } else {
            echo "<p>No records found.</p>";
        }
        ?>
                </div>
            </div>
        </div>
    </div>
      
<!-- Modal -->
<div class="modal fade" id="objectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="objectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
    <div class="modal-content">
      
      <!-- Modal Header (optional) -->
      <div class="modal-header">
        <h5 class="modal-title" id="objectModalLabel">Object Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Modal Body -->
      <div class="modal-body p-0">
        <!-- Object Image -->
        <img src="" id="modalImage" alt="Object Image" class="img-fluid object-fit-contain" style="width:100%; height: 70vh;">
        <!-- Details Section Below the Image -->
        <div class="p-3">
          <h4 id="modalTitle">Title</h4>
          <p id="modalDescription">Description</p>
          <small id="modalUploadTime" class="text-muted">Upload Time</small>
          <!-- "View" Button aligned to the right -->
          <div class="text-end mt-3">
          </div>
        </div>
      </div>
      
      <!-- Modal Footer (optional) -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
      
    </div>
  </div>
</div>

      
    <?php include "../admin/pageElements/footer.php"; ?>
</body>
<script>
    window.addEventListener('scroll', function() {
        var scrollPosition = window.pageYOffset;
        var parallaxFactor = -0.5;
        var video = document.getElementById('bg-video');
        video.style.transform = 'translateY(' + (scrollPosition * parallaxFactor) + 'px)';
    });
</script>
<script src="../assets/Bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var objectModal = document.getElementById('objectModal');

    objectModal.addEventListener('show.bs.modal', function (event) {

      var button = event.relatedTarget;

      var imageSrc = button.getAttribute('data-image');
      var title = button.getAttribute('data-title');
      var description = button.getAttribute('data-description');
      var uploadTime = button.getAttribute('data-uploadtime');
      var viewUrl = button.getAttribute('data-viewurl');

      document.getElementById('modalImage').src = imageSrc;
      document.getElementById('modalTitle').textContent = title;
      document.getElementById('modalDescription').textContent = description;
      document.getElementById('modalUploadTime').textContent = uploadTime;
      document.getElementById('modalViewButton').href = viewUrl;
    });
  });
</script>

</html>
