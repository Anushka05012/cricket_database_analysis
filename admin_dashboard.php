<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Admin Dashboard</h1>
        <div class="list-group">
            <a href="match.php" class="list-group-item">Matches</a>
            <a href="player.php" class="list-group-item">Player</a>
            <a href="teams.php" class="list-group-item">Teams</a>
            <a href="tournaments.php" class="list-group-item">Tournament</a>
            <a href="venu.php" class="list-group-item">Venue</a>
            <a href="cricket_boards.php" class="list-group-item">Cricket Boards</a>
            <a href="view_reports.php" class="list-group-item">Reports</a>
            <a href="manage_enquiry.php" class="list-group-item">Enquiry</a>
            <a href="search_registration.php" class="list-group-item">Search</a>
            
        </div>
        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>


</body>
</html>
