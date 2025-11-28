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

// Combined attendance viewing code for students and faculty
if ($role === 'students') {
    // Fetch attendance records for the student
    $sql = "SELECT a.date, a.lecture_type, a.subject, a.status, 
            CASE WHEN a.status = 1 THEN 100 ELSE 0 END as attendance_percentage,
            a.subject as course_name
            FROM attendance a
            WHERE a.student_id = $user_id
            ORDER BY a.date DESC";
    $result = $conn->query($sql);
    ?>
    <div class="attendance-container">
        <h2 class="section-title">View Attendance</h2> 
        <?php if ($result->num_rows > 0): ?>     
            <ul class="attendance-list">         
                <?php while ($row = $result->fetch_assoc()): 
                    $status = $row['status'] == 1 ? 'Present' : 'Absent';
                    $percentageClass = $row['status'] == 1 ? 'percentage-high' : 'percentage-low';
                ?>             
                    <li>
                        <div class="attendance-details">
                            <strong>Date:</strong> <?php echo htmlspecialchars($row['date']); ?><br>
                            <strong>Lecture Type:</strong> <?php echo htmlspecialchars($row['lecture_type']); ?><br>
                            <strong>Subject:</strong> <?php echo htmlspecialchars($row['subject']); ?>
                        </div>
                        <div class="attendance-percentage">
                            <strong>Status:</strong> 
                            <span class="value <?php echo $percentageClass; ?>"><?php echo $status; ?></span>
                        </div>                 
                    </li>         
                <?php endwhile; ?>     
            </ul> 
        <?php else: ?>     
            <div class="empty-state">
                <p>No attendance records available.</p>
            </div> 
        <?php endif; ?>
    </div>
<?php 
} elseif ($role === 'faculty' || $role === 'crs') {
    // Faculty can see all student attendance records
    if (!isset($_POST['date']) || !isset($_POST['lecture_type']) || !isset($_POST['subject'])) {
?>
    <div class="attendance-container">
        <h2 class="section-title">View Class Attendance</h2>
        
        <form method="POST" class="filter-form">
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
            <button type="submit" class="action-btn">View Attendance</button>
        </form>
    </div>
<?php
    } else {
        // Display attendance records for the selected criteria
        $date = $_POST['date'];
        $lecture_type = $_POST['lecture_type'];
        $subject = $_POST['subject'];
        
        // Get all students and their attendance for this date/lecture/subject
        $sql = "SELECT s.id, s.name, 
                IFNULL(a.status, -1) as status
                FROM students s
                LEFT JOIN attendance a ON s.id = a.student_id
                AND a.date = '$date' 
                AND a.lecture_type = '$lecture_type'
                AND a.subject = '$subject'
                ORDER BY s.name";
        
        $result = $conn->query($sql);
        
        $present_count = 0;
        $absent_count = 0;
        $no_record_count = 0;
?>
        <div class="attendance-container">
            <h2 class="section-title">Class Attendance Report</h2>
            <div class="attendance-details-header">
                <p><strong>Date:</strong> <?php echo htmlspecialchars($date); ?></p>
                <p><strong>Lecture Type:</strong> <?php echo htmlspecialchars($lecture_type); ?></p>
                <p><strong>Subject:</strong> <?php echo htmlspecialchars($subject); ?></p>
            </div>
            
            <?php if ($result->num_rows > 0): ?>
                <table class="attendance-table">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): 
                            if ($row['status'] == 1) {
                                $status = 'Present';
                                $statusClass = 'status-present';
                                $present_count++;
                            } elseif ($row['status'] == 0) {
                                $status = 'Absent';
                                $statusClass = 'status-absent';
                                $absent_count++;
                            } else {
                                $status = 'No Record';
                                $statusClass = 'status-norecord';
                                $no_record_count++;
                            }
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td class="<?php echo $statusClass; ?>"><?php echo $status; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                
                <div class="attendance-summary">
                    <h3 class="summary-title">Attendance Summary</h3>
                    <div class="summary-stats">
                        <div class="stat-box present-stat">
                            <span class="stat-value"><?php echo $present_count; ?></span>
                            <span class="stat-label">Present</span>
                        </div>
                        <div class="stat-box absent-stat">
                            <span class="stat-value"><?php echo $absent_count; ?></span>
                            <span class="stat-label">Absent</span>
                        </div>
                        <?php if ($no_record_count > 0): ?>
                        <div class="stat-box norecord-stat">
                            <span class="stat-value"><?php echo $no_record_count; ?></span>
                            <span class="stat-label">No Record</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($present_count + $absent_count > 0): ?>
                    <div class="attendance-percentage-bar">
                        <div class="percentage-fill" style="width: <?php echo ($present_count / ($present_count + $absent_count) * 100); ?>%"></div>
                    </div>
                    <p class="percentage-text">
                        <strong><?php echo round(($present_count / ($present_count + $absent_count) * 100), 1); ?>%</strong> attendance rate
                    </p>
                    <?php endif; ?>
                </div>
                
                <div class="actions-row">
                    <form method="POST">
                        <button type="submit" class="action-btn">View Another Class</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>No students found.</p>
                </div>
                <div class="actions-row">
                    <form method="POST">
                        <button type="submit" class="action-btn">Go Back</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
<?php
    }
} else {
    // For unauthorized users, display a message or redirect
    echo "<div class='alert error'>You do not have permission to view this page.</div>";
    $conn->close();
    exit();
}
?>

