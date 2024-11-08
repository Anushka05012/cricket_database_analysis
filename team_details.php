<?php
include 'database.php';  // Include the database connection

// Check if team_id is passed in the URL
if (isset($_GET['team_id']) && !empty($_GET['team_id'])) {
    $team_id = $_GET['team_id'];

    // Fetch team details from the database based on the team_id
    $sql = "SELECT * FROM Team WHERE TeamID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $team_id);  // Bind the team_id to the prepared statement

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $team = $result->fetch_assoc(); // Fetch the team details
        } else {
            $error_message = "Team not found.";
        }
    } else {
        $error_message = "Error executing query.";
    }
} else {
    $error_message = "Invalid Team ID.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Details - Cricket Analytics</title>
    <link rel="stylesheet" href="style.css">
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
    <div class="team-details">
        <?php if (isset($team)): ?>
            <h2>Team Details: <?= htmlspecialchars($team['Name']) ?></h2>
            <p><strong>Country:</strong> <?=     htmlspecialchars($team['Country']) ?></p>
            <p><strong>Coach:</strong> <?= htmlspecialchars($team['Coach_Name']) ?></p>
            <p><strong>Matches Played:</strong> <?= htmlspecialchars($team['TeamStats_Played']) ?></p>
            <p><strong>Matches won:</strong> <?= htmlspecialchars($team['TeamStats_Won']) ?></p>
            <p><strong>Matches Lost:</strong> <?= htmlspecialchars($team['TeamStats_Lost']) ?></p>
            <!-- Add other team details here as needed -->
        <?php else: ?>
            <p><?= isset($error_message) ? htmlspecialchars($error_message) : "Team not found." ?></p>
        <?php endif; ?>
    </div>
</main>

<footer>
    <div class="footer-container">
        <p>&copy; 2024 Cricket Analytics. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
