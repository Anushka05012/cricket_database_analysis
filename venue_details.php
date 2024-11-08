<?php
include 'database.php';

if (isset($_GET['venue_id'])) {
    $venue_id = intval($_GET['venue_id']); // Convert to integer to prevent SQL injection

    // Fetch venue details
    $sql = "SELECT * FROM Venue WHERE VenueID = $venue_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $venue = $result->fetch_assoc();
    } else {
        echo "<p>Venue not found.</p>";
        exit;
    }
} else {
    echo "<p>Invalid venue ID.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo htmlspecialchars($venue['Name']); ?> - Venue Details</title>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Cricket Analytics</h1>
            <nav class="nav-bar">
                <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="players.php">Players</a></li>
                        <li><a href="matches.php">Matches</a></li>
                        <li><a href="venue.php">Venue</a></li>
                        <li><a href="board.php">Board</a></li>
                        <li><a href="tournament.php">Tournament</a></li>
                        <li><a href="team.php">Teams</a></li>
                        <li><a href="compare_players.php">Compare Players</a></li>
                        <li><a href="admin_login.php">Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="content-container">
            <h2>Venue Details</h2>
            <div class="details-section">
                <h3>Name: <?php echo htmlspecialchars($venue['Name']); ?></h3>
                <p>Location: <?php echo htmlspecialchars($venue['Location']); ?></p>
                <p>Capacity: <?php echo htmlspecialchars($venue['Capacity']); ?></p>
                <p>Year of Establishment: <?php echo htmlspecialchars($venue['YearOfEstablishment']); ?></p>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2024 Cricket Analytics. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
