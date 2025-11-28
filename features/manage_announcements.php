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
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {         
        $announcement_id = $_POST['announcement_id'];         
        $sql = "DELETE FROM announcements WHERE id = $announcement_id";         
        $conn->query($sql);     
    } else {         
        $announcement = $_POST['announcement'];         
        $created_by = $_SESSION['user']['name'];          
        $sql = "INSERT INTO announcements (announcement, created_by) VALUES ('$announcement', '$created_by')";          
        if ($conn->query($sql) === TRUE) {             
            echo "<div class='alert success'>Announcement created successfully.</div>";         
        } else {             
            echo "<div class='alert error'>Error: " . $sql . "<br>" . $conn->error . "</div>";         
        }     
    } 
}  

$conn->close(); 
?>  

<style>
    .announcement-form {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .announcement-form textarea {
        width: 100%;
        padding: 12px;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-family: 'Roboto', sans-serif;
        margin: 10px 0 20px;
        resize: vertical;
        transition: border 0.3s ease;
    }
    
    .announcement-form textarea:focus {
        border-color: var(--accent-color);
        outline: none;
    }
    
    .announcement-form button {
        background-color: var(--accent-color);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .announcement-form button:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
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
    
    .announcement-meta {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #eee;
        font-size: 0.9rem;
        color: #777;
    }
    
    .announcement-content {
        margin-bottom: 15px;
        line-height: 1.6;
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
    
    .empty-state {
        text-align: center;
        padding: 30px;
        color: #777;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }
</style>

<div class="announcement-form">
    <h2 class="section-title">Create New Announcement</h2>
    <form method="POST">     
        <label for="announcement-text"><strong>Announcement:</strong></label><br>     
        <textarea id="announcement-text" name="announcement" rows="4" required placeholder="Enter your announcement here..."></textarea><br>     
        <button type="submit">Create Announcement</button> 
    </form>
</div>

<h2 class="section-title">Existing Announcements</h2> 
<?php 
$conn = new mysqli($servername, $username, $password, $dbname); 
$sql = "SELECT id, announcement, created_by, created_at FROM announcements ORDER BY created_at DESC"; 
$result = $conn->query($sql);  

if ($result->num_rows > 0):     
    echo "<ul class='announcements-list'>";     
    while ($row = $result->fetch_assoc()):         
        echo "<li>";         
        echo "<div class='announcement-content'>" . nl2br(htmlspecialchars($row['announcement'])) . "</div>";         
        echo "<div class='announcement-meta'>";
        echo "<div>";
        echo "<strong>Created By:</strong> " . htmlspecialchars($row['created_by']) . "<br>";         
        echo "<strong>Created At:</strong> " . htmlspecialchars($row['created_at']);
        echo "</div>";
        echo "<form method='POST'>";         
        echo "<input type='hidden' name='action' value='delete'>";         
        echo "<input type='hidden' name='announcement_id' value='" . $row['id'] . "'>";         
        echo "<button type='submit' class='delete-btn'>Delete</button>";         
        echo "</form>";
        echo "</div>";         
        echo "</li>";     
    endwhile;     
    echo "</ul>"; 
else:     
    echo "<div class='empty-state'><p>No announcements available. Create one to get started!</p></div>"; 
endif;  

$conn->close(); 
?>