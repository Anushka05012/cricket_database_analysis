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
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];
    $yearOfEstablishment = $_POST['yearOfEstablishment'];

    if (isset($_POST['id']) && $_POST['id'] != '') {
        // Update record
        $id = $_POST['id'];
        $sql = "UPDATE Venue SET 
                Name='$name', 
                Location='$location', 
                Capacity='$capacity',
                YearOfEstablishment='$yearOfEstablishment'
                WHERE VenueID=$id";
    } else {
        // Insert new record
        $sql = "INSERT INTO Venue 
                (Name, Location, Capacity, YearOfEstablishment) 
                VALUES 
                ('$name', '$location', '$capacity', '$yearOfEstablishment')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: venu.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Delete action
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM Venue WHERE VenueID=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: venue.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch all venues
$sql = "SELECT * FROM Venue";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Venues</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Venue Management</h2>

        <!-- Venue Form -->
        <form action="venu.php" method="POST">
            <input type="hidden" name="id" id="venueId">
            <div class="mb-3">
                <label for="name" class="form-label">Venue Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>
            <div class="mb-3">
                <label for="capacity" class="form-label">Capacity</label>
                <input type="number" class="form-control" id="capacity" name="capacity" required>
            </div>
            <div class="mb-3">
                <label for="yearOfEstablishment" class="form-label">Year of Establishment</label>
                <input type="number" class="form-control" id="yearOfEstablishment" name="yearOfEstablishment" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <hr>

        <!-- Venue List -->
        <h3>Venue List</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Venue Name</th>
                    <th>Location</th>
                    <th>Capacity</th>
                    <th>Year of Establishment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['Location']); ?></td>
                            <td><?php echo htmlspecialchars($row['Capacity']); ?></td>
                            <td><?php echo htmlspecialchars($row['YearOfEstablishment']); ?></td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-sm btn-warning" onclick="editVenue(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</a>
                                <a href="venu.php?delete=<?php echo $row['VenueID']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this venue?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No venues found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editVenue(venue) {
            document.getElementById('venueId').value = venue.VenueID;
            document.getElementById('name').value = venue.Name;
            document.getElementById('location').value = venue.Location;
            document.getElementById('capacity').value = venue.Capacity;
            document.getElementById('yearOfEstablishment').value = venue.YearOfEstablishment;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
