<?php

include ('../html/config.php');

require_once "./authentication.php";

$row['title'] = '';
$row['image_path'] = '';
$row['description'] = '';
$uploaded_at = $_POST['uploaded_at'] = '';



if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM uploads WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "No data found.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $uploaded_at = $_POST['uploaded_at'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imagePath = 'uploads/' . $imageName;

        if (move_uploaded_file($imageTmp, $imagePath)) {

            $sql = "UPDATE uploads SET title = '$title', description = '$description', image_path = '$imagePath' WHERE id = $id";
        } else {
            echo "Image upload failed!";
            exit;
        }
    } else {

        $sql = "UPDATE uploads SET title = '$title', description = '$description' WHERE id = $id";
    }


    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully!";

        header('Location: uploadfile.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Edit_Files - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <?php include "./pageElements/nav.php" ?>
            <div id="layoutSidenav">
                <?php include "./pageElements/sidebar.php" ?>
                <div id="layoutSidenav_content">
                    <main>
                        <div class="p-4 mb-5">
                            <div class="container-fluid px-4">
                                    <h1 class="mt-4">Edit Files</h1>
                            </div>
                            <form method="POST" action="" enctype="multipart/form-data">

                                <div class="mb-3">
                                    <label for="current_image">Current Image</label>
                                    <div>
                                        <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Current Image" width="200" class="img-fluid">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="image">Change Image (Optional)</label>
                                    <input class="form-control" type="file" id="image" name="image">
                                </div>

                                <div class="mb-3">
                                    <label class="mb-3" for="title">Title</label>
                                    <input class="form-control" type="text" id="title" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-3" for="description">Description</label>
                                    <input class="form-control" type="text" id="description" name="description" value="<?php echo htmlspecialchars($row['description']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </main>
                </div>
            </div>
        <?php include "./pageElements/footer.php" ?>
        <?php include "./scripts.php"; ?>
    </body>