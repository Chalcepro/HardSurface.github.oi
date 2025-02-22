<?php
require_once "./authentication.php";
require_once "../html/config.php";
// Query total users
$totalUsersQuery = "SELECT COUNT(*) AS total FROM users";
$totalUsersResult = mysqli_query($conn, $totalUsersQuery);
$totalUsersRow = mysqli_fetch_assoc($totalUsersResult);
$totalUsers = $totalUsersRow['total'];

// Query allowed users (status = 1)
$allowedUsersQuery = "SELECT COUNT(*) AS allowed FROM users WHERE status = 1";
$allowedUsersResult = mysqli_query($conn, $allowedUsersQuery);
$allowedUsersRow = mysqli_fetch_assoc($allowedUsersResult);
$allowedUsers = $allowedUsersRow['allowed'];

// Query blocked users (status = 0)
$blockedUsersQuery = "SELECT COUNT(*) AS blocked FROM users WHERE status = 0";
$blockedUsersResult = mysqli_query($conn, $blockedUsersQuery);
$blockedUsersRow = mysqli_fetch_assoc($blockedUsersResult);
$blockedUsers = $blockedUsersRow['blocked'];

// Query posts (from uploads table)
$postsQuery = "SELECT COUNT(*) AS posts FROM uploads";
$postsResult = mysqli_query($conn, $postsQuery);
$postsRow = mysqli_fetch_assoc($postsResult);
$posts = $postsRow['posts'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin - SB Admin</title>
        <!-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" /> -->
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <?php include "./pageElements/nav.php" ?>
        <div id="layoutSidenav">
            <?php include "./pageElements/sidebar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <!-- Total Users Card -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body fw-bolder">Total Users: <?php echo $totalUsers; ?></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <!-- No view details link for total users -->
                                        <div class="small text-white"><i class="fas fa-users"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Posts Card -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body fw-bolder">Posts: <?php echo $posts; ?></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="./uploadfile.php">View Details &rarr;</a>
                                        <div class="small text-white"><i class="fas fa-file-alt"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Allowed Users Card -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body fw-bolder">Allowed Users: <?php echo $allowedUsers; ?></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="./users.php">View Details &rarr;</a>
                                        <div class="small text-white"><i class="fas fa-check-circle"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Blocked Users Card -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body fw-bolder">Blocked Users: <?php echo $blockedUsers; ?></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="./users.php">View Details &rarr;</a>
                                        <div class="small text-white"><i class="fas fa-ban"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Charts have been removed as requested -->
                    </div>
                <?php include "./pageElements/footer.php" ?>

                </main>
            </div>
        </div>
        <?php include "./scripts.php" ?>
    </body>
</html>
