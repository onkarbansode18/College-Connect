<?php 
$servername = "localhost:3308"; 
$username = "root"; 
$password = ""; 
$dbname = "college_web_app";  

$conn = new mysqli($servername, $username, $password, $dbname);  

if ($conn->connect_error) {     
    die("Connection failed: " . $conn->connect_error); 
}  

// Fetch announcements from the announcements table 
$sql = "SELECT announcement, created_by, created_at FROM announcements ORDER BY created_at DESC"; 
$result = $conn->query($sql);  

$conn->close(); 
?>  

<style>
    .announcements-container {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .announcements-list {
        list-style-type: none;
        padding: 0;
    }
    
    .announcements-list li {
        background-color: white;
        border-left: 4px solid var(--accent-color);
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        position: relative;
    }
    
    .announcement-content {
        margin-bottom: 15px;
        line-height: 1.6;
    }
    
    .announcement-meta {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #eee;
        font-size: 0.9rem;
        color: #777;
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

<div class="announcements-container">
    <h2 class="section-title">View Announcements</h2> 
    <?php if ($result->num_rows > 0): ?>     
        <ul class="announcements-list">         
            <?php while ($row = $result->fetch_assoc()): ?>             
                <li>
                    <div class="announcement-content">
                        <?php echo nl2br(htmlspecialchars($row['announcement'])); ?>
                    </div>
                    <div class="announcement-meta">
                        <div>
                            <strong>Created By:</strong> <?php echo htmlspecialchars($row['created_by']); ?><br>                 
                            <strong>Created At:</strong> <?php echo htmlspecialchars($row['created_at']); ?>
                        </div>
                    </div>                 
                </li>         
            <?php endwhile; ?>     
        </ul> 
    <?php else: ?>     
        <div class="empty-state">
            <p>No announcements available.</p>
        </div> 
    <?php endif; ?>
</div>