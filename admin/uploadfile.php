<?php
include "../html/config.php";

require_once "./authentication.php";


    if (isset($_POST["upload"])) {

        if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
            $title = mysqli_real_escape_string($conn, $_POST["title"]);
            $description = mysqli_real_escape_string($conn, $_POST["description"]); 
            $fileName = $_FILES["file"]["name"];
            $fileTmp = $_FILES["file"]["tmp_name"];
            $uploadDir = "uploads/"; 
            $filePath = $uploadDir . basename($fileName);

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($fileTmp, $filePath)) {

                $created_at = date("Y-m-d H:i:s");
                $uploaded_at = date("Y-m-d H:i:s");
    
                $sql = "INSERT INTO uploads (title, description, image_path, created_at, uploaded_at) 
                        VALUES ('$title', '$description', '$filePath', '$created_at', '$uploaded_at')";
    
                if (mysqli_query($conn, $sql)) {
                    echo "File uploaded successfully!";
                } else {
                    echo "Database error: " . mysqli_error($conn);
                }
            } else {
                echo "File upload failed!";
            }
        } else {
            echo "No file uploaded or file error!";
        }
    }

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Upload Files - Admin</title>
    <link rel="stylesheet" href="../assets/Bootstrap/bootstrap/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <?php include "./pageElements/nav.php" ?>
    <div id="layoutSidenav">
        <?php include "./pageElements/sidebar.php" ?>
        <div id="layoutSidenav_content">
            <main class="p-5">
                <div class="card mb-4 border-0">
                    <h3 class="mt-4 text-dark">Upload New File</h3>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title" class="form-label">File Title</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="mb-3"required>
                                <label for="Description" class="form-label">File Description</label>
                                <input type="text" name="description" id="description" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="file" class="form-label">Choose File</label>
                                <input type="file" name="file" id="file" class="form-control" required>
                            </div>
                            <button type="submit" name="upload" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>

                <!-- Display uploaded files -->
                <h3 class="mt-4 text-dark">Uploaded Files</h3>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 bg-body-dark g-3 mb-5">
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM uploads ORDER BY uploaded_at DESC");
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    
                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="bd-placeholder-img card-img-top object-fit-cover" width="100%" height="225" src="../admin/<?php echo htmlspecialchars($row['image_path']); ?>"  alt="<?php echo $row['title']; ?>">
                            <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-dark">
                                            <a href="editfile.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; color: inherit;">Edit</a>
                                        </button>
                                    </div>
                                </div>
                                    <small class="text-muted"><?php echo date("M j, Y, g:i A", strtotime($row['uploaded_at'])); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </main>
        </div>
    </div>

    <?php include "./pageElements/footer.php"; ?>
    <?php include "./scripts.php" ?>
</body>
</html>
