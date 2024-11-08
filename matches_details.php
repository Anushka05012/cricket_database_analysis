<?php
include 'database.php';

if (isset($_GET['match_id'])) {
    $match_id = intval($_GET['match_id']); // Convert to integer to prevent SQL injection

    // Fetch match details
    $sql = "SELECT M.MatchID, M.Date, M.Time, V.Name AS Venue, T1.Name AS WinningTeam, T2.Name AS LosingTeam, M.MatchType 
            FROM Matches M 
            JOIN Venue V ON M.VenueID = V.VenueID 
            JOIN Team T1 ON M.WinningTeamID = T1.TeamID 
            JOIN Team T2 ON M.LosingTeamID = T2.TeamID 
            WHERE M.MatchID = $match_id";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $match = $result->fetch_assoc();
    } else {
        echo "<p>Match not found.</p>";
        exit;
    }
} else {
    echo "<p>Invalid match ID.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Match Details - <?php echo htmlspecialchars($match['MatchID']); ?></title>
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
            <h2>Match Details</h2>
            <h3>Match ID: <?php echo htmlspecialchars($match['MatchID']); ?></h3>
            <p>Date: <?php echo htmlspecialchars($match['Date']); ?></p>
            <p>Time: <?php echo htmlspecialchars($match['Time']); ?></p>
            <p>Venue: <?php echo htmlspecialchars($match['Venue']); ?></p>
            <p>Winning Team: <?php echo htmlspecialchars($match['WinningTeam']); ?></p>
            <p>Losing Team: <?php echo htmlspecialchars($match['LosingTeam']); ?></p>
            <p>Match Type: <?php echo htmlspecialchars($match['MatchType']); ?></p>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2024 Cricket Analytics. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
