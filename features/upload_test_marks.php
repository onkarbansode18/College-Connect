<?php 
$servername = "localhost:3308"; 
$username = "root"; 
$password = ""; 
$dbname = "college_web_app";  

$conn = new mysqli($servername, $username, $password, $dbname);  

if ($conn->connect_error) {     
    die("Connection failed: " . $conn->connect_error); 
}  

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['marks_pdf'])) {     
    // Handle file upload     
    $target_dir = "uploads/test_marks/";     
    if (!is_dir($target_dir)) {         
        mkdir($target_dir, 0777, true);     
    }     
    $target_file = $target_dir . basename($_FILES["marks_pdf"]["name"]);     
    $subject_name = $_POST['subject_name'];     
    $uploaded_by = $_SESSION['user']['id'];      
    
    if (move_uploaded_file($_FILES["marks_pdf"]["tmp_name"], $target_file)) {         
        // Insert record into test_marks table         
        $sql = "INSERT INTO test_marks (subject_name, marks_pdf, uploaded_at, uploaded_by)                 
                VALUES ('$subject_name', '$target_file', NOW(), $uploaded_by)";         
        $conn->query($sql);         
        echo "<div class='alert success'>The file has been uploaded successfully.</div>";     
    } else {         
        echo "<div class='alert error'>Sorry, there was an error uploading your file.</div>";     
    } 
}  

$user_id = $_SESSION['user']['id']; 
$role = $_SESSION['user']['role'];  

if ($role === 'faculty') {
    // Faculty can upload test marks
} else {
    // For students and CRs, display a message or redirect
    echo "<div class='alert error'>You do not have permission to view this page.</div>";
    $conn->close();
    exit();
}
?>

<style>
    .upload-form {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .upload-form input[type="text"] {
        width: 100%;
        padding: 12px;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-family: 'Roboto', sans-serif;
        margin: 10px 0 20px;
        transition: border 0.3s ease;
    }
    
    .upload-form input[type="file"] {
        width: 100%;
        padding: 12px;
        margin: 10px 0 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
        border: 1px dashed #ddd;
    }
    
    .upload-form input[type="text"]:focus {
        border-color: var(--accent-color);
        outline: none;
    }
    
    .upload-form button {
        background-color: var(--accent-color);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .upload-form button:hover {
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
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }
</style>

<div class="upload-form">
    <h2 class="section-title">Upload Test Marks</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="subject-name"><strong>Subject Name:</strong></label>
            <input type="text" id="subject-name" name="subject_name" required placeholder="Enter subject name">
        </div>
        
        <div class="form-group">
            <label for="marks-pdf"><strong>Upload Marks PDF:</strong></label>
            <input type="file" id="marks-pdf" name="marks_pdf" accept=".pdf" required>
        </div>
        
        <button type="submit">Upload Marks</button>
    </form>
</div>

<?php $conn->close(); ?>