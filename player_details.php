<?php
include 'database.php';

$player_id = $_GET['id'];
$sql = "SELECT * FROM Players WHERE PlayerID = $player_id";
$result = $conn->query($sql);
$player = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo $player['Name']; ?> - Player Details</title>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Cricket Analytics - Player Details</h1>
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
            <h2><?php echo $player['Name']; ?></h2>
            <div class="player-details">
                <p>Country: <?php echo $player['Country']; ?></p>
                <p>Date of Birth: <?php echo $player['DOB']; ?></p>
                <p>Team ID: <?php echo $player['TeamID']; ?></p>
                <p>Batting Style: <?php echo $player['BattingStyle']; ?></p>
                <p>Bowling Style: <?php echo $player['BowlingStyle']; ?></p>
                <p>Role: <?php echo $player['Role']; ?></p>
                <p>Career Matches: <?php echo $player['CareerStats_Matches']; ?></p>
                <p>Career Runs: <?php echo $player['CareerStats_Runs']; ?></p>
                <p>Career Wickets: <?php echo $player['CareerStats_Wickets']; ?></p>
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
