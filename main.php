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
                var newPriority = prompt("Enter the priority:", "");
                if (newPriority !== null && newPriority.trim() !== "") {
                    var newProgress = prompt("Enter the progress:", "");
                    if (newProgress !== null && newProgress.trim() !== "") {
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
                        xhr.send("edit_task=true&task_id=" + taskId + "&task_name=" + encodeURIComponent(newTaskName) + "&priority=" + encodeURIComponent(newPriority) + "&progress=" + encodeURIComponent(newProgress));
                    }
                }
            }
        }
    </script>
</head>
<body>

    <div class="header">
        <h1>To do list</h1>
    </div>

    <div id="todo-list">
        <h2>Welcome, User!</h2>
        <form method="post">
            <input type="text" name="task_name" placeholder="Enter task">
            <select name="priority" id="prioritySelect">
                <option value="low">Priority...</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
            <select name="progress" id="progressionSelect">
                <option value="low">Progress...</option>
                <option value="notBegun">Not Started</option>
                <option value="inProgress">In Progress</option>
                <option value="Done">Complete</option>
            </select>
            <button id="task-button" type="submit" name="add_task">Add Task</button>
        </form>

        <ul id="task-list">
            <?php foreach ($tasks as $task): ?>
                <li class="task-item">
                    <span><?php echo $task['task_name']; ?></span>
                    <button class="edit-btn" onclick="editTask(<?php echo $task['id']; ?>)">Edit</button>
                    <a class="delete-btn" href="?delete=<?php echo $task['id']; ?>">Delete</a>
                    <!-- Display priority -->
                    <select name="priority" id="prioritySelect">
                        <option value="low" <?php if ($task['priority'] == 'low') echo 'selected'; ?>>Low</option>
                        <option value="medium" <?php if ($task['priority'] == 'medium') echo 'selected'; ?>>Medium</option>
                        <option value="high" <?php if ($task['priority'] == 'high') echo 'selected'; ?>>High</option>
                    </select>
                    <!-- Display progress -->
                    <select name="progress" id="progressionSelect">
                        <option value="not begun" <?php if ($task['progress'] == 'not begun') echo 'selected'; ?>>Not Started</option>
                        <option value="inProgress" <?php if ($task['progress'] == 'inProgress') echo 'selected'; ?>>In Progress</option>
                        <option value="Done" <?php if ($task['progress'] == 'Done' || $task['progress'] == 'done' || $task['progress'] == 'Complete' || $task['progress'] == 'complete') echo 'selected'; ?>>Complete</option>
                    </select>

                </li>
            <?php endforeach; ?>
     
        </ul>
        <!-- Add logout form -->
        <form action="logout.php" method="POST">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
</body>
</html>
