<?php
session_start();
require_once "config.php";

$name = $password = $error = '';
$errors = ['name' => '', 'password' => ''];

if (isset($_POST["login"])) {

    if (empty($_POST['name'])) {
        $errors['name'] = "Input your username";
    } else {
        $name = trim($_POST['name']);
        if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            $errors['name'] = "Invalid username";
        }
    }

    if (empty($_POST['password'])) {
        $errors['password'] = "Input your password";
    } else {
        $password = $_POST['password'];
    }

    if (!array_filter($errors)) {
        if (strtolower($name) === 'admin') {

            $sql = "SELECT id, name, password FROM admins WHERE LOWER(name) = 'admin' LIMIT 1";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($password, $row['password'])) {
                    $_SESSION['admin'] = true;
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['name'] = $row['name'];
                    header("Location: ../admin/admin.php");
                    exit;
                } else {
                    $error = "Incorrect admin password.";
                }
            } else {
                $error = "Admin not found in the admin table.";
            }
        } else {
            $nameEscaped = mysqli_real_escape_string($conn, $name);
            $sql = "SELECT id, name, password, status FROM users WHERE name = '$nameEscaped' LIMIT 1";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($password, $row['password'])) {
                    if ($row['status'] == 0) {
                        $error = "Your account has been blocked by the administrator.";
                    } else {
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['name'] = $row['name'];
                        $_SESSION['status'] = $row['status'];
                        header("Location: home.php");
                        exit;
                    }
                } else {
                    $error = "Incorrect password.";
                }
            } else {
                $error = "Username not found.";
            }
        }
    }
}
?>

<!-- HTML portion remains the same -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap and additional CSS -->
    <link rel="stylesheet" href="../assets/Bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/Bootstrap/bootstrap-5.3.3-examples/heroes/heroes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<style>
    .signopation {
        width: 100%;
        background: url(../assets/img/assadullah-sanusi-take-1.jpg);
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-color: red;
    }
</style>
<body>
    <div class="container-fluid p-0">
        <div class="row align-items-center signopation g-lg-5 py-5">
            <div class="col-md-10 col-lg-5 d-block align-items-center theform">
                <!-- Display any error messages -->
                <?php if (!empty($error)): ?>
                    <h5 class="text-danger fw-bold fs-5"><?php echo $error; ?></h5>
                <?php endif; ?>

                <form method="POST" action="" class="p-4 p-md-5 border rounded-3 bg-body-tertiary z-3">
                    <!-- Username Field -->
                    <label for="name">Username</label>
                    <input type="text" placeholder="Enter your username" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                    <div class="red-text"><?php echo $errors['name']; ?></div>

                    <!-- Password Field -->
                    <label for="password">Password</label>
                    <input type="password" placeholder="Enter your password" name="password" required>
                    <div class="red-text"><?php echo $errors['password']; ?></div>

                    <div class="center">
                        <button class="w-100 btn btn-lg btn-primary" type="submit" name="login">Login</button>
                    </div>

                    <hr class="my-4">
                    <div class="w-100 text-center">
                        <small class="text-body-secondary">Don't have an account? <a href="./signup.php">Sign up</a></small>
                    </div>
                </form>
            </div>
            <div class="col-lg-7">
                <!-- Optional side image or additional content -->
            </div>
        </div>
    </div>

    <?php include "../admin/pageElements/footer.php"; ?>
    <script src="../assets/Bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
