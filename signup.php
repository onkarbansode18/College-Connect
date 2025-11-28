<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Choose Your Role</title>
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

        .signup-section {
            padding: 40px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .signup-section h2 {
            color: var(--primary-color);
            margin-bottom: 30px;
            text-align: center;
            font-size: 1.8rem;
        }

        .signup-options {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .signup-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .signup-btn:hover {
            background-color: #34495e;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .signup-btn.student {
            background-color: var(--accent-color);
        }

        .signup-btn.student:hover {
            background-color: #2980b9;
        }

        .signup-btn.cr {
            background-color: #2ecc71;
        }

        .signup-btn.cr:hover {
            background-color: #27ae60;
        }

        .signup-btn.faculty {
            background-color: var(--primary-color);
        }

        .signup-btn.faculty:hover {
            background-color: #34495e;
        }

        .login-link {
            margin-top: 30px;
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
            .info-section, .signup-section {
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
            <h1>Join Our Platform</h1>
            <p>Create an account to access dedicated features based on your role in the academic community.</p>
        </div>
        <div class="signup-section">
            <h2>Choose Your Role</h2>
            <div class="signup-options">
                <a href="student_signup.php" class="signup-btn student">Sign Up as Student</a>
                <a href="cr_signup.php" class="signup-btn cr">Sign Up as CR</a>
                <a href="faculty_signup.php" class="signup-btn faculty">Sign Up as Faculty</a>
            </div>
            <div class="login-link">
                <p>Already have an account? <a href="login.php">Sign In</a></p>
            </div>
        </div>
    </div>
</body>
</html>