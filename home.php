<?php
$host = "303.itpwebdev.com";
$user = "guoe_db_user";
$pass = "uscitp303";
$db = "guoe_assignment_m3";

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    echo $mysqli->connect_error;
    exit();
}

// Include the 'img' column in your SQL query
$sql = "SELECT c.id AS course_id, c.title, c.description, c.img, i.name AS instructor_name, s.name AS subject_name
        FROM courses c
        INNER JOIN instructors i ON c.instructor_id = i.id
        INNER JOIN subjects s ON c.subject_id = s.id";

$result = $mysqli->query($sql);

if (!$result) {
    echo "An error occurred: " . $mysqli->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Empower your learning journey. Explore courses, find resources, and connect with instructors.">
    <title>SuperLearner</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .lesson {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .lesson .lesson-box {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            flex: 1;
        }

        .lesson .lesson-box:hover {
            transform: translateY(-5px);
        }

        .lesson img {
            width: 100%;
            /* Control the image size here */
            height: auto;
            max-height: 200px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .lesson .button {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .lesson .button:hover {
            background-color: #0056b3;
        }

        .lesson img {
            width: 90%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <header>
        <h1>SuperLearner</h1>
    </header>

    <div class="container">
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="create.php">Create</a></li>
                <li><a href="update.php">Update</a></li>
                <li><a href="delete.php">Delete</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </nav>
    </div>

    <main>
        <p class="desc">
            Choose from a lesson below to get started.
        </p>

        <?php while ($row = $result->fetch_assoc()): ?>
            <section class="lesson">
                <div class="lesson-box">
                    <h2><?= htmlspecialchars($row['title']); ?></h2>
                    <?php if ($row['img']): // Display the image if it exists ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($row['img']); ?>" alt="Course Image">
                    <?php endif; ?>
                    <p><?= htmlspecialchars($row['description']); ?></p>
                    <p>Instructor: <?= htmlspecialchars($row['instructor_name']); ?></p>
                    <p>Subject: <?= htmlspecialchars($row['subject_name']); ?></p>
                    <a href="lesson1.php" class="button">Start Lesson</a>
                </div>
            </section>
        <?php endwhile; ?>
    </main>
</body>

</html>