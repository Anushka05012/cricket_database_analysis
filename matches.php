<?php
include 'database.php';

// Fetch all matches
$sql = "SELECT M.MatchID, M.Date, M.Time, V.Name AS Venue, T1.Name AS WinningTeam, T2.Name AS LosingTeam, M.MatchType 
        FROM Matches M 
        JOIN Venue V ON M.VenueID = V.VenueID 
        JOIN Team T1 ON M.WinningTeamID = T1.TeamID 
        JOIN Team T2 ON M.LosingTeamID = T2.TeamID";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Matches</title>
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
            <h2>Matches</h2>
            <table>
                <thead>
                    <tr>
                        <th>Match ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Venue</th>
                        <th>Winning Team</th>
                        <th>Losing Team</th>
                        <th>Match Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($match = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($match['MatchID']) . '</td>';
                            echo '<td>' . htmlspecialchars($match['Date']) . '</td>';
                            echo '<td>' . htmlspecialchars($match['Time']) . '</td>';
                            echo '<td>' . htmlspecialchars($match['Venue']) . '</td>';
                            echo '<td>' . htmlspecialchars($match['WinningTeam']) . '</td>';
                            echo '<td>' . htmlspecialchars($match['LosingTeam']) . '</td>';
                            echo '<td>' . htmlspecialchars($match['MatchType']) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "<tr><td colspan='7'>No matches found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2024 Cricket Analytics. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
