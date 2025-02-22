<?php 
session_start();
require_once "config.php";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$email = $password = $name = $error = $confirmpassword = $number = '';
$errors = ['email' =>'', 'password' =>'', 'confirmpassword' => '', 'name' => '', 'number' => ''];

if (isset($_POST["signup"])) {

    if (empty($_POST['name'])) {
        $errors['name'] = "Name is required";
    } else {
        $name = trim($_POST['name']);

        if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            $errors['name'] = "Error, name not valid";
        }
    }

    if (empty($_POST['email'])) {
        $errors['email'] = "Email is required";
    } else {
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Error, email not valid";
        }
    }

    if (empty($_POST['password'])) {
        $errors['password'] = "Input your password";
    } else {
        $password = trim($_POST['password']);
        if (strlen($password) <= 3) {
            $errors['password'] = "Password should be more than 3 characters";
        }
    }

    if (empty($_POST['confirmpassword'])) {
        $errors['confirmpassword'] = "Input your confirm password";
    } else {
        $confirmpassword = trim($_POST['confirmpassword']);
        if ($confirmpassword !== $password) {
            $errors['confirmpassword'] = "Password does not match";
        }
    }

    if (!array_filter($errors)) {
        $num_mail_check_sql = "SELECT email FROM users WHERE email = '$email'";
        $check_stmt = mysqli_query($conn, $num_mail_check_sql);
        $result = mysqli_num_rows($check_stmt);
        if ($result > 0) {
            $error = "Account or number already exists";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
            $insert_result = mysqli_query($conn, $sql);
            if ($insert_result) {
                $success = "Submit successful";

                $email = $password = $error = $name = $confirmpassword = $number = '';

                header("Location: login.php");
                exit;
            } else {

                $error = "Unable to submit your data! " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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
                <!-- Display any global error -->
                <?php if (!empty($error)): ?>
                    <h5 class="text-danger fw-bold fs-5"><?php echo $error; ?></h5>
                <?php endif; ?>
                <!-- If there's a success message, you could display it as well -->
                <?php if (isset($success)): ?>
                    <h5 class="text-success fw-bold fs-5"><?php echo $success; ?></h5>
                <?php endif; ?>
                <form method="POST" action="" class="p-4 p-md-5 border rounded-3 bg-body-tertiary z-3">
                    <!-- Note: Updated the following line to use full PHP tags -->
                    <p class="red-text center"><?php echo isset($errors['name_error']) ? $errors['name_error'] : ''; ?></p>

                    <!-- Name Field -->
                    <label for="name">Name</label>
                    <input type="text" placeholder="Chalcedony" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                    <div class="red-text"><?php echo $errors['name']; ?></div>

                    <!-- Email Field -->
                    <label for="email">Email Address</label>
                    <input placeholder="Chalcepro@example.com" type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    <div class="red-text"><?php echo $errors['email']; ?></div>

                    <!-- Password Field -->
                    <label for="password">Password</label>
                    <input placeholder="Enter your password" type="password" name="password" required>
                    <div class="red-text"><?php echo $errors['password']; ?></div>

                    <!-- Confirm Password Field -->
                    <label for="confirmpassword">Confirm Password</label>
                    <input placeholder="Confirm your password" type="password" name="confirmpassword" required>
                    <div class="red-text"><?php echo $errors['confirmpassword']; ?></div>

                    <div class="center">
                        <button class="w-100 btn btn-lg btn-primary" type="submit" name="signup">Sign up</button>
                    </div>

                    <hr class="my-4">
                    <div class="w-100 text-center">
                        <small class="text-body-secondary text-center">Or login if already subscribed, <a href="./login.php">Login</a></small>
                    </div>
                </form>
            </div>
            
            <div class="col-lg-7 sideimage">
                <!-- Optional side image -->
            </div>
        </div>
    </div>
  
    <?php include "../admin/pageElements/footer.php"; ?>
</body>
</html>


<!-- Name:
Depart:
Semester:
orga:

Problem state:
Solution State:
Link/Hosted: -->