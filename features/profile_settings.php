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

if ($_SERVER["REQUEST_METHOD"] == "POST") {     
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {         
        // Handle profile picture upload         
        $target_dir = "uploads/profile_pictures/";         
        if (!is_dir($target_dir)) {             
            mkdir($target_dir, 0777, true);         
        }         
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);          
        
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {             
            // Update profile picture path in the database             
            $table = ($role === 'students') ? 'students' : (($role === 'crs') ? 'crs' : 'faculty');             
            $sql = "UPDATE $table SET profile_picture = '$target_file' WHERE id = $user_id";             
            if ($conn->query($sql) === TRUE) {                 
                $_SESSION['user']['profile_picture'] = $target_file; // Update session data                 
                echo "<div class='alert success'>Profile picture updated successfully.</div>";             
            } else {                 
                echo "<div class='alert error'>Error updating profile picture in the database: " . $conn->error . "</div>";             
            }         
        } else {             
            echo "<div class='alert error'>Error moving uploaded file.</div>";         
        }     
    }      
    
    if (isset($_POST['name'])) {         
        // Update name in the database         
        $name = $_POST['name'];         
        $table = ($role === 'students') ? 'students' : (($role === 'crs') ? 'crs' : 'faculty');         
        $sql = "UPDATE $table SET name = '$name' WHERE id = $user_id";         
        if ($conn->query($sql) === TRUE) {             
            $_SESSION['user']['name'] = $name; // Update session data
            echo "<div class='alert success'>Name updated successfully.</div>";
        } else {             
            echo "<div class='alert error'>Error updating name in the database: " . $conn->error . "</div>";         
        }     
    } 
}  

$conn->close(); 
?>  

<style>
    .profile-form {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .profile-form input[type="text"], 
    .profile-form input[type="file"] {
        width: 100%;
        padding: 12px;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-family: 'Roboto', sans-serif;
        margin: 10px 0 20px;
        transition: border 0.3s ease;
    }
    
    .profile-form input[type="text"]:focus {
        border-color: var(--accent-color);
        outline: none;
    }
    
    .profile-form button {
        background-color: var(--accent-color);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-right: 10px;
        margin-bottom: 10px;
    }
    
    .profile-form button:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
    
    .logout-btn {
        background-color: var(--secondary-color) !important;
    }
    
    .logout-btn:hover {
        background-color: #c0392b !important;
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
    
    .profile-preview {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        text-align: center;
    }
    
    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--accent-color);
        margin-bottom: 15px;
    }
    
    .profile-details {
        margin-top: 20px;
        text-align: left;
    }
    
    .profile-details p {
        margin: 8px 0;
        padding: 8px;
        background-color: #f9f9f9;
        border-radius: 4px;
    }
    
    .profile-details strong {
        color: var(--primary-color);
    }
</style>

<h2 class="section-title">Profile Settings</h2>

<div class="profile-preview">
    <?php
    $profile_picture = isset($_SESSION['user']['profile_picture']) && !empty($_SESSION['user']['profile_picture']) 
        ? $_SESSION['user']['profile_picture'] 
        : "uploads/profile_pictures/default.png";
    ?>
    <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="profile-image">
    <h3><?php echo htmlspecialchars($_SESSION['user']['name']); ?></h3>
    
    <div class="profile-details">
        <p><strong>Role:</strong> <?php echo ucfirst(htmlspecialchars($_SESSION['user']['role'])); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user']['email'] ?? 'Not available'); ?></p>
    </div>
</div>

<div class="profile-form">
    <h3 class="section-title">Update Profile Picture</h3>
    <form method="POST" enctype="multipart/form-data">
        <label for="profile-picture"><strong>Select Image:</strong></label><br>
        <input type="file" id="profile-picture" name="profile_picture" accept="image/*"><br>
        <button type="submit">Upload Picture</button>
    </form>
</div>

<div class="profile-form">
    <h3 class="section-title">Update Personal Information</h3>
    <form method="POST">
        <label for="user-name"><strong>Full Name:</strong></label><br>
        <input type="text" id="user-name" name="name" value="<?php echo htmlspecialchars($_SESSION['user']['name']); ?>" required><br>
        <button type="submit">Update Information</button>
    </form>
</div>

<div class="profile-form">
    <h3 class="section-title">Account Actions</h3>
    <a href="logout.php"><button class="logout-btn">Logout</button></a>
</div>