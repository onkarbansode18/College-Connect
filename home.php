<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goverment Polytechnic Ahmednagar - Shaping Tomorrow's Engineers</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --text-color: #34495e;
            --bg-color: #f5f6fa;
            --white: #ffffff;
            --gray: #7f8c8d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: var(--bg-color);
            line-height: 1.6;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            background-color: var(--white);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .logo img {
            height: 60px;
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.05);
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 2rem;
        }

        nav ul li a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            color: var(--white);
        }

        .btn-secondary:hover {
            background-color: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(46, 204, 113, 0.3);
        }

        .hero {
            height: 100vh;
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('Colimg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            max-width: 800px;
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            font-family: 'Playfair Display', serif;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            animation: fadeInUp 1s ease-out;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease-out 0.5s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin: 4rem 0 2rem;
            font-family: 'Playfair Display', serif;
            color: var(--primary-color);
            position: relative;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 3px;
            background-color: var(--secondary-color);
            margin: 10px auto 0;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            padding: 2rem 0;
        }

        .stat-item {
            text-align: center;
            background-color: var(--white);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .stat-item h3 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            font-size: 1.1rem;
            color: var(--gray);
        }

        .places-grid, .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .place, .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .place:hover, .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .place img, .gallery-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .place:hover img, .gallery-item:hover img {
            transform: scale(1.05);
        }

        .place-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: var(--white);
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .place:hover .place-info {
            transform: translateY(0);
        }

        .place-info h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        footer {
            background-color: #2c3e50;
            color: var(--white);
            padding: 4rem 0 2rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .footer-section h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: var(--secondary-color);
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section ul li a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section ul li a:hover {
            color: var(--white);
        }

        .newsletter form {
            display: flex;
            margin-top: 1rem;
        }

        .newsletter input {
            flex-grow: 1;
            padding: 0.7rem;
            border: none;
            border-radius: 5px 0 0 5px;
            font-size: 1rem;
        }

        .newsletter button {
            padding: 0.7rem 1.5rem;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .newsletter button:hover {
            background-color: #2980b9;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-icons a {
            color: var(--white);
            font-size: 1.3rem;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            color: var(--primary-color);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #34495e;
            color: #bdc3c7;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .auth-buttons {
                display: none;
            }

            nav ul {
                display: none;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="logo.jpg" alt="Goverment Polytechnic Ahmednagar College Logo">
            </div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="departments.php">Departments</a></li>
                    <li><a href="admission.php">Admission</a></li>
                    <li><a href="placements.php">Placements</a></li>
                    <li><a href="facilities.php">Facilities</a></li>
                </ul>
            </nav>
            <div class="auth-buttons">
                <?php
                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                    if (isset($_GET['login_success']) && $_GET['login_success'] == 1) {
                        echo '<span class="success-message">Welcome, ' . htmlspecialchars($_SESSION['username']) . '!</span>';
                    }
                    echo '<a href="logout.php" class="btn btn-primary">Logout</a>';
                } else {
                    echo '<a href="login.php" class="btn btn-primary">Student Login</a>';
                }
                ?>
                <a href="login.php" class="btn btn-secondary">Faculty</a>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to <br> Government Polytechnic Ahilyanagar</h1>
            <p>Empowering Future Engineers with Excellence in Education</p>
            <form class="search-form" action="<?php echo isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true ? 'admission-form.php' : 'login.php'; ?>" method="get">
                <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
                    <input type="hidden" name="redirect" value="admission-form.php">
                <?php endif; ?>
                
                
            </form>
        </div>
    </section>

    <section class="stats">
        <div class="container">
            <h2 class="section-title">Our Achievements</h2>
            <div class="stats-container">
                <div class="stat-item">
                    <h3>8</h3>
                    <p>Departments</p>
                </div>
                <div class="stat-item">
                    <h3>50+</h3>
                    <p>Faculty</p>
                </div>
                <div class="stat-item">
                    <h3>95%</h3>
                    <p>Placement</p>
                </div>
                <div class="stat-item">
                    <h3>50+</h3>
                    <p>Companies</p>
                </div>
            </div>
        </div>
    </section>

    <section class="popular-places">
        <div class="container">
            <h2 class="section-title">Campus Facilities</h2>
            <div class="places-grid">
                <div class="place">
                    <img src="lab1.jpg" alt="Computer Lab">
                    <div class="place-info">
                        <h3>Advanced Computer Labs</h3>
                        <p>State-of-the-art Computing Facilities</p>
                    </div>
                </div>
                <div class="place">
                    <img src="library.jpg" alt="Central Library">
                    <div class="place-info">
                        <h3>Central Library</h3>
                        <p>Rich Collection of Technical Resources</p>
                    </div>
                </div>
                <div class="place">
                    <img src="sports.jpg" alt="Sports Complex">
                    <div class="place-info">
                        <h3>Sports Complex</h3>
                        <p>Multi-sport Facilities</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="gallery">
        <div class="container">
            <h2 class="section-title">Campus Gallery</h2>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="campus1.jpg" alt="College Building">
                </div>
                <div class="gallery-item">
                    <img src="workshop.jpg" alt="Engineering Workshop">
                </div>
                <div class="gallery-item">
                    <img src="placement.jpg" alt="Placement Drive">
                </div>
                <div class="gallery-item">
                    <img src="cultural.jpg" alt="Cultural Event">
                </div>
                <div class="gallery-item">
                    <img src="seminar.jpg" alt="Technical Seminar">
                </div>
                <div class="gallery-item">
                    <img src="hostel.jpg" alt="Hostel Building">
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>About Us</h3>
                    <p>Goverment Polytechnic Ahmednagar is committed to excellence in technical education and research.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="home.php">Home</a></li>
                        <li><a href="departments.php">Departments</a></li>
                        <li><a href="admission.php">Admission</a></li>
                        <li><a href="placements.php">Placements</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p>Post Box No. 71, Burudgaon Road, Ahmednagar - 414001, Maharashtra, India</p>
                    <p>Phone: 0241-2346192</p>
                    <p>Email: office.gpahmednagar@dtemaharashtra.gov.in</p>
                </div>
                <div class="footer-section">
                    <h3>Connect With Us</h3>
                    <form class="newsletter">
                        <input type="email" placeholder="Enter your email">
                        <button type="submit">Subscribe</button>
                    </form>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2024 Goverment Polytechnic Ahmednagar. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>