<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Artwork Detail Popup</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    /* Optional: Adjust the modal image styling */
    .modal-img {
      width: 100%;
      height: auto;
    }
    /* Remove any extra spacing from modal footer if needed */
    .modal-footer {
      border-top: none;
    }
  </style>
</head>
<body>
  <!-- A sample trigger element (a card) -->
  <div class="container mt-5">
    <div class="card shadow-sm" style="cursor: pointer;" data-toggle="modal" data-target="#detailModal">
      <img src="thumbnail.jpg" class="card-img-top" alt="Thumbnail">
      <div class="card-body">
        <h5 class="card-title">Artwork Title</h5>
        <p class="card-text">A short description of the work.</p>
      </div>
    </div>
  </div>

  <!-- Modal for displaying artwork details -->
  <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <!-- Modal Header with Title -->
        <div class="modal-header">
          <h5 class="modal-title" id="detailModalLabel">Artwork Title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- Modal Body with Image and Details -->
        <div class="modal-body">
          <div class="row">
            <!-- Left column: Full-size image -->
            <div class="col-md-6">
              <img src="fullsize.jpg" alt="Full Artwork" class="img-fluid modal-img">
            </div>
            <!-- Right column: Details -->
            <div class="col-md-6">
              <p class="description">
                Detailed description of the artwork goes here. This section can include creative insight, context about the work, and any other relevant information.
              </p>
              <p class="date">
                <strong>Created/Modified:</strong> Feb 7, 2025, 10:00 AM
              </p>
              <div class="links">
                <strong>Related Links:</strong>
                <ul>
                  <li><a href="https://example.com/link1" target="_blank">Example Link 1</a></li>
                  <li><a href="https://example.com/link2" target="_blank">Example Link 2</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Footer (only a close button is needed) -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
