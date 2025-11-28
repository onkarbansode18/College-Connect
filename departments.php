<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments - Government Polytechnic Ahmednagar</title>
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

        .page-header {
            height: 50vh;
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('Colimg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--white);
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            font-family: 'Playfair Display', serif;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
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

        .department-list {
            padding-top: 5rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .department-card {
            background-color: var(--white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .department-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .department-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .department-info {
            padding: 1.5rem;
        }

        .department-info h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .department-info p {
            margin-bottom: 1rem;
            color: var(--gray);
        }

        .more-info {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: var(--primary-color);
            color: var(--white);
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .more-info:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .accordion {
            margin-bottom: 4rem;
        }

        .accordion-item {
            margin-bottom: 1rem;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 5px 10px rgba(0,0,0,0.05);
        }

        .accordion-header {
            background-color: var(--white);
            padding: 1rem 1.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .accordion-header h3 {
            font-size: 1.2rem;
            font-weight: 500;
        }

        .accordion-content {
            background-color: var(--white);
            padding: 0 1.5rem;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .accordion-content.active {
            padding: 1rem 1.5rem;
            max-height: 500px;
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
            .page-header h1 {
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
                <img src="logo.jpg" alt="Government Polytechnic Ahmednagar College Logo">
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
                    echo '<a href="logout.php" class="btn btn-primary">Logout</a>';
                } else {
                    echo '<a href="login.php" class="btn btn-primary">Student Login</a>';
                }
                ?>
                <a href="login.php" class="btn btn-secondary">Faculty</a>
            </div>
        </div>
    </header>

    <section class="page-header">
        <div class="container">
            <h1>Our Departments</h1>
            <p>Discover our diverse range of technical programs designed to shape the engineers of tomorrow</p>
        </div>
    </section>

    <section class="departments">
        <div class="container">
            <div class="department-list">
                <div class="department-card">
                    <img src="ME.webp" alt="Mechanical Engineering" class="department-img">
                    <div class="department-info">
                        <h3>Mechanical Engineering</h3>
                        <p>The Department of Mechanical Engineering offers a comprehensive program covering design, manufacturing, thermal sciences, and engineering mechanics.</p>

                    </div>
                </div>

                <div class="department-card">
                    <img src="CO.webp" alt="Computer Engineering" class="department-img">
                    <div class="department-info">
                        <h3>Computer Engineering</h3>
                        <p>The Computer Engineering department provides education in software development, hardware systems, networking, and emerging technologies.</p>

                    </div>
                </div>

                <div class="department-card">
                    <img src="EE.webp" alt="Electrical Engineering" class="department-img">
                    <div class="department-info">
                        <h3>Electrical Engineering</h3>
                        <p>The Electrical Engineering program focuses on power systems, electrical machines, control systems, and renewable energy technologies.</p>

                    </div>
                </div>

                <div class="department-card">
                    <img src="CIVIL.webp" alt="Civil Engineering" class="department-img">
                    <div class="department-info">
                        <h3>Civil Engineering</h3>
                        <p>The Civil Engineering department offers training in structural design, construction management, transportation, and environmental engineering.</p>

                    </div>
                </div>

                <div class="department-card">
                    <img src="ETC.webp" alt="Electronics Engineering" class="department-img">
                    <div class="department-info">
                        <h3>Electronics & Telecommunication</h3>
                        <p>The E&TC department specializes in electronic circuits, communication systems, signal processing, and microprocessors.</p>

                    </div>
                </div>

                <div class="department-card">
                    <img src="CM.webp" alt="Computer Technology" class="department-img">
                    <div class="department-info">
                        <h3>Computer Technology</h3>
                        <p>The department focuses on data management, web technologies, cybersecurity, and information systems development.</p>

                    </div>
                </div>

                <div class="department-card">
                    <img src="PO.webp" alt="Production Engineering" class="department-img">
                    <div class="department-info">
                        <h3>Production Engineering</h3>
                        <p>The Production Engineering department focuses on the efficient manufacturing and production of goods.</p>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="department-faq">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <div class="accordion">
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>What is the student-faculty ratio?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="accordion-content">
                        <p>Our departments maintain an excellent student-faculty ratio of approximately 20:1, ensuring personalized attention and guidance for each student.</p>
                    </div>
                </div>

                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>Are there industry collaborations?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="accordion-content">
                        <p>Yes, all departments have active collaborations with leading industries for internships, projects, and placements. These partnerships provide valuable hands-on experience and industry exposure to our students.</p>
                    </div>
                </div>

                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>What laboratories are available?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="accordion-content">
                        <p>Each department is equipped with specialized laboratories featuring modern equipment and software. These labs provide practical training aligned with the latest industry standards and technological advancements.</p>
                    </div>
                </div>

                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>Are there opportunities for research?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="accordion-content">
                        <p>Absolutely! Students are encouraged to participate in research projects, technical paper presentations, and innovation competitions. Faculty members actively guide students in pursuing research in emerging areas of technology.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>About Us</h3>
                    <p>Government Polytechnic Ahmednagar is committed to excellence in technical education and research.</p>
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
                <p>&copy; 2024 Government Polytechnic Ahmednagar. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // For accordion functionality
        const accordionHeaders = document.querySelectorAll('.accordion-header');

        accordionHeaders.forEach(header => {
            header.addEventListener('click', () => {
                const accordionContent = header.nextElementSibling;
                accordionContent.classList.toggle('active');

                // Update toggle icon
                const toggleIcon = header.querySelector('.toggle-icon');
                toggleIcon.textContent = accordionContent.classList.contains('active') ? '−' : '+';
            });
        });
    </script>
</body>
</html>
