<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Refine your online course! Edit content and details on SuperLearner.">
    <title>Update Record</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

        .button.update-button {
            margin-top: 20px;
            margin-bottom: 20px;
            background-color: rgb(26, 111, 139);
        }

        .button.update-button:hover {
            background-color: #0e56a3;
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
        <section id="update" class="crud-section">
            <h2>Update Lesson</h2>
            <form id="updateLessonForm" action="update_process.php" method="POST" enctype="multipart/form-data"
                class="form-grid">
                <?php
                $host = "303.itpwebdev.com";
                $user = "guoe_db_user";
                $pass = "uscitp303";
                $db = "guoe_assignment_m3";

                $mysqli = new mysqli($host, $user, $pass, $db);
                if ($mysqli->connect_errno) {
                    echo "Connection error: " . htmlspecialchars($mysqli->connect_error);
                    exit();
                }

                $sql_courses = "SELECT id, title FROM courses";
                $courses = $mysqli->query($sql_courses);

                $sql_instructors = "SELECT id, name FROM instructors";
                $instructors = $mysqli->query($sql_instructors);

                $sql_subjects = "SELECT id, name FROM subjects";
                $subjects = $mysqli->query($sql_subjects);
                ?>

                <div class="input-group">
                    <label for="course">Select Course:<span class="required-asterisk">*</span></label>
                    <select id="course" name="id" class="input-field" onchange="loadCourseDetails(this.value);">
                        <option value="">Select Course</option>
                        <?php while ($courses && $row = $courses->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['title']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <div class="error-message" id="error-course"></div>
                </div>

                <div class="input-group">
                    <label for="instructor">Instructor:<span class="required-asterisk">*</span></label>
                    <select id="instructor" name="instructor" class="input-field">
                        <option value="">Select Instructor</option>
                        <?php while ($instructors && $row = $instructors->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <div class="error-message" id="error-instructor"></div>
                </div>

                <div class="input-group">
                    <label for="email">Email:<span class="required-asterisk">*</span></label>
                    <input type="email" id="email" name="email" placeholder="Email" class="input-field">
                    <div class="error-message" id="error-email"></div>
                </div>

                <div class="input-group">
                    <label for="subject">Subject:<span class="required-asterisk">*</span></label>
                    <select id="subject" name="subject" class="input-field">
                        <option value="">Select Subject</option>
                        <?php while ($subjects && $row = $subjects->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <div class="error-message" id="error-subject"></div>
                </div>

                <div class="input-group">
                    <label for="course-title">Course Title:<span class="required-asterisk">*</span></label>
                    <input type="text" id="course-title" name="course-title" placeholder="Course Title"
                        class="input-field">
                    <div class="error-message" id="error-course-title"></div>
                </div>

                <div class="input-group">
                    <label for="course-picture">Picture:</label>
                    <input type="file" id="course-picture" name="course-picture" class="input-field">
                </div>

                <div class="input-group">
                    <label>Current Picture:</label>
                    <img id="image-preview" src="" alt="Course Image" style="max-width: 100%; max-height: 200px;">
                </div>

                <div class="input-group">
                    <label for="course-description">Course Description:</label>
                    <textarea id="course-description" name="course-description" placeholder="Course Description"
                        class="input-field"></textarea>
                    <div class="error-message" id="error-course-description"></div>
                </div>

                <button type="submit" class="button update-button">Update</button>
            </form>
        </section>
    </main>

    <script>
        function loadCourseDetails(courseId) {
            if (!courseId) {
                $('#instructor').val('');
                $('#email').val('');
                $('#subject').val('');
                $('#course-title').val('');
                $('#course-description').val('');
                return;
            }

            $.ajax({
                url: 'getCourseDetails.php',
                type: 'GET',
                data: { courseId: courseId },
                success: function (response) {
                    var details = JSON.parse(response);
                    $('#instructor').val(details.instructor_id);
                    $('#email').val(details.email);
                    $('#subject').val(details.subject_id);
                    $('#course-title').val(details.title);
                    $('#course-description').val(details.description);
                    if (details.img) {
                        $('#image-preview').attr('src', 'data:image/jpeg;base64,' + details.img);
                    } else {
                        $('#image-preview').attr('src', 'placeholder.jpg'); 
                    }
                },
                error: function () {
                    alert('Error loading course details.');
                }
            });
        }

        document.getElementById('updateLessonForm').addEventListener('submit', function (event) {
            event.preventDefault(); 
            var isValid = true;
            var requiredFields = [
                { id: 'course', errorMessage: 'Selecting a course is required.' },
                { id: 'instructor', errorMessage: 'Selecting an instructor is required.' },
                { id: 'email', errorMessage: 'Email is required.' },
                { id: 'subject', errorMessage: 'Selecting a subject is required.' },
                { id: 'course-title', errorMessage: 'Course title is required.' }
            ];

            requiredFields.forEach(function (field) {
                var input = document.getElementById(field.id);
                var error = document.getElementById('error-' + field.id);
                if (!input || !error) {
                    console.error('Error: Missing element for validation', field.id);
                    return; 
                }
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