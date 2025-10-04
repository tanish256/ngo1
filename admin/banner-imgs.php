<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hayatu Charity Foundation - Admin Banner Images</title>
    <link rel="shortcut icon" href="../images/hayatu.svg" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Jomhuria&family=Kaushan+Script&display=swap" rel="stylesheet" />
    <style>
        :root {
            --primary: #2D5BFF;
            --primary-dark: #1A46E0;
            --secondary: #FF9F43;
            --dark: #333333;
            --light: #F8F9FA;
            --gray: #9197B3;
            --success: #28C76F;
            --danger: #EA5455;
            --warning: #FF9F43;
            --border-radius: 8px;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #F5F7FF;
            color: var(--dark);
            line-height: 1.6;
        }

        .root {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header Styles */
        header {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            height: 70px;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        header nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
            padding: 0 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo img {
            height: 40px;
        }

        .buttons button {
            background: white;
            color: var(--primary);
            border: none;
            padding: 8px 16px;
            border-radius: var(--border-radius);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-left: 10px;
        }

        .buttons button:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
        }

        /* Admin Main Layout */
        .admin-main {
            display: flex;
            flex: 1;
            max-width: 1400px;
            margin: 20px auto;
            width: 100%;
            padding: 0 20px;
            gap: 20px;
        }

        /* Sidebar Styles */
        .sidebar {
            background: white;
            width: 250px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 20px 0;
            height: fit-content;
        }

        .sidebar nav ul {
            list-style: none;
        }

        .sidebar nav ul a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--dark);
            padding: 12px 20px;
            transition: var(--transition);
            border-left: 4px solid transparent;
        }

        .sidebar nav ul a:hover {
            background: #F5F7FF;
            color: var(--primary);
        }

        .sidebar nav ul a.active {
            background: #F5F7FF;
            color: var(--primary);
            border-left-color: var(--primary);
            font-weight: 600;
        }

        .sidebar nav ul a.logout {
            color: var(--danger);
            margin-top: 10px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .sidebar nav ul a.logout:hover {
            background: rgba(234, 84, 85, 0.1);
        }

        /* Main Content Area */
        .main {
            flex: 1;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 25px;
        }

        .main h1 {
            color: var(--dark);
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .main h1 i {
            color: var(--primary);
        }

        /* Banner Cards */
        .banner-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .banner-card {
            background: var(--light);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .banner-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .banner-card h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .banner-card h2 i {
            color: var(--primary);
        }

        .banner-preview {
            width: 100%;
            height: 200px;
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-bottom: 15px;
            border: 1px solid #eee;
        }

        .banner-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .banner-card:hover .banner-preview img {
            transform: scale(1.05);
        }

        .banner-form {
            margin-top: 15px;
        }

        .banner-form input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            margin-bottom: 12px;
            font-size: 14px;
        }

        .banner-form button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            width: 100%;
        }

        .banner-form button:hover {
            background: var(--primary-dark);
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 40px 20px 20px;
            margin-top: auto;
        }

        footer nav {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto 20px;
        }

        footer .logo img {
            height: 40px;
            filter: brightness(0) invert(1);
        }

        footer ul {
            display: flex;
            flex-wrap: wrap;
            list-style: none;
            gap: 20px;
        }

        footer ul a {
            color: white;
            text-decoration: none;
            transition: var(--transition);
        }

        footer ul a:hover {
            color: var(--secondary);
        }

        footer button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
        }

        footer button:hover {
            background: var(--primary-dark);
        }

        footer p {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 20px;
            opacity: 0.8;
        }

        .socials {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .socials a {
            color: white;
            font-size: 24px;
            transition: var(--transition);
        }

        .socials a:hover {
            color: var(--secondary);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding: 15px 0 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
            opacity: 0.7;
        }

        .copyright .blue {
            color: var(--primary);
        }

        /* Scroll to Top Button */
        #topBtn {
            display: none;
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 99;
            border: none;
            outline: none;
            background: var(--primary);
            color: white;
            cursor: pointer;
            padding: 12px 15px;
            border-radius: 50%;
            font-size: 18px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        #topBtn:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: var(--border-radius);
            color: white;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: var(--shadow);
            transform: translateX(100%);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .notification.show {
            transform: translateX(0);
            opacity: 1;
        }

        .notification.success {
            background: var(--success);
        }

        .notification.error {
            background: var(--danger);
        }

        .notification i {
            font-size: 20px;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .admin-main {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
            }
            
            .banner-cards {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            footer nav {
                flex-direction: column;
                gap: 20px;
            }
            
            footer ul {
                justify-content: center;
            }
            
            .banner-cards {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .main {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="root">
        <header>
            <nav>
                <div class="logo"><img src="../images/hayatu2.svg" alt="Hayatu Charity Foundation" /></div>
                <div class="buttons">
                    <button onclick="window.location.href='../index.html'">View Site</button>
                    <button onclick="window.location.href='logout.php'">Logout</button>
                </div>
            </nav>
        </header>
        
        <div class="admin-main">
            <div class="sidebar">
                <nav>
                    <ul>
                        <a href="index.php"><li><i class="fa fa-image"></i> Gallery</li></a>
                        <a href="projects.php"><li><i class="fa fa-project-diagram"></i> Projects</li></a>
                        <a href="videos.php"><li><i class="fa fa-video"></i> Videos</li></a>
                        <a href="applications.php"><li><i class="fa fa-user-check"></i>Scholarship Applications</li></a>
                        <a href="volunteers.php"><li><i class="fa fa-hands-helping"></i> Volunteers</li></a>
                        <a href="blog.php"><li><i class="fa fa-blog"></i> Blog</li></a>
                        <a href="#" class="active"><li><i class="fa fa-images"></i> Banner Images</li></a>
                        <a href="logout.php" class="logout"><li><i class="fa fa-sign-out"></i> Logout</li></a>
                    </ul>
                </nav>
            </div>
            
            <div class="main">
                <h1><i class="fa fa-images"></i> Banner Images Management</h1>
                
                <div class="banner-cards">
                    <div class="banner-card">
                        <h2><i class="fa fa-home"></i> Home Page Background</h2>
                        <div class="banner-preview">
                            <img id="home_bg_img" src="" alt="Home Page Background">
                        </div>
                        <form class="banner-form" action="upload_banner_image.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="image_id" value="home_bg">
                            <input type="file" name="image" accept="image/*" required>
                            <button type="submit" name="submit">Upload Image</button>
                        </form>
                    </div>
                    
                    <div class="banner-card">
                        <h2><i class="fa fa-header"></i> Header Background</h2>
                        <div class="banner-preview">
                            <img id="header_bg_image_img" src="" alt="Header Background">
                        </div>
                        <form class="banner-form" action="upload_banner_image.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="image_id" value="header_bg_image">
                            <input type="file" name="image" accept="image/*" required>
                            <button type="submit" name="submit">Upload Image</button>
                        </form>
                    </div>
                    
                    <div class="banner-card">
                        <h2><i class="fa fa-image"></i> Down Image</h2>
                        <div class="banner-preview">
                            <img id="rm2_image_img" src="" alt="RM2 Image">
                        </div>
                        <form class="banner-form" action="upload_banner_image.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="image_id" value="rm2_image">
                            <input type="file" name="image" accept="image/*" required>
                            <button type="submit" name="submit">Upload Image</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <footer>
            <nav>
                <div class="logo">
                    <img src="../images/hayatu.svg" alt="Hayatu Charity Foundation" />
                </div>
                <ul>
                    <a href="../index.html"><li>Home</li></a>
                    <a href="../projects.html"><li>Projects</li></a>
                    <a href="../stories.html"><li>Our Stories</li></a>
                    <a href="../gallery.html"><li>Gallery</li></a>
                    <a href="../about.html"><li>About Us</li></a>
                    <a href="../contact.html"><li>Contact</li></a>
                </ul>
                <button onclick="window.location.href='../donation.html'">Donate</button>
            </nav>
            <p>
                Join us in making a lasting difference. At Hayatu Charity Foundation, 
                we're committed to changing lives by supporting education, providing shelter, 
                and empowering communities. Every contribution counts towards building a brighter future.
            </p>
            <div class="socials">
                <a href="https://www.instagram.com/hayatu_charity_foundation?igsh=OWJmeW0zZTJ3aTM4" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/@hayatucharityfoundation?_t=ZM-8tzel3iLb42&_r=1" target="_blank">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
                <a href="https://x.com/CharityHay26521" target="_blank">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://www.facebook.com/profile.php?id=61566345901391" target="_blank">
                    <i class="fa-brands fa-facebook"></i>
                </a>
            </div>
            <div class="copyright">
                <p>@copyright all rights reserved hayatucharityfoundation.com</p>
                <p>powered by <span class="blue">SCEC Technologies</span></p>
            </div>
        </footer>
    </div>
    
    <div id="notification" class="notification">
        <i class="fas fa-check-circle"></i>
        <span id="notification-text"></span>
    </div>
    
    <button id="topBtn" onclick="scrollToTop()">&uarr;</button>
    
    <script src="../js/jquery.min.js"></script>
    <script>
        // Show notification function
        function showNotification(message, type) {
            const notification = $('#notification');
            const notificationText = $('#notification-text');
            
            notificationText.text(message);
            notification.removeClass('success error').addClass(type).addClass('show');
            
            setTimeout(() => {
                notification.removeClass('show');
            }, 3000);
        }

        // Load banner images from JSON
        $(document).ready(function() {
            $.ajax({
                url: '../banner_images.json',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#home_bg_img').attr('src', '../' + data.home_bg);
                    $('#header_bg_image_img').attr('src', '../' + data.header_bg_image);
                    $('#rm2_image_img').attr('src', '../' + data.rm2_image);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching banner image data: ' + error);
                    showNotification('Error loading banner images', 'error');
                }
            });

            // Handle form submissions with AJAX
            $('.banner-form').on('submit', function(e) {
                e.preventDefault();
                
                const form = $(this);
                const formData = new FormData(form[0]);
                
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        showNotification('Banner image updated successfully!', 'success');
                        
                        // Update the preview image
                        const imageId = form.find('input[name="image_id"]').val();
                        const fileInput = form.find('input[type="file"]')[0];
                        
                        if (fileInput.files && fileInput.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                $(`#${imageId}_img`).attr('src', e.target.result);
                            }
                            reader.readAsDataURL(fileInput.files[0]);
                        }
                        
                        // Clear the file input
                        form.find('input[type="file"]').val('');
                    },
                    error: function() {
                        showNotification('Error updating banner image', 'error');
                    }
                });
            });
        });

        // Scroll to top functionality
        window.onscroll = function() {
            const topBtn = document.getElementById("topBtn");
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                topBtn.style.display = "block";
            } else {
                topBtn.style.display = "none";
            }
        };

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>
</html>