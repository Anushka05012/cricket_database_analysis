<?php
include 'database.php';

// Fetch venues from the database
$sql = "SELECT * FROM Venue";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Venues - Cricket Analytics</title>
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
            <h2>Venues</h2>
            <div class="list-section venues-list">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="venue-info">';
                        echo '<h3><a href="venue_details.php?venue_id=' . $row['VenueID'] . '">' . htmlspecialchars($row['Name']) . '</a></h3>';
                        echo '<p>Location: ' . htmlspecialchars($row['Location']) . '</p>';
                        echo '<p>Capacity: ' . htmlspecialchars($row['Capacity']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No venues found.</p>";
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
