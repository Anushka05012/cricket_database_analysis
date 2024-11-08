<?php
include 'database.php';

// Get match ID from the URL
$matchID = isset($_GET['match_id']) ? intval($_GET['match_id']) : 0;

// Fetch match details
$matchQuery = "SELECT Matches.*, Venue.Name AS VenueName, t1.Name AS WinningTeamName, t2.Name AS LosingTeamName
               FROM Matches
               JOIN Venue ON Matches.VenueID = Venue.VenueID
               JOIN Team t1 ON Matches.WinningTeamID = t1.TeamID
               JOIN Team t2 ON Matches.LosingTeamID = t2.TeamID
               WHERE Matches.MatchID = $matchID";
$matchResult = $conn->query($matchQuery);

if ($matchResult->num_rows > 0) {
    $match = $matchResult->fetch_assoc();
} else {
    echo "Match not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Match Details</h2>
        <p><strong>Date:</strong> <?= htmlspecialchars($match['Date']) ?></p>
        <p><strong>Time:</strong> <?= htmlspecialchars($match['Time']) ?></p>
        <p><strong>Venue:</strong> <?= htmlspecialchars($match['VenueName']) ?></p>
        <p><strong>Teams:</strong> <?= htmlspecialchars($match['WinningTeamName']) ?> vs <?= htmlspecialchars($match['LosingTeamName']) ?></p>
        <p><strong>Match Type:</strong> <?= htmlspecialchars($match['MatchType']) ?></p>
        <p><strong>Winner:</strong> <?= htmlspecialchars($match['WinningTeamName']) ?></p>
        <a href="matches.php" class="btn btn-primary">Back to Matches</a>
    </div>
</body>
</html>
