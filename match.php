<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: admin.php");
    exit();
}

// Include database connection
include 'database.php';

// Handle Create & Update actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matchID = $_POST['id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $venueID = $_POST['venueID'];
    $winningTeamID = $_POST['winningTeamID'];
    $losingTeamID = $_POST['losingTeamID'];
    $matchType = $_POST['matchType'];

    if (!empty($matchID)) {
        // Update record
        $sql = "UPDATE Matches SET 
                Date='$date', 
                Time='$time', 
                VenueID='$venueID', 
                WinningTeamID='$winningTeamID', 
                LosingTeamID='$losingTeamID', 
                MatchType='$matchType'
                WHERE MatchID='$matchID'";
    } else {
        // Insert new record
        $sql = "INSERT INTO Matches 
                (Date, Time, VenueID, WinningTeamID, LosingTeamID, MatchType) 
                VALUES 
                ('$date', '$time', '$venueID', '$winningTeamID', '$losingTeamID', '$matchType')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: match.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Delete action
if (isset($_GET['delete'])) {
    $matchID = $_GET['delete'];
    $sql = "DELETE FROM Matches WHERE MatchID='$matchID'";
    if ($conn->query($sql) === TRUE) {
        header("Location: match.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch all matches
$sql = "SELECT * FROM Matches"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Matches</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Match Management</h2>

        <!-- Match Form -->
        <form action="match.php" method="POST">
            <input type="hidden" name="id" id="matchId">
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="time" class="form-label">Time</label>
                <input type="time" class="form-control" id="time" name="time" required>
            </div>
            <div class="mb-3">
                <label for="venueID" class="form-label">Venue ID</label>
                <input type="number" class="form-control" id="venueID" name="venueID" required>
            </div>
            <div class="mb-3">
                <label for="winningTeamID" class="form-label">Winning Team ID</label>
                <input type="number" class="form-control" id="winningTeamID" name="winningTeamID" required>
            </div>
            <div class="mb-3">
                <label for="losingTeamID" class="form-label">Losing Team ID</label>
                <input type="number" class="form-control" id="losingTeamID" name="losingTeamID" required>
            </div>
            <div class="mb-3">
                <label for="matchType" class="form-label">Match Type</label>
                <input type="text" class="form-control" id="matchType" name="matchType" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <hr>

        <!-- Match List -->
        <h3>Match List</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Venue ID</th>
                    <th>Winning Team ID</th>
                    <th>Losing Team ID</th>
                    <th>Match Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($match = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $match['Date'] ?></td>
                            <td><?= $match['Time'] ?></td>
                            <td><?= $match['VenueID'] ?></td>
                            <td><?= $match['WinningTeamID'] ?></td>
                            <td><?= $match['LosingTeamID'] ?></td>
                            <td><?= $match['MatchType'] ?></td>
                            <td>
                                <button onclick='editMatch(<?= json_encode($match) ?>)' class="btn btn-warning">Edit</button>
                                <a href="?delete=<?= $match['MatchID'] ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No matches found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editMatch(match) {
            document.getElementById('matchId').value = match.MatchID;
            document.getElementById('date').value = match.Date.split('T')[0]; // format for date input
            document.getElementById('time').value = match.Time; // time in the correct format
            document.getElementById('venueID').value = match.VenueID;
            document.getElementById('winningTeamID').value = match.WinningTeamID;
            document.getElementById('losingTeamID').value = match.LosingTeamID;
            document.getElementById('matchType').value = match.MatchType;
        }
    </script>
</body>
</html>
