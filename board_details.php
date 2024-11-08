<?php
include 'database.php';

if (isset($_GET['board_id'])) {
    $board_id = intval($_GET['board_id']); // Convert to integer to prevent SQL injection

    // Fetch board details
    $sql = "SELECT * FROM CricketBoards WHERE BoardID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $board_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $board = $result->fetch_assoc();
    } else {
        echo "<p>Board not found.</p>";
        exit;
    }
} else {
    echo "<p>Invalid board ID.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo htmlspecialchars($board['Name']); ?> - Board Details</title>
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
            <div class="details-section">
                <h2>Board Details</h2>
                <h3><?php echo htmlspecialchars($board['Name']); ?></h3>
                <p><strong>Country:</strong> <?php echo htmlspecialchars($board['Country']); ?></p>
                <p><strong>Founded Date:</strong> <?php echo htmlspecialchars($board['FoundedDate']); ?></p>
                <p><strong>Headquarters:</strong> <?php echo htmlspecialchars($board['Headquarters']); ?></p>
                <!-- Uncomment below lines if you add additional columns to the table -->
                <!-- <p><strong>Chairman:</strong> <?php echo htmlspecialchars($board['Chairman']); ?></p>
                <p><strong>Contact:</strong> <?php echo htmlspecialchars($board['Contact']); ?></p>
                <p><strong>Website:</strong> <?php echo htmlspecialchars($board['Website']); ?></p> -->
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
