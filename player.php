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
    $dob = $_POST['dob'];
    $country = $_POST['country'];
    $teamID = $_POST['teamID'];
    $battingStyle = $_POST['battingStyle'];
    $bowlingStyle = $_POST['bowlingStyle'];
    $role = $_POST['role'];
    $careerStatsMatches = $_POST['careerStatsMatches'];
    $careerStatsRuns = $_POST['careerStatsRuns'];
    $careerStatsWickets = $_POST['careerStatsWickets'];
    $runsConceded = $_POST['runsConceded'];
    $oversBowled = $_POST['oversBowled'];

    if (isset($_POST['PlayerID']) && $_POST['PlayerID'] != '') {
        // Update record
        $playerID = $_POST['PlayerID'];
        $sql = "UPDATE Players SET 
                Name='$name', 
                DOB='$dob', 
                Country='$country',
                TeamID='$teamID',
                BattingStyle='$battingStyle',
                BowlingStyle='$bowlingStyle',
                Role='$role',
                CareerStats_Matches='$careerStatsMatches',
                CareerStats_Runs='$careerStatsRuns',
                CareerStats_Wickets='$careerStatsWickets',
                Runs_Conceded='$runsConceded',
                Overs_Bowled='$oversBowled'
                WHERE PlayerID=$playerID";
    } else {
        // Insert new record
        $sql = "INSERT INTO Players 
                (Name, DOB, Country, TeamID, BattingStyle, BowlingStyle, Role, CareerStats_Matches, CareerStats_Runs, CareerStats_Wickets, Runs_Conceded, Overs_Bowled) 
                VALUES 
                ('$name', '$dob', '$country', '$teamID', '$battingStyle', '$bowlingStyle', '$role', '$careerStatsMatches', '$careerStatsRuns', '$careerStatsWickets', '$runsConceded', '$oversBowled')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: player.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Delete action
if (isset($_GET['delete'])) {
    $playerID = $_GET['delete'];
    $sql = "DELETE FROM Players WHERE PlayerID=$playerID";
    if ($conn->query($sql) === TRUE) {
        header("Location: player.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch all players
$sql = "SELECT * FROM Players";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Players</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Player Management</h2>

        <!-- Player Form -->
        <form action="player.php" method="POST">
            <input type="hidden" name="PlayerID" id="playerId">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input type="text" class="form-control" id="country" name="country">
            </div>
            <div class="mb-3">
                <label for="teamID" class="form-label">Team ID</label>
                <input type="text" class="form-control" id="teamID" name="teamID">
            </div>
            <div class="mb-3">
                <label for="battingStyle" class="form-label">Batting Style</label>
                <input type="text" class="form-control" id="battingStyle" name="battingStyle">
            </div>
            <div class="mb-3">
                <label for="bowlingStyle" class="form-label">Bowling Style</label>
                <input type="text" class="form-control" id="bowlingStyle" name="bowlingStyle">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <input type="text" class="form-control" id="role" name="role">
            </div>
            <div class="mb-3">
                <label for="careerStatsMatches" class="form-label">Career Matches</label>
                <input type="number" class="form-control" id="careerStatsMatches" name="careerStatsMatches">
            </div>
            <div class="mb-3">
                <label for="careerStatsRuns" class="form-label">Career Runs</label>
                <input type="number" class="form-control" id="careerStatsRuns" name="careerStatsRuns">
            </div>
            <div class="mb-3">
                <label for="careerStatsWickets" class="form-label">Career Wickets</label>
                <input type="number" class="form-control" id="careerStatsWickets" name="careerStatsWickets">
            </div>
            <div class="mb-3">
                <label for="runsConceded" class="form-label">Runs Conceded</label>
                <input type="number" class="form-control" id="runsConceded" name="runsConceded">
            </div>
            <div class="mb-3">
                <label for="oversBowled" class="form-label">Overs Bowled</label>
                <input type="number" class="form-control" id="oversBowled" name="oversBowled">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <hr>

        <!-- Player List -->
        <h3>Player List</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Country</th>
                    <th>Team ID</th>
                    <th>Batting Style</th>
                    <th>Bowling Style</th>
                    <th>Role</th>
                    <th>Career Matches</th>
                    <th>Career Runs</th>
                    <th>Career Wickets</th>
                    <th>Runs Conceded</th>
                    <th>Overs Bowled</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['DOB']); ?></td>
                            <td><?php echo htmlspecialchars($row['Country']); ?></td>
                            <td><?php echo htmlspecialchars($row['TeamID']); ?></td>
                            <td><?php echo htmlspecialchars($row['BattingStyle']); ?></td>
                            <td><?php echo htmlspecialchars($row['BowlingStyle']); ?></td>
                            <td><?php echo htmlspecialchars($row['Role']); ?></td>
                            <td><?php echo htmlspecialchars($row['CareerStats_Matches']); ?></td>
                            <td><?php echo htmlspecialchars($row['CareerStats_Runs']); ?></td>
                            <td><?php echo htmlspecialchars($row['CareerStats_Wickets']); ?></td>
                            <td><?php echo htmlspecialchars($row['Runs_Conceded']); ?></td>
                            <td><?php echo htmlspecialchars($row['Overs_Bowled']); ?></td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-sm btn-warning" onclick="editPlayer(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</a>
                                <a href="player.php?delete=<?php echo $row['PlayerID']; ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="13">No players found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editPlayer(player) {
            document.getElementById('playerId').value = player.PlayerID;
            document.getElementById('name').value = player.Name;
            document.getElementById('dob').value = player.DOB;
            document.getElementById('country').value = player.Country;
            document.getElementById('teamID').value = player.TeamID;
            document.getElementById('battingStyle').value = player.BattingStyle;
            document.getElementById('bowlingStyle').value = player.BowlingStyle;
            document.getElementById('role').value = player.Role;
            document.getElementById('careerStatsMatches').value = player.CareerStats_Matches;
            document.getElementById('careerStatsRuns').value = player.CareerStats_Runs;
            document.getElementById('careerStatsWickets').value = player.CareerStats_Wickets;
            document.getElementById('runsConceded').value = player.Runs_Conceded;
            document.getElementById('oversBowled').value = player.Overs_Bowled;
        }
    </script>
</body>
</html>
