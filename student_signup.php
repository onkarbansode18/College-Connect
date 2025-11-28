
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
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $dept = $_POST['dept'];
    $year = $_POST['year'];
    $semester = $_POST['semester'];
    $enrollment_no = trim($_POST['enrollment_no']);
    $mobile_no = trim($_POST['mobile_no']);

    // Basic PHP validations
    if (empty($name) || empty($email) || empty($password) || empty($enrollment_no) || empty($mobile_no)) {
        echo "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } elseif (!preg_match("/^[0-9]{10}$/", $mobile_no)) {
        echo "Invalid mobile number. It should be 10 digits.";
    } else {
        $sql = "INSERT INTO students (name, email, password, dept, year, semester, enrollment_no, mobile_no)
                VALUES ('$name', '$email', '$password', '$dept', '$year', '$semester', '$enrollment_no', '$mobile_no')";

        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Sign Up</title>
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
            overflow-y: auto;
            max-height: 600px;
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

        .input-group input, .input-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .input-group input:focus, .input-group select:focus {
            border-color: var(--accent-color);
            outline: none;
        }

        .register-btn {
            background-color: var(--accent-color);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 10px;
        }

        .register-btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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

        .login-link {
            margin-top: 25px;
            text-align: center;
        }

        .login-link a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
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
            .form-section {
                max-height: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="info-section">
            <h1>Student Sign Up</h1>
            <p>Join our platform to access your academic resources, courses, and more.</p>
        </div>
        <div class="form-section">
            <?php
            if (isset($error_message) && !empty($error_message)) {
                echo "<div class='error-message'>{$error_message}</div>";
            }
            ?>
            <form method="POST">
                <div class="input-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required minlength="3" maxlength="100">
                </div>
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required minlength="6">
                </div>
                <div class="input-group">
                    <label for="dept">Department</label>
                    <select id="dept" name="dept" required>
                        <option value="CS">Computer Science</option>
                        <option value="ME">Mechanical Engineering</option>
                        <option value="EE">Electrical Engineering</option>
                        <option value="CE">Civil Engineering</option>
                        <option value="CH">Chemical Engineering</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="year">Year</label>
                    <select id="year" name="year" required>
                        <option value="1st">1st Year</option>
                        <option value="2nd">2nd Year</option>
                        <option value="3rd">3rd Year</option>
                        <option value="4th">4th Year</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="semester">Semester</label>
                    <select id="semester" name="semester" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="enrollment_no">Enrollment Number</label>
                    <input type="text" id="enrollment_no" name="enrollment_no" required>
                </div>
                <div class="input-group">
                    <label for="mobile_no">Mobile Number</label>
                    <input type="text" id="mobile_no" name="mobile_no" required pattern="[0-9]{10}" placeholder="10 digits only">
                </div>
                <button type="submit" class="register-btn">Register</button>
            </form>
            <div class="login-link">
                <p>Already have an account? <a href="login.php">Sign In</a></p>
            </div>
        </div>
    </div>
</body>
</html>