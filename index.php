<?php
// config.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new student
    if (isset($_POST['add'])) {
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $age = (int)$_POST['age'];
        
        $sql = "INSERT INTO students (name, email, age) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $email, $age);
        
        if ($stmt->execute()) {
            $message = "Student added successfully!";
        } else {
            $error = "Error adding student: " . $conn->error;
        }
        $stmt->close();
    }
    
    // Update student
    if (isset($_POST['update'])) {
        $id = (int)$_POST['id'];
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $age = (int)$_POST['age'];
        
        $sql = "UPDATE students SET name=?, email=?, age=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $name, $email, $age, $id);
        
        if ($stmt->execute()) {
            $message = "Student updated successfully!";
        } else {
            $error = "Error updating student: " . $conn->error;
        }
        $stmt->close();
    }
    
    // Delete student
    if (isset($_POST['delete'])) {
        $id = (int)$_POST['id'];
        
        $sql = "DELETE FROM students WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $message = "Student deleted successfully!";
        } else {
            $error = "Error deleting student: " . $conn->error;
        }
        $stmt->close();
    }
}

// Fetch student for editing
$edit_student = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $result = $conn->query("SELECT * FROM students WHERE id=$edit_id");
    if ($result->num_rows > 0) {
        $edit_student = $result->fetch_assoc();
    }
}

// Fetch all students
$students = $conn->query("SELECT * FROM students ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Elites Student Management System</h1>
        
        <?php if (isset($message)): ?>
            <div class="message success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <h2><?php echo $edit_student ? 'Edit Student' : 'Add New Student'; ?></h2>
        <form method="POST" action="">
            <?php if ($edit_student): ?>
                <input type="hidden" name="id" value="<?php echo $edit_student['id']; ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $edit_student ? $edit_student['name'] : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $edit_student ? $edit_student['email'] : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo $edit_student ? $edit_student['age'] : ''; ?>" required>
            </div>
            
            <?php if ($edit_student): ?>
                <button type="submit" name="update" class="btn btn-primary">Update Student</button>
                <a href="index.php" class="btn btn-danger">Cancel</a>
            <?php else: ?>
                <button type="submit" name="add" class="btn btn-primary">Add Student</button>
            <?php endif; ?>
        </form>

        <h2>Student List</h2>
        <table>
            <thead>
                <tr>
                    <th>STD ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $students->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo $row['age']; ?></td>
                        <td>
                            <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                            <form method="POST" action="" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>