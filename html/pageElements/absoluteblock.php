<?php

require_once "config.php"; 

$blocked = false;
$active_users = [];

if (isset($_SESSION['id'])) {
    $user_id = intval($_SESSION['id']);
    
    $update_query = "UPDATE users SET last_active = NOW() WHERE id = $user_id";
    mysqli_query($conn, $update_query);

    $active_query = "SELECT id, status FROM users WHERE last_active >= NOW() - INTERVAL 5 MINUTE";
    $active_result = mysqli_query($conn, $active_query);
    
    while ($row = mysqli_fetch_assoc($active_result)) {
        $active_users[$row['id']] = $row['status'];
    }
    
    if (isset($active_users[$user_id]) && $active_users[$user_id] == 0) {
        $blocked = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(248, 215, 218, 0.95);
            color: #721c24;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 1.5em;
            display: <?php echo $blocked ? 'flex' : 'none'; ?>;
        }
    </style>
</head>
<body>
    <div class="overlay">
        <div>
            <h1>This user is blocked</h1>
            <p>Your account has been blocked.</p>
            <p>Please request permission by contacting support.</p>
        </div>
    </div>
</body>
</html>
