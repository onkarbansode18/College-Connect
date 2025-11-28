<?php
$servername = "localhost:3308";
$username = "root";
$password = "";
$dbname = "college_web_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user']['id'];
$role = $_SESSION['user']['role'];

if ($role !== 'crs') {
    // For students and faculty, display a message or redirect
    echo "<div class='alert error'>You do not have permission to view this page.</div>";
    $conn->close();
    exit();
}

$showInitialForm = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'mark_attendance') {
        $date = $_POST['date'];
        $lecture_type = $_POST['lecture_type'];
        $subject = $_POST['subject'];

        foreach ($_POST['students'] as $student_id => $status) {
            $status = ($status == 'present') ? 1 : 0;
            $sql = "INSERT INTO attendance (student_id, date, lecture_type, subject, status)
                    VALUES ($student_id, '$date', '$lecture_type', '$subject', $status)
                    ON DUPLICATE KEY UPDATE status = $status";

            if (!$conn->query($sql)) {
                echo "<div class='alert error'>Error marking attendance for student ID $student_id: " . $conn->error . "</div>";
            }
        }
        echo "<div class='alert success'>Attendance marked successfully for all students.</div>";
        $showInitialForm = true;
    } elseif (isset($_POST['date']) && isset($_POST['lecture_type']) && isset($_POST['subject'])) {
        $date = $_POST['date'];
        $lecture_type = $_POST['lecture_type'];
        $subject = $_POST['subject'];
        $showInitialForm = false;

        // Fetch all students
        $sql = "SELECT id, name FROM students";
        $students_result = $conn->query($sql);

        if ($students_result->num_rows > 0):
            echo "<div class='attendance-container'>";
            echo "<h2 class='section-title'>Mark Attendance for " . htmlspecialchars($subject) . " (" . htmlspecialchars($lecture_type) . ")</h2>";
            echo "<p>Date: " . htmlspecialchars($date) . "</p>";
            
            echo "<div class='student-attendance-section'>";
            echo "<form method='POST'>";
            echo "<input type='hidden' name='action' value='mark_attendance'>";
            echo "<input type='hidden' name='date' value='$date'>";
            echo "<input type='hidden' name='lecture_type' value='$lecture_type'>";
            echo "<input type='hidden' name='subject' value='$subject'>";

            while ($student_row = $students_result->fetch_assoc()):
                ?>
                <div class="student-card">
                    <h3><?php echo htmlspecialchars($student_row['name']); ?></h3>
                    <div class="radio-group">
                        <label class="radio-label present-option">
                            <input type="radio" name="students[<?php echo $student_row['id']; ?>]" value="present" required> Present
                        </label>
                        <label class="radio-label absent-option">
                            <input type="radio" name="students[<?php echo $student_row['id']; ?>]" value="absent" required> Absent
                        </label>
                    </div>
                </div>
                <?php
            endwhile;

            echo "<div class='actions-container'>";
            echo "<button type='submit' class='action-btn'>Mark Attendance for All</button>";
            echo "<a href='" . $_SERVER['PHP_SELF'] . "' class='cancel-btn'>Cancel</a>";
            echo "</div>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
        else:
            echo "<div class='empty-state'><p>No students available.</p></div>";
            echo "<a href='" . $_SERVER['PHP_SELF'] . "' class='cancel-btn'>Go Back</a>";
        endif;
    }
}
?>

<style>
    .attendance-form, .attendance-container {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--text-color);
    }

    .form-group select,
    .form-group input {
        width: 100%;
        padding: 12px;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-family: 'Roboto', sans-serif;
        transition: border 0.3s ease;
    }

    .form-group select:focus,
    .form-group input:focus {
        border-color: var(--accent-color);
        outline: none;
    }

    .action-btn {
        background-color: var(--accent-color);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .action-btn:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
    
    .cancel-btn {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-top: 10px;
        text-decoration: none;
        display: inline-block;
        margin-left: 10px;
    }
    
    .cancel-btn:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        color: var(--primary-color);
        margin: 30px 0 20px;
        font-weight: 600;
        position: relative;
        padding-bottom: 10px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: var(--accent-color);
    }

    .alert {
        padding: 12px 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .student-card {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .radio-group {
        display: flex;
        gap: 20px;
        margin: 15px 0;
    }

    .radio-label {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .radio-label input {
        margin-right: 8px;
    }

    .present-option {
        color: #28a745;
        font-weight: 500;
    }

    .absent-option {
        color: #dc3545;
        font-weight: 500;
    }

    .empty-state {
        text-align: center;
        padding: 30px;
        color: #777;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
    }
    
    .actions-container {
        margin-top: 20px;
        text-align: center;
    }

    /* Responsive fixes */
    @media (min-width: 768px) {
        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }
    }
</style>

<?php if ($showInitialForm): ?>
<div class="attendance-form">
    <h2 class="section-title">Mark Attendance</h2>
    <form method="POST" id="date_form">
        <div class="form-row">
            <div class="form-group">
                <label for="date-input">Date:</label>
                <input type="date" id="date-input" name="date" required>
            </div>

            <div class="form-group">
                <label for="lecture-type">Lecture Type:</label>
                <select id="lecture-type" name="lecture_type" required>
                    <option value="" disabled selected>Select type</option>
                    <option value="lecture">Lecture</option>
                    <option value="practical">Practical</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="subject-input">Subject:</label>
            <input type="text" id="subject-input" name="subject" required placeholder="Enter subject name">
        </div>

        <button type="submit" class="action-btn">Load Students</button>
    </form>
</div>
<?php endif; ?>

<?php
$conn->close();
?>