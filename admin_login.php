<?php
session_start();
if (isset($_SESSION["admin"])) {
    header("Location: admin_dashboard.php");
    exit();
}

// Define hardcoded admin credentials
$admin_email = "admin@gmail.com";
$admin_password = "Admin123"; // You can also hash this password for better security

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if the provided credentials match the hardcoded ones
    if ($email === $admin_email && $password === $admin_password) {
        $_SESSION["admin"] = "yes";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Invalid email or password</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <form action="admin_login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control" required>
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>
</html>
