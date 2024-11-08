<?php
include 'database.php';

// Fetch all cricket boards
$sql = "SELECT * FROM CricketBoards";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cricket Boards</title>
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
            <h2>Cricket Boards</h2>
            <div class="list-section boards-list">
                <?php
                if ($result->num_rows > 0) {
                    while($board = $result->fetch_assoc()) {
                        echo '<div class="list-item board-info">';
                        echo '<a href="board_details.php?board_id=' . $board['BoardID'] . '">' . htmlspecialchars($board['Name']) . '</a>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No cricket boards found.</p>";
                }
                ?>
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
