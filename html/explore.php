<?php
$page = "explore";

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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Explore</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    .explorepane {
      padding-bottom: 70px;
    }
    .hover-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      opacity: 0;
      transition: opacity 0.3s ease;
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
  </style>
</head>
<body>

<div class="bg-dark">
  <?php include "./pageElements/absoluteblock.php"; ?>

  <div class="mainMain p-0 m-0">
    <?php require_once "./pageElements/navigation.php"; ?>
  </div>

  <div class="container mt-5 explorepane">
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php
      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              ?>
              <div class="col">
                <div class="card shadow-sm">
                  <!-- Display image -->
                  <img class="bd-placeholder-img card-img-top object-fit-cover" width="100%" height="225" src="../admin/<?php echo htmlspecialchars($row['image_path']); ?>" alt="Image">
                  <div class="card-body">
                    <!-- Display title -->
                    <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                    
                    <!-- Display description -->
                    <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                    
                    <!-- Display upload time -->
                    <small class="text-muted"><?php echo date("M j, Y, g:i A", strtotime($row['uploaded_at'])); ?></small>
                    
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

<!-- Footer -->
<footer class="py-4 bg-light mt-auto">
  <div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between small">
      <div class="text-muted">Copyright &copy; Your Website 2023</div>
      <div>
        <a href="#">Privacy Policy</a>
        &middot;
        <a href="#">Terms &amp; Conditions</a>
      </div>
    </div>
  </div>
</footer>

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
</body>
</html>

<?php
mysqli_close($conn);
?>
