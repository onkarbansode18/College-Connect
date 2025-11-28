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

if ($role === 'students' || $role === 'crs') {     
    // Fetch test marks for the student or CR     
    $sql = "SELECT subject_name, marks_pdf             
            FROM test_marks             
            ORDER BY uploaded_at DESC"; 
} else {     
    // For faculty, display a message or redirect     
    echo "<div class='alert error'>You do not have permission to view this page.</div>";     
    $conn->close();     
    exit(); 
}  

$result = $conn->query($sql);  
$conn->close(); 
?>  

<style>
    .marks-container {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .marks-list {
        list-style-type: none;
        padding: 0;
    }
    
    .marks-list li {
        background-color: white;
        border-left: 4px solid var(--accent-color);
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        position: relative;
    }
    
    .marks-details {
        margin-bottom: 10px;
        line-height: 1.6;
    }
    
    .download-link {
        display: inline-block;
        background-color: var(--accent-color);
        color: white;
        padding: 8px 15px;
        border-radius: 4px;
        text-decoration: none;
        margin-top: 10px;
        transition: all 0.3s ease;
    }
    
    .download-link:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
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
</style>

<div class="marks-container">
    <h2 class="section-title">View Test Marks</h2> 
    <?php if ($result->num_rows > 0): ?>     
        <ul class="marks-list">         
            <?php while ($row = $result->fetch_assoc()): ?>             
                <li>
                    <div class="marks-details">
                        <strong>Subject:</strong> <?php echo htmlspecialchars($row['subject_name']); ?>
                    </div>
                    <a href="<?php echo htmlspecialchars($row['marks_pdf']); ?>" target="_blank" class="download-link">
                        <i class="fa fa-download"></i> Download PDF
                    </a>               
                </li>         
            <?php endwhile; ?>     
        </ul> 
    <?php else: ?>     
        <div class="empty-state">
            <p>No test marks available.</p>
        </div> 
    <?php endif; ?>
</div>