<?php
include 'database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cricket Analytics - Home</title>
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
            <h2>Upcoming and Ongoing Matches</h2>
            <div class="matches-list">
                <?php
                // Fetch upcoming and ongoing matches
                $sql = "SELECT m.MatchID, m.Date, m.Time, t1.Name AS WinningTeam, t2.Name AS LosingTeam 
                        FROM Matches m 
                        JOIN Team t1 ON m.WinningTeamID = t1.TeamID 
                        JOIN Team t2 ON m.LosingTeamID = t2.TeamID 
                        WHERE m.Date >= CURDATE() 
                        ORDER BY m.Date ASC";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="match-info">';
                        echo '<p>Date: ' . $row['Date'] . ' | Time: ' . $row['Time'] . '</p>';
                        echo '<p>Match: ' . $row['WinningTeam'] . ' vs ' . $row['LosingTeam'] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No upcoming or ongoing matches found.</p>";
                }
                ?>
            </div>

            <!-- Ad Container -->
            <div class="ad-container">
                <!-- Replace with ad code, e.g., Google AdSense -->
                <p>Advertisement</p>
                <script>
                    // Insert ad script here, such as Google AdSense
                    // Example: 
                    // (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <!-- End of Ad Container -->

            <h2>Tournaments</h2>
            <div class="tournaments-list">
                <?php
                // Fetch tournaments
                $sql = "SELECT * FROM Tournaments";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="tournament-info">';
                        echo '<h3>' . $row['Name'] . ' (' . $row['Year'] . ')</h3>';
                        echo '<p>Winning Team: ' . $row['WinningTeam'] . '</p>';
                        echo '<p>Matches: ' . $row['NumberOfMatches'] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No tournaments found.</p>";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2024 Cricket Analytics. All rights reserved.</p>
            <ul class="social-icons">
                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
