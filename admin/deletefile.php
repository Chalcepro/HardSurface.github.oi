<?php
include "../html/config.php";

require_once "./authentication.php";


if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "SELECT * FROM uploads WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {

        $imagePath = $row['image_path'];

        if (file_exists($imagePath)) {
            unlink($imagePath); 
        }

        $deleteSql = "DELETE FROM uploads WHERE id = $id";
        if (mysqli_query($conn, $deleteSql)) {
            echo "File deleted successfully!";
        } else {
            echo "Error deleting file: " . mysqli_error($conn);
        }
    } else {
        echo "Record not found!";
    }

} else {
    echo "No ID specified!";
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
        <title>Delete_Files - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
    <body class="sb-nav-fixed">
        <?php include "./pageElements/nav.php" ?>
        <div id="layoutSidenav">
            <?php include "./pageElements/sidebar.php" ?>
            <div id="layoutSidenav_content">
                <main class="px-4 mb-5">
                    <?php

                    $sql = "SELECT * FROM uploads";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        echo '<table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>';

                        while ($row = mysqli_fetch_assoc($result)) {
                            $description = (strlen($row['description']) > 50) ? substr($row['description'], 0, 50) . '...' : $row['description'];

                            echo '<tr>
                                    <td><img src="' . htmlspecialchars($row['image_path']) . '" alt="Image" width="100" height="75" style="object-fit: cover;"></td>
                                    <td>' . htmlspecialchars($row['title']) . '</td>
                                    <td>' . htmlspecialchars($description) . '</td>
                                    <td>' . date("M j, Y, g:i A", strtotime($row['created_at'])) . '</td>
                                    <td>
                                        <a href="deletefile.php?id=' . $row['id'] . '" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Are you sure you want to delete this file?\')">Delete</a>
                                    </td>
                                </tr>';
                        }

                        echo '</tbody></table>';
                    } else {
                        echo 'No uploads found.';
                    }
                    ?>
                </main>
            </div>
        </div>
        <?php include "./pageElements/footer.php" ?>
        <?php include "./scripts.php"; ?>
    </body>
</html>
<?php

mysqli_close($conn);
?>