<style>
    .attendance-container {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .attendance-list {
        list-style-type: none;
        padding: 0;
    }
    
    .attendance-list li {
        background-color: white;
        border-left: 4px solid var(--accent-color);
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        position: relative;
    }
    
    .attendance-details {
        margin-bottom: 10px;
        line-height: 1.6;
    }
    
    .attendance-details-header {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        border-left: 4px solid var(--accent-color);
    }
    
    .attendance-details-header p {
        margin: 5px 0;
    }
    
    .attendance-percentage {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
        font-size: 1.1rem;
    }
    
    .attendance-percentage .value {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: bold;
        color: white;
    }
    
    .percentage-high {
        background-color: #28a745;
    }
    
    .percentage-medium {
        background-color: #ffc107;
        color: #212529 !important;
    }
    
    .percentage-low {
        background-color: #dc3545;
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
    
    .summary-title {
        color: var(--primary-color);
        margin: 25px 0 15px;
        font-weight: 600;
        font-size: 1.2rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 30px;
        color: #777;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }
    
    .alert {
        padding: 12px 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-weight: 500;
    }
    
    .error {
        background-color: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }
    
    .success {
        background-color: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }
    
    /* Filter form styles */
    .filter-form {
        margin-top: 20px;
    }
    
    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
    }
    
    .form-group {
        flex: 1;
        margin-bottom: 15px;
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
    
    /* Table styles */
    .attendance-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    
    .attendance-table th, 
    .attendance-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    
    .attendance-table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: var(--primary-color);
    }
    
    .attendance-table tr:hover {
        background-color: #f8f9fa;
    }
    
    .status-present {
        color: #28a745;
        font-weight: 500;
    }
    
    .status-absent {
        color: #dc3545;
        font-weight: 500;
    }
    
    .status-norecord {
        color: #6c757d;
        font-style: italic;
    }
    
    /* Summary styles */
    .attendance-summary {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-top: 30px;
    }
    
    .summary-stats {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .stat-box {
        flex: 1;
        text-align: center;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        background-color: white;
    }
    
    .present-stat {
        border-bottom: 4px solid #28a745;
    }
    
    .absent-stat {
        border-bottom: 4px solid #dc3545;
    }
    
    .norecord-stat {
        border-bottom: 4px solid #6c757d;
    }
    
    .stat-value {
        display: block;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .stat-label {
        color: #6c757d;
        font-weight: 500;
    }
    
    .attendance-percentage-bar {
        height: 8px;
        background-color: #e9ecef;
        border-radius: 4px;
        margin-bottom: 10px;
        overflow: hidden;
    }
    
    .percentage-fill {
        height: 100%;
        background-color: #28a745;
        border-radius: 4px;
    }
    
    .percentage-text {
        text-align: right;
        color: #6c757d;
    }
    
    .actions-row {
        margin-top: 20px;
        text-align: center;
    }
    
    /* Student card styles */
    .student-attendance-section {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 20px;
    }
    
    .student-card {
        background-color: white;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        width: calc(33.33% - 20px);
        min-width: 250px;
    }
    
    .student-card h3 {
        margin-top: 0;
        margin-bottom: 10px;
        color: var(--primary-color);
        font-size: 1.1rem;
    }
    
    /* Responsive fixes */
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }
        
        .summary-stats {
            flex-direction: column;
            gap: 10px;
        }
        
        .student-card {
            width: 100%;
        }
    }
</style>