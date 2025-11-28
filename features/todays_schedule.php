<?php 
$servername = "localhost:3308"; 
$username = "root"; 
$password = ""; 
$dbname = "college_web_app";  

$conn = new mysqli($servername, $username, $password, $dbname);  

if ($conn->connect_error) {     
    die("Connection failed: " . $conn->connect_error); 
}  

// Get the current day 
$currentDay = date('l');  

// Fetch today's schedule from the timetable table 
$user_id = $_SESSION['user']['id']; 
$role = $_SESSION['user']['role'];  

if ($role === 'students') {     
    $sql = "SELECT t.time, c.course_name, f.name AS faculty_name             
            FROM timetable t             
            JOIN courses c ON t.course_id = c.id             
            JOIN faculty f ON t.faculty_id = f.id             
            JOIN students_courses sc ON t.course_id = sc.course_id             
            WHERE sc.student_id = $user_id AND t.day = '$currentDay'             
            ORDER BY t.time"; 
} elseif ($role === 'crs' || $role === 'faculty') {     
    $sql = "SELECT t.time, c.course_name             
            FROM timetable t             
            JOIN courses c ON t.course_id = c.id             
            WHERE t.faculty_id = $user_id AND t.day = '$currentDay'             
            ORDER BY t.time"; 
}  

$result = $conn->query($sql);  
$conn->close(); 
?>  

<style>
    .schedule-container {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .schedule-list {
        list-style-type: none;
        padding: 0;
    }
    
    .schedule-list li {
        background-color: white;
        border-left: 4px solid var(--accent-color);
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        position: relative;
    }
    
    .schedule-meta {
        line-height: 1.6;
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
    
    .empty-state {
        text-align: center;
        padding: 30px;
        color: #777;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }
</style>

<div class="schedule-container">
    <h2 class="section-title">Today's Schedule</h2> 
    <?php if ($result->num_rows > 0): ?>     
        <ul class="schedule-list">         
            <?php while ($row = $result->fetch_assoc()): ?>             
                <li>                 
                    <div class="schedule-meta">
                        <strong>Time:</strong> <?php echo htmlspecialchars($row['time']); ?><br>                 
                        <strong>Course:</strong> <?php echo htmlspecialchars($row['course_name']); ?><br>                 
                        <?php if (isset($row['faculty_name'])): ?>                     
                            <strong>Faculty:</strong> <?php echo htmlspecialchars($row['faculty_name']); ?>                 
                        <?php endif; ?>
                    </div>                 
                </li>         
            <?php endwhile; ?>     
        </ul> 
    <?php else: ?>     
        <div class="empty-state">
            <p>No classes scheduled for today.</p>
        </div> 
    <?php endif; ?>
</div>