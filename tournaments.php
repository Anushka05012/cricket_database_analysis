<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: admin.php");
    exit();
}
?>

<?php
// Include database connection
include 'database.php';

// Handle Create & Update actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $year = $_POST['year'];
    $winningTeam = $_POST['winningTeam'];
    $numberOfMatches = $_POST['numberOfMatches'];

    if (isset($_POST['id']) && $_POST['id'] != '') {
        // Update record
        $id = $_POST['id'];
        $sql = "UPDATE Tournaments SET 
                Name='$name', 
                Year='$year', 
                WinningTeam='$winningTeam',
                NumberOfMatches='$numberOfMatches'
                WHERE TournamentID=$id";
    } else {
        // Insert new record
        $sql = "INSERT INTO Tournaments 
                (Name, Year, WinningTeam, NumberOfMatches) 
                VALUES 
                ('$name', '$year', '$winningTeam', '$numberOfMatches')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: tournaments.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Delete action
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM Tournaments WHERE TournamentID=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: tournaments.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch all tournaments
$sql = "SELECT * FROM Tournaments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tournaments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Tournament Management</h2>

        <!-- Tournament Form -->
        <form action="tournaments.php" method="POST">
            <input type="hidden" name="id" id="tournamentId">
            <div class="mb-3">
                <label for="name" class="form-label">Tournament Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <input type="number" class="form-control" id="year" name="year" required>
            </div>
            <div class="mb-3">
                <label for="winningTeam" class="form-label">Winning Team</label>
                <input type="text" class="form-control" id="winningTeam" name="winningTeam">
            </div>
            <div class="mb-3">
                <label for="numberOfMatches" class="form-label">Number of Matches</label>
                <input type="number" class="form-control" id="numberOfMatches" name="numberOfMatches">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <hr>

        <!-- Tournament List -->
        <h3>Tournament List</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tournament Name</th>
                    <th>Year</th>
                    <th>Winning Team</th>
                    <th>Number of Matches</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['Year']); ?></td>
                            <td><?php echo htmlspecialchars($row['WinningTeam']); ?></td>
                            <td><?php echo htmlspecialchars($row['NumberOfMatches']); ?></td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-sm btn-warning" onclick="editTournament(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</a>
                                <a href="tournaments.php?delete=<?php echo $row['TournamentID']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this tournament?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No tournaments found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editTournament(tournament) {
            document.getElementById('tournamentId').value = tournament.TournamentID;
            document.getElementById('name').value = tournament.Name;
            document.getElementById('year').value = tournament.Year;
            document.getElementById('winningTeam').value = tournament.WinningTeam;
            document.getElementById('numberOfMatches').value = tournament.NumberOfMatches;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
