<?php
include 'database.php';

if (isset($_GET['id'])) {
    $tournamentID = intval($_GET['id']);
    $sql = "SELECT * FROM Tournaments WHERE TournamentID = $tournamentID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $tournament = $result->fetch_assoc();
    } else {
        echo "Invalid tournament ID.";
        exit;
    }
} else {
    echo "No tournament ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo htmlspecialchars($tournament['Name']); ?> - Tournament Details</title>
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
        <div class="content-container details-section">
            <h2><?php echo htmlspecialchars($tournament['Name']); ?></h2>
            <p><strong>Year:</strong> <?php echo htmlspecialchars($tournament['Year']); ?></p>
            <p><strong>Winning Team:</strong> <?php echo htmlspecialchars($tournament['WinningTeam']); ?></p>
            <p><strong>Matches Played:</strong> <?php echo htmlspecialchars($tournament['NumberOfMatches']); ?></p>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2024 Cricket Analytics. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
