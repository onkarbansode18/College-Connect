<?php 
session_start(); 
$servername = "localhost:3308"; 
$username = "root"; 
$password = ""; 
$dbname = "college_web_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $tables = ['students', 'crs', 'faculty'];
    $redirects = ['student_dashboard.php', 'cr_dashboard.php', 'faculty_dashboard.php'];
    
    foreach ($tables as $index => $table) {
        $sql = "SELECT * FROM $table WHERE email='$email'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Store user data in session
                $_SESSION['user'] = $user;
                $_SESSION['user']['role'] = $table;
                header("Location: " . $redirects[$index]);
                exit();
            }
        }
    }
    
    $error_message = "Invalid email or password";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - Login</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 90%;
            max-width: 1000px;
            display: flex;
        }

        .info-section {
            background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.9)),
                        url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
            color: #fff;
            padding: 40px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .info-section h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .info-section p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .form-section {
            padding: 40px;
            flex: 1;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-color);
            font-weight: 500;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .input-group input:focus {
            border-color: var(--accent-color);
            outline: none;
        }

        .login-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-btn:hover {
            background-color: #34495e;
        }

        .error-message {
            color: var(--secondary-color);
            background-color: #fde8e8;
            border: 1px solid var(--secondary-color);
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }

        .links {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        .links a {
            color: var(--accent-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .signup-link {
            display: inline-block;
            margin-top: 15px;
            font-weight: 500;
            color: var(--accent-color);
            transition: all 0.3s;
        }

        .signup-link:hover {
            transform: translateY(-2px);
        }

        .links .signup-btn {
            
            color: var(--accent-color);
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .info-section, .form-section {
                padding: 30px;
            }
            .info-section h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="info-section">
            <h1>Student Login</h1>
            <p>Access your academic resources, courses, and more.</p>
        </div>
        <div class="form-section">
            <?php
            if (!empty($error_message)) {
                echo "<div class='error-message'>{$error_message}</div>";
            }
            ?>
            <form method="POST">
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <input type="submit" value="Sign In" class="login-btn">
                <?php
                if (isset($_GET['redirect'])) {
                    echo '<input type="hidden" name="redirect" value="' . htmlspecialchars($_GET['redirect']) . '">';
                }
                ?>
            </form>
            <div class="links">
                <a href="signup.php" class="signup-btn">Sign Up</a>
                <a href="help.php">Need Help?</a>
            </div>
        </div>
    </div>
</body>
</html>