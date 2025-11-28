<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admissions - Government Polytechnic Ahmednagar</title>
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

        .admission-info {
            padding-top: 5rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .admission-card {
            background-color: var(--white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .admission-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .admission-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .admission-details {
            padding: 1.5rem;
        }

        .admission-details h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .admission-details p {
            margin-bottom: 1rem;
            color: var(--gray);
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
            <h1>Admissions</h1>
            <p>Join us and shape your future with our comprehensive technical programs</p>
        </div>
    </section>

    <section class="admission-info">
        <div class="container">
            <div class="admission-card">
                <!-- <img src="admission_process.jpg" alt="Admission Process" class="admission-img"> -->
                <div class="admission-details">
                    <h3>Admission Process</h3>
                    <p>Learn about the step-by-step process for applying to our programs, including eligibility criteria, required documents, and important dates.</p>
                    <p>1. Fill out the online application form available on our website.</p>
                    <p>2. Pay the application fee through the online portal.</p>
                    <p>3. Submit the required documents, including academic transcripts and identification proof.</p>
                </div>
            </div>

            <div class="admission-card">
                <!-- <img src="eligibility.jpg" alt="Eligibility Criteria" class="admission-img"> -->
                <div class="admission-details">
                    <h3>Eligibility Criteria</h3>
                    <p>Check the eligibility requirements for different programs offered at Government Polytechnic Ahmednagar.</p>
                    <p>1. Candidates must have passed the qualifying examination with a minimum of 50% marks.</p>
                    <p>2. Reserved category candidates have a relaxation of 5% in the minimum marks required.</p>
                    <p>3. Candidates must have appeared for the entrance exam conducted by the Directorate of Technical Education, Maharashtra.</p>
                </div>
            </div>

            <div class="admission-card">
                <!-- <img src="fees_structure.jpg" alt="Fee Structure" class="admission-img"> -->
                <div class="admission-details">
                    <h3>Fee Structure</h3>
                    <p>Get detailed information about the fee structure for various courses, including tuition fees, examination fees, and other charges.</p>
                    <p>1. Tuition fees vary depending on the program and can be paid in installments.</p>
                    <p>2. Additional fees include examination fees, library fees, and laboratory fees.</p>
                    <p>3. Scholarships and financial aid are available for eligible students.</p>
                </div>
            </div>

            <div class="admission-card">
                <!-- <img src="scholarships.jpg" alt="Scholarships" class="admission-img"> -->
                <div class="admission-details">
                    <h3>Scholarships</h3>
                    <p>Explore the various scholarship opportunities available for students to support their education.</p>
                    <p>1. Merit-based scholarships are awarded to students with outstanding academic performance.</p>
                    <p>2. Need-based scholarships are available for students from economically disadvantaged backgrounds.</p>
                    <p>3. Government scholarships and external funding opportunities are also available.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="admission-faq">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <div class="accordion">
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>What documents are required for admission?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="accordion-content">
                        <p>You will need to submit your academic transcripts, identification proof, passport-size photographs, and any other documents specified in the admission guidelines.</p>
                    </div>
                </div>

                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>Is there an entrance exam for admission?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="accordion-content">
                        <p>Yes, admission to our programs is based on performance in the entrance exam conducted by the Directorate of Technical Education, Maharashtra.</p>
                    </div>
                </div>

                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>What is the application process?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="accordion-content">
                        <p>The application process involves filling out the online application form, paying the application fee, and submitting the required documents.</p>
                    </div>
                </div>

                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>Are there any reservations for admission?</h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="accordion-content">
                        <p>Yes, we follow the reservation policy as per the guidelines of the Government of Maharashtra.</p>
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
