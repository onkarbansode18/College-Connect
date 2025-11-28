<?php 
session_start();  
// Check if user is logged in and is a faculty member 
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'faculty') {     
    header("Location: login.php");     
    exit(); 
}  

$user = $_SESSION['user']; 
?>  

<!DOCTYPE html> 
<html lang="en"> 
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>     
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>         
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --accent-color: #3498db;
            --text-color: #333;
            --bg-color: #f5f6fa;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            min-height: 100vh;
        }

        .dashboard { 
            display: flex; 
            width: 100%;
            height: 100vh;
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .sidebar { 
            width: 280px; 
            background-color: var(--primary-color);
            color: white;
            padding: 30px;
            height: 100vh;
            overflow-y: auto;
        }
        
        .content { 
            flex-grow: 1; 
            padding: 30px 40px; 
            overflow-y: auto;
            height: 100vh;
        }
        
        .tabs { 
            list-style-type: none; 
            padding: 0; 
            margin-top: 30px;
        }
        
        .tabs li { 
            margin: 15px 0; 
        }
        
        .tabs a { 
            text-decoration: none; 
            color: #fff; 
            font-weight: 500;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .tabs a:hover { 
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        .profile {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .profile img { 
            border-radius: 50%; 
            width: 100px; 
            height: 100px; 
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .profile h3 {
            margin: 15px 0 5px;
            font-weight: 700;
        }
        
        .profile p {
            opacity: 0.8;
            font-size: 0.9rem;
        }
        
        .feature-header {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--accent-color);
        }
        
        .feature-header h2 {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.8rem;
        }
        
        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
                height: auto;
                overflow: visible;
            }
            
            .sidebar {
                width: 100%;
                padding: 20px;
                height: auto;
            }
            
            .content {
                height: auto;
                min-height: 80vh;
            }
        }
    </style> 
</head> 
<body>     
    <div class="dashboard">         
        <div class="sidebar">             
            <div class="profile">                 
                <img src="<?php echo htmlspecialchars($user['profile_picture'] ?: 'path_to_default_pfp.jpg'); ?>" alt="Profile Picture">                 
                <h3><?php echo htmlspecialchars($user['name']); ?></h3>                 
                <p><?php echo htmlspecialchars($user['dept']); ?></p>             
            </div>             
            <ul class="tabs">                 
                <li><a href="?feature=todays_schedule">Today's Schedule</a></li>                 
                <li><a href="?feature=manage_announcements">Add Announcements</a></li>                 
                <li><a href="?feature=view_attendance">View Attendance</a></li>                 
                <li><a href="?feature=study_material">Upload Study Material</a></li>                 
                <li><a href="?feature=upload_test_marks">Upload Test Marks</a></li>                 
                <li><a href="?feature=queries">Queries</a></li>                 
                <li><a href="?feature=profile_settings">Profile Settings</a></li>             
            </ul>         
        </div>         
        <div class="content">
            <div class="feature-header">
                <h2>
                    <?php 
                    $feature = isset($_GET['feature']) ? $_GET['feature'] : 'todays_schedule';
                    $title = str_replace('_', ' ', ucfirst($feature));
                    echo htmlspecialchars($title);
                    ?>
                </h2>
            </div>
            <?php             
            $feature = isset($_GET['feature']) ? $_GET['feature'] : 'todays_schedule';             
            include "features/$feature.php";             
            ?>         
        </div>     
    </div> 
</body> 
</html>