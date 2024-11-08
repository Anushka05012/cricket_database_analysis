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
    $teamID = $_POST['teamID'];
    $name = $_POST['name'];
    $country = $_POST['country'];
    $coachName = $_POST['coachName'];
    $coachDOB = $_POST['coachDOB'];
    $teamStatsPlayed = $_POST['teamStatsPlayed'];
    $teamStatsWon = $_POST['teamStatsWon'];
    $teamStatsLost = $_POST['teamStatsLost'];

    if (isset($_POST['id']) && $_POST['id'] != '') {
        // Update record
        $id = $_POST['id'];
        $sql = "UPDATE Team SET 
                TeamID='$teamID', 
                Name='$name', 
                Country='$country',
                Coach_Name='$coachName',
                Coach_DOB='$coachDOB',
                TeamStats_Played='$teamStatsPlayed',
                TeamStats_Won='$teamStatsWon',
                TeamStats_Lost='$teamStatsLost'
                WHERE id=$id";
    } else {
        // Insert new record
        $sql = "INSERT INTO Team 
                (TeamID, Name, Country, Coach_Name, Coach_DOB, TeamStats_Played, TeamStats_Won, TeamStats_Lost) 
                VALUES 
                ('$teamID', '$name', '$country', '$coachName', '$coachDOB', '$teamStatsPlayed', '$teamStatsWon', '$teamStatsLost')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: teams.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Delete action
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Check if the 'id' is a valid number
    if (is_numeric($id)) {
        $sql = "DELETE FROM Team WHERE id=$id"; // Update the table name to 'Team'
        if ($conn->query($sql) === TRUE) {
            header("Location: teams.php");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Invalid Team ID for deletion.";
    }
}

// Fetch all teams
$sql = "SELECT * FROM Team"; // Update the table name to 'Team'
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teams</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Team Management</h2>

        <!-- Team Form -->
        <form action="teams.php" method="POST">
            <input type="hidden" name="id" id="teamId">
            <div class="mb-3">
                <label for="teamID" class="form-label">Team ID</label>
                <input type="text" class="form-control" id="teamID" name="teamID" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input type="text" class="form-control" id="country" name="country">
            </div>
            <div class="mb-3">
                <label for="coachName" class="form-label">Coach Name</label>
                <input type="text" class="form-control" id="coachName" name="coachName">
            </div>
            <div class="mb-3">
                <label for="coachDOB" class="form-label">Coach Date of Birth</label>
                <input type="date" class="form-control" id="coachDOB" name="coachDOB">
            </div>
            <div class="mb-3">
                <label for="teamStatsPlayed" class="form-label">Matches Played</label>
                <input type="number" class="form-control" id="teamStatsPlayed" name="teamStatsPlayed">
            </div>
            <div class="mb-3">
                <label for="teamStatsWon" class="form-label">Matches Won</label>
                <input type="number" class="form-control" id="teamStatsWon" name="teamStatsWon">
            </div>
            <div class="mb-3">
                <label for="teamStatsLost" class="form-label">Matches Lost</label>
                <input type="number" class="form-control" id="teamStatsLost" name="teamStatsLost">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <hr>

        <!-- Team List -->
        <h3>Team List</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Team ID</th>
                    <th>Name</th>
                    <th>Country</th>
                    <th>Coach Name</th>
                    <th>Coach DOB</th>
                    <th>Matches Played</th>
                    <th>Matches Won</th>
                    <th>Matches Lost</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['TeamID']); ?></td>
                <td><?php echo htmlspecialchars($row['Name']); ?></td>
                <td><?php echo htmlspecialchars($row['Country']); ?></td>
                <td><?php echo htmlspecialchars($row['Coach_Name']); ?></td>
                <td><?php echo htmlspecialchars($row['Coach_DOB']); ?></td>
                <td><?php echo htmlspecialchars($row['TeamStats_Played']); ?></td>
                <td><?php echo htmlspecialchars($row['TeamStats_Won']); ?></td>
                <td><?php echo htmlspecialchars($row['TeamStats_Lost']); ?></td>
                <td>
                    <a href="javascript:void(0);" class="btn btn-sm btn-warning" onclick="editTeam(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</a>
                    <a href="teams.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this team?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="9">No teams found</td>
        </tr>
    <?php endif; ?>
</tbody>

        </table>
    </div>

    <script>
        function editTeam(team) {
            document.getElementById('teamId').value = team.id;
            document.getElementById('teamID').value = team.TeamID;
            document.getElementById('name').value = team.Name;
            document.getElementById('country').value = team.Country;
            document.getElementById('coachName').value = team.Coach_Name;
            document.getElementById('coachDOB').value = team.Coach_DOB;
            document.getElementById('teamStatsPlayed').value = team.TeamStats_Played;
            document.getElementById('teamStatsWon').value = team.TeamStats_Won;
            document.getElementById('teamStatsLost').value = team.TeamStats_Lost;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
