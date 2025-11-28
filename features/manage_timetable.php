<?php 
$servername = "localhost:3308"; 
$username = "root"; 
$password = ""; 
$dbname = "college_web_app";  

$conn = new mysqli($servername, $username, $password, $dbname);  

if ($conn->connect_error) {     
    die("Connection failed: " . $conn->connect_error); 
}  

if ($_SERVER["REQUEST_METHOD"] == "POST") {     
    $day = $_POST['day'];     
    $time = $_POST['time'];     
    $course_id = $_POST['course_id'];     
    $faculty_id = $_SESSION['user']['id'];      
    
    $sql = "INSERT INTO timetable (day, time, course_id, faculty_id)             
            VALUES ('$day', '$time', $course_id, $faculty_id)";      
    
    if ($conn->query($sql) === TRUE) {         
        echo "<div class='alert success'>Timetable entry added successfully.</div>";     
    } else {         
        echo "<div class='alert error'>Error: " . $sql . "<br>" . $conn->error . "</div>";     
    } 
}  

$conn->close(); 
?>  

<style>
    .timetable-form {
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
    
    .submit-btn {
        background-color: var(--accent-color);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .submit-btn:hover {
        background-color: #2980b9;
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

<div class="timetable-form">
    <h2 class="section-title">Manage Timetable</h2>
    <form method="POST">
        <div class="form-row">
            <div class="form-group">
                <label for="day-select">Day:</label>
                <select id="day-select" name="day" required>
                    <option value="" disabled selected>Select day</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="time-input">Time:</label>
                <input type="time" id="time-input" name="time" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="course-select">Course:</label>
            <select id="course-select" name="course_id" required>
                <option value="" disabled selected>Select course</option>
                <?php
                $conn = new mysqli($servername, $username, $password, $dbname);
                $course_sql = "SELECT id, course_name FROM courses";
                $course_result = $conn->query($course_sql);
                
                while ($course_row = $course_result->fetch_assoc()) {
                    echo "<option value='" . $course_row['id'] . "'>" . htmlspecialchars($course_row['course_name']) . "</option>";
                }
                
                $conn->close();
                ?>
            </select>
        </div>
        
        <button type="submit" class="submit-btn">Add to Timetable</button>
    </form>
</div>

<!-- Display Current Timetable Section -->
<h2 class="section-title">Current Timetable</h2>
<?php
$conn = new mysqli($servername, $username, $password, $dbname);
$faculty_id = $_SESSION['user']['id'];

$timetable_sql = "SELECT t.id, t.day, t.time, c.course_name 
                 FROM timetable t
                 JOIN courses c ON t.course_id = c.id
                 WHERE t.faculty_id = $faculty_id
                 ORDER BY FIELD(t.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'), t.time";
                 
$timetable_result = $conn->query($timetable_sql);

if ($timetable_result && $timetable_result->num_rows > 0) {
    echo '<div class="timetable-display">';
    echo '<table class="timetable-table">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Course</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>';
    
    while ($row = $timetable_result->fetch_assoc()) {
        echo '<tr>
                <td>' . htmlspecialchars($row['day']) . '</td>
                <td>' . htmlspecialchars(date('h:i A', strtotime($row['time']))) . '</td>
                <td>' . htmlspecialchars($row['course_name']) . '</td>
                <td>
                    <form method="POST" class="delete-form">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="entry_id" value="' . $row['id'] . '">
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </td>
              </tr>';
    }
    
    echo '</tbody></table></div>';
} else {
    echo '<div class="empty-state"><p>No timetable entries added yet.</p></div>';
}

$conn->close();
?>

<style>
    .timetable-display {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        overflow-x: auto;
    }
    
    .timetable-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .timetable-table th {
        background-color: var(--primary-color);
        color: white;
        text-align: left;
        padding: 12px 15px;
    }
    
    .timetable-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
    }
    
    .timetable-table tr:last-child td {
        border-bottom: none;
    }
    
    .timetable-table tr:hover {
        background-color: #f9f9f9;
    }
    
    .delete-btn {
        background-color: var(--secondary-color);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    
    .delete-btn:hover {
        background-color: #c0392b;
    }
    
    .empty-state {
        text-align: center;
        padding: 30px;
        color: #777;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }
</style>