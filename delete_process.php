<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Successfully deleted a lesson! Check the home page to see changes.">
    <title>Delete Process</title>
    <link rel="stylesheet" href="styles.css"> 
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
        <section id="delete-process" class="crud-section">
            <h2>Delete Confirmation</h2>
            <?php
            if (isset($_POST['course_id']) && !empty($_POST['course_id'])) {
                $course_id = $_POST['course_id'];

                $mysqli = new mysqli("303.itpwebdev.com", "guoe_db_user", "uscitp303", "guoe_assignment_m3");
                if ($mysqli->connect_error) {
                    die("Connection failed: " . $mysqli->connect_error);
                }

                $stmt = $mysqli->prepare("DELETE FROM courses WHERE id = ?");
                $stmt->bind_param("i", $course_id);
                
                if ($stmt->execute()) {
                    echo "<p>Lesson deleted successfully!</p>";
                } else {
                    echo "<p>Error deleting record: " . $mysqli->error . "</p>";
                }

                $stmt->close();
                $mysqli->close();
            } else {
                echo "<p>Error: No course selected for deletion.</p>";
            }
            ?>
        </section>
    </main>
</body>
</html>
