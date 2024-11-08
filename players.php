<?php
include 'database.php';

function getFlagEmoji($countryCode) {
    $countryCode = strtoupper($countryCode);
    if (strlen($countryCode) !== 2) {
        return ''; // Return empty if the code isn't exactly two characters
    }
    $flagOffset = 127397; // Offset for regional indicator symbols
    $emoji = '';

    for ($i = 0; $i < 2; $i++) {
        $emoji .= mb_chr(ord($countryCode[$i]) + $flagOffset, 'UTF-8');
    }
    return $emoji;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Players List</title>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Cricket Analytics - Players</h1>
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
            <h2>Players List</h2>
            <div class="players-list">
                <?php
                $sql = "SELECT PlayerID, Name, Country FROM Players";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $flagEmoji = getFlagEmoji($row['Country']); // Get flag emoji based on country code
                        echo '<div class="player-info">';
                        echo '<a href="player_details.php?id=' . $row['PlayerID'] . '">';
                        echo $row['Name'] . ' (' . $flagEmoji . ' ' . $row['Country'] . ')';
                        echo '</a>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No players found.</p>";
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
</body>
</html>
