<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Permanently remove a lesson from your course. Caution: This action is irreversible">
    <title>Delete Record</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .form-grid {
            display: grid;
            gap: 20px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
        }

        .input-group label {
            margin-bottom: 2px;
        }

        .required-asterisk {
            color: red;
        }

        .input-field {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .error-message {
            color: red;
            display: none;
            font-size: 0.85em;
            margin-top: 5px;
        }

        .button.delete-button {
            background-color: #dc3545;
            color: white;
        }

        .button.delete-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <header>
        <h1>SuperLearner</h1>
    </header>

    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="create.php">Create</a></li>
            <li><a href="update.php">Update</a></li>
            <li><a href="delete.php">Delete</a></li>
            <li><a href="about.php">About</a></li>
        </ul>
    </nav>

    <main>
        <section id="delete" class="crud-section">
            <h2>Delete Lesson</h2>
            <form id="deleteLessonForm" action="delete_process.php" method="POST" class="form-grid">
                <div class="input-group">
                    <label for="course">Select Course:<span class="required-asterisk">*</span></label>
                    <select id="course" name="course_id" class="input-field">
                        <option value="">Select Course</option>
                        <?php
                        $mysqli = new mysqli("303.itpwebdev.com", "guoe_db_user", "uscitp303", "guoe_assignment_m3");
                        if ($mysqli->connect_error) {
                            echo "Connection error: " . $mysqli->connect_error;
                            exit();
                        }
                        $result = $mysqli->query("SELECT id, title FROM courses");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['title']) . "</option>";
                        }
                        $mysqli->close();
                        ?>
                    </select>
                    <div class="error-message" id="error-course">Please select a course.</div>
                </div>
                <button type="submit" class="button delete-button">Delete</button>
            </form>
        </section>
    </main>

    <script>
        document.getElementById('deleteLessonForm').addEventListener('submit', function (event) {
            var courseId = document.getElementById('course').value;
            var errorDiv = document.getElementById('error-course');
            errorDiv.style.display = 'none'; 

            if (!courseId) {
                event.preventDefault(); 
                errorDiv.style.display = 'block';
            } else if (!confirm('Are you sure you want to delete this course? This action cannot be undone.')) {
                event.preventDefault(); 
            }
        });
    </script>
</body>
</html>
