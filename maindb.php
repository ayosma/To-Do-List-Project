<?php
// Initialize session
session_start();

// Database connection parameters
$servername = "localhost";
$username = "zsirajo1";
$password = "zsirajo1";
$database = "zsirajo1";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create tasks table if not exists
$sql_create_table = "CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_name VARCHAR(255) NOT NULL
    priority VARCHAR(255) NOT NULL
    progress VARCHAR(255) NOT NULL
)";

if ($conn->query($sql_create_table) === TRUE) {
    echo "";
} else {
    echo "Error creating table: " . $conn->error;
}

// Add task
if (isset($_POST['add_task']) && !empty($_POST['task_name'])) {
    $taskName = $_POST['task_name'];
    
    // Insert task into database
    $sql_add_task = "INSERT INTO tasks (task_name) VALUES ('$taskName')";
    if ($conn->query($sql_add_task) === TRUE) {
        // Redirect to avoid form resubmission
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error adding task: " . $conn->error;
    }
}

// Delete task
if (isset($_GET['delete'])) {
    $taskId = $_GET['delete'];
    
    // Delete task from database
    $sql_delete_task = "DELETE FROM tasks WHERE id=$taskId";
    if ($conn->query($sql_delete_task) === TRUE) {
        // Redirect to avoid form resubmission
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error deleting task: " . $conn->error;
    }
}

// Edit task
if (isset($_POST['edit_task']) && isset($_POST['task_id']) && isset($_POST['task_name'])) {
    $taskId = $_POST['task_id'];
    $taskName = $_POST['task_name'];
    
    // Update task in database
    $sql_edit_task = "UPDATE tasks SET task_name='$taskName' WHERE id=$taskId";
    if ($conn->query($sql_edit_task) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Task updated successfully.']);
        exit();
    } else {
        echo "Error updating task: " . $conn->error;
    }
}

// Fetch tasks from database
$sql_fetch_tasks = "SELECT * FROM tasks";
$result = $conn->query($sql_fetch_tasks);
$tasks = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function editTask(taskId) {
            var newTaskName = prompt("Enter the new task name:", "");
            if (newTaskName !== null && newTaskName.trim() !== "") {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert(response.message);
                            window.location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                };
                xhr.open("POST", window.location.href, true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("edit_task=true&task_id=" + taskId + "&task_name=" + encodeURIComponent(newTaskName));
            }
        }
    </script>
</head>
<body>

<div class="header">
    <h1>To do list</h1>
</div>

<div id="todo-list">
    <h2>Welcome, user!</h2>
    <form method="post">
        <input type="text" name="task_name" placeholder="Enter task">
        <button id="task-button" type="submit" name="add_task">Add Task</button>
    </form>

    <ul id="task-list">
        <?php foreach ($tasks as $task): ?>
            <li class="task-item">
                <span><?php echo $task['task_name']; ?></span>
                <button class="edit-btn" onclick="editTask(<?php echo $task['id']; ?>)"></button>
                <a class="delete-btn" href="?delete=<?php echo $task['id']; ?>"></a>
                <select id="prioritySelect">
                    <option value="low">Priority...</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>

                <select id="progressionSelect">
                    <option value="low">Progress...</option>
                    <option value="notBegun">Not Started</option>
                    <option value="inProgress">In Progress</option>
                    <option value="Done">Complete</option>
                </select>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
