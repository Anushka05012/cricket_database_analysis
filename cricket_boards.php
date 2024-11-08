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
    $country = $_POST['country'];
    $foundedDate = $_POST['foundedDate'];
    $headquarters = $_POST['headquarters'];

    if (isset($_POST['id']) && $_POST['id'] != '') {
        // Update record
        $id = $_POST['id'];
        $sql = "UPDATE CricketBoards SET 
                Name='$name', 
                Country='$country', 
                FoundedDate='$foundedDate', 
                Headquarters='$headquarters' 
                WHERE BoardID=$id";
    } else {
        // Insert new record
        $sql = "INSERT INTO CricketBoards 
                (Name, Country, FoundedDate, Headquarters) 
                VALUES 
                ('$name', '$country', '$foundedDate', '$headquarters')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: cricket_boards.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Delete action
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM CricketBoards WHERE BoardID=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: cricket_boards.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch all cricket boards
$sql = "SELECT * FROM CricketBoards";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cricket Boards</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Cricket Boards Management</h2>

        <!-- Cricket Boards Form -->
        <form action="cricket_boards.php" method="POST">
            <input type="hidden" name="id" id="boardId">
            <div class="mb-3">
                <label for="name" class="form-label">Board Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input type="text" class="form-control" id="country" name="country" required>
            </div>
            <div class="mb-3">
                <label for="foundedDate" class="form-label">Founded Date</label>
                <input type="date" class="form-control" id="foundedDate" name="foundedDate" required>
            </div>
            <div class="mb-3">
                <label for="headquarters" class="form-label">Headquarters</label>
                <textarea class="form-control" id="headquarters" name="headquarters" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <hr>

        <!-- Cricket Boards List -->
        <h3>Cricket Boards List</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Board Name</th>
                    <th>Country</th>
                    <th>Founded Date</th>
                    <th>Headquarters</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['Country']); ?></td>
                            <td><?php echo htmlspecialchars($row['FoundedDate']); ?></td>
                            <td><?php echo htmlspecialchars($row['Headquarters']); ?></td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-sm btn-warning" onclick="editBoard(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</a>
                                <a href="cricket_boards.php?delete=<?php echo $row['BoardID']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this board?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No cricket boards found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editBoard(board) {
            document.getElementById('boardId').value = board.BoardID;
            document.getElementById('name').value = board.Name;
            document.getElementById('country').value = board.Country;
            document.getElementById('foundedDate').value = board.FoundedDate;
            document.getElementById('headquarters').value = board.Headquarters;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
