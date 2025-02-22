<?php
session_start();
require_once "../html/config.php"; 

require_once "./authentication.php";


if (isset($_GET['action'], $_GET['id'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] === 'block') {
        $new_status = 0;
    } elseif ($_GET['action'] === 'allow') {
        $new_status = 1;
    } else {
        $new_status = 1;
    }
 
    $sql = "UPDATE users SET status = $new_status WHERE id = $id";
    mysqli_query($conn, $sql);

    header("Location: users.php");
    exit;
}

$result = mysqli_query($conn, "SELECT id, name, email, status FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Block/Allow Users - Admin Panel</title>
    <!-- Link your CSS here -->
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <?php include "./pageElements/nav.php"; ?>
    <div id="layoutSidenav">
        <?php include "./pageElements/sidebar.php"; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Manage Users</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Block/Allow Users</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Users List
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td>
                                            <?php
                                            echo ($row['status'] == 1)
                                                ? "<span style='color:green;'>Allowed</span>"
                                                : "<span style='color:red;'>Blocked</span>";
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] == 1): ?>
                                                <!-- If allowed, show link to block -->
                                                <a href="users.php?action=block&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Block</a>
                                            <?php else: ?>
                                                <!-- If blocked, show link to allow -->
                                                <a href="users.php?action=allow&id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Allow</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                    <?php mysqli_free_result($result); // free the result set ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include "./pageElements/footer.php"; ?>
        </div>
    </div>
    <?php include "./scripts.php"; ?>
</body>
</html>
