<?php
include 'database.php';

$error_message = "";
$players = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['player1']) && isset($_POST['player2']) && !empty($_POST['player1']) && !empty($_POST['player2'])) {
    $player1 = '%' . trim($_POST['player1']) . '%';
    $player2 = '%' . trim($_POST['player2']) . '%';

    // Call stored procedure
    $sql = "CALL GetPlayerComparison(?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $player1, $player2);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $players[] = $row;
        }

        // Check if both players are found
        if (count($players) == 2) {
            // Access already calculated averages from the stored procedure result
            $average_runs_player1 = $players[0]['AverageRuns'];
            $average_runs_player2 = $players[1]['AverageRuns'];

            $average_wickets_player1 = $players[0]['Economy'];
            $average_wickets_player2 = $players[1]['Economy'];
        } else {
            $error_message = "One or both players not found. Please check the names and try again.";
        }
    } else {
        $error_message = "Error executing query: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare Players</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Header -->
<div class="header-container">
    <h1>Compare Players</h1>
</div>

<!-- Navigation Bar -->
<div class="nav-bar">
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
</div>

<!-- Content Section -->
<div class="content-container">
    <h2>Enter Player Names to Compare</h2>

    <form method="POST" action="compare_players.php" class="search-form">
        <label for="player1">Player 1:</label>
        <input type="text" name="player1" required>

        <label for="player2">Player 2:</label>
        <input type="text" name="player2" required>

        <button type="submit" class="btn">Compare</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <?php if (count($players) == 2): ?>
            <div class="list-section">
                <h2>Comparison Result</h2>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Attribute</th>
                            <th><?= htmlspecialchars($players[0]['Name']) ?></th>
                            <th><?= htmlspecialchars($players[1]['Name']) ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Player ID</td>
                            <td><?= htmlspecialchars($players[0]['PlayerID']) ?></td>
                            <td><?= htmlspecialchars($players[1]['PlayerID']) ?></td>
                        </tr>
                        <tr>
                            <td>Team ID</td>
                            <td><?= htmlspecialchars($players[0]['TeamID']) ?></td>
                            <td><?= htmlspecialchars($players[1]['TeamID']) ?></td>
                        </tr>
                        <tr>
                            <td>Batting Style</td>
                            <td><?= htmlspecialchars($players[0]['BattingStyle']) ?></td>
                            <td><?= htmlspecialchars($players[1]['BattingStyle']) ?></td>
                        </tr>
                        <tr>
                            <td>Bowling Style</td>
                            <td><?= htmlspecialchars($players[0]['BowlingStyle']) ?></td>
                            <td><?= htmlspecialchars($players[1]['BowlingStyle']) ?></td>
                        </tr>
                        <tr>
                            <td>Career Matches</td>
                            <td><?= htmlspecialchars($players[0]['CareerStats_Matches']) ?></td>
                            <td><?= htmlspecialchars($players[1]['CareerStats_Matches']) ?></td>
                        </tr>
                        <tr>
                            <td>Career Runs</td>
                            <td><?= htmlspecialchars($players[0]['CareerStats_Runs']) ?></td>
                            <td><?= htmlspecialchars($players[1]['CareerStats_Runs']) ?></td>
                        </tr>
                        <tr>
                            <td>Career Wickets</td>
                            <td><?= htmlspecialchars($players[0]['CareerStats_Wickets']) ?></td>
                            <td><?= htmlspecialchars($players[1]['CareerStats_Wickets']) ?></td>
                        </tr>
                        <tr>
                            <td>Average</td>
                            <td><?= round($average_runs_player1, 2) ?></td>
                            <td><?= round($average_runs_player2, 2) ?></td>
                        </tr>
                        <tr>
                            <td>Economy</td>
                            <td><?= round($average_wickets_player1, 2) ?></td>
                            <td><?= round($average_wickets_player2, 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php elseif (!empty($error_message)): ?>
            <p><?= $error_message ?></p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- Footer -->
<div class="footer-container">
    <p>&copy; 2024 Cricket Database</p>
</div>

</body>
</html>
