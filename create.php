<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Ready to share your knowledge? Learn how to easily create and register your online course.">
    <title>Create Lesson</title>
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
        }

        .button.create-button {
            margin-top: 20px;
            margin-bottom: 20px;
            background-color: rgb(17, 101, 17);
        }

        .button.create-button:hover {
            background-color: #04781b;
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
        <section id="create" class="crud-section">
            <h2>Create Lesson</h2>
            <form id="createLessonForm" action="create_process.php" method="POST" enctype="multipart/form-data" class="form-grid">
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

                $sql_instructors = "SELECT id, name FROM instructors";
                $instructors = $mysqli->query($sql_instructors);

                $sql_subjects = "SELECT id, name FROM subjects";
                $subjects = $mysqli->query($sql_subjects);
                ?>

                <div class="input-group">
                    <label for="instructor">Instructor: <span class="required-asterisk">*</span></label>
                    <div class="error-message" id="error-instructor"></div>
                    <select id="instructor" name="instructor" class="input-field">
                        <option value="">Select Instructor</option>
                        <?php if ($instructors): ?>
                            <?php while ($row = $instructors->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['name']) ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="input-group">
                    <label for="email">Email: <span class="required-asterisk">*</span></label>
                    <div class="error-message" id="error-email"></div>
                    <input type="email" id="email" name="email" placeholder="Email" class="input-field">
                </div>

                <div class="input-group">
                    <label for="subject">Subject: <span class="required-asterisk">*</span></label>
                    <div class="error-message" id="error-subject"></div>
                    <select id="subject" name="subject" class="input-field">
                        <option value="">Select Subject</option>
                        <?php if ($subjects): ?>
                            <?php while ($row = $subjects->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['name']) ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="input-group">
                    <label for="course-title">Course Title: <span class="required-asterisk">*</span></label>
                    <div class="error-message" id="error-course-title"></div>
                    <input type="text" id="course-title" name="course-title" placeholder="Course Title"
                        class="input-field">
                </div>

                <div class="input-group">
                    <label for="course-picture">Picture:</label>
                    <input type="file" id="course-picture" name="course-picture" class="input-field">
                </div>

                <div class="input-group">
                    <label for="course-description">Course Description:</label>
                    <textarea id="course-description" name="course-description" placeholder="Course Description"
                        class="input-field"></textarea>
                </div>

                <button type="submit" class="button create-button">Create</button>
            </form>
        </section>
    </main>

    <script>
        document.getElementById('createLessonForm').addEventListener('submit', function (event) {
            event.preventDefault();
            var isValid = true;
            var requiredFields = [
                { id: 'instructor', errorMessage: 'Instructor is required.' },
                { id: 'email', errorMessage: 'Email is required.' },
                { id: 'subject', errorMessage: 'Subject is required.' },
                { id: 'course-title', errorMessage: 'Course Title is required.' }
            ];

            requiredFields.forEach(function (field) {
                var input = document.getElementById(field.id);
                var error = document.getElementById('error-' + field.id);
                if (!input.value.trim()) {
                    error.textContent = field.errorMessage;
                    error.style.display = 'block';
                    isValid = false;
                } else {
                    error.style.display = 'none';
                }
            });

            if (isValid) {
                this.submit();
            }
        });
    </script>
</body>

</html>