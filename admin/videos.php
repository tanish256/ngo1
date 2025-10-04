<?php
session_start();
if (!$_SESSION['role'] == 'admin') {
    header("Location: login.php");
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hayatu Charity Foundation - Admin Videos</title>
    <link rel="shortcut icon" href="images/hayatu.svg" type="image/x-icon" />
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

        /* Video Cards */
        .videos-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .video-card {
            background: #F8F9FF;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .video-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .video-card-header {
            background: var(--primary);
            color: white;
            padding: 15px 20px;
            font-weight: 600;
            font-size: 18px;
        }

        .video-player {
            width: 100%;
            aspect-ratio: 16/9;
            background: #000;
        }

        .video-player video {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .video-form {
            padding: 20px;
        }

        .video-form input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            background: white;
        }

        .video-form button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            width: 100%;
        }

        .video-form button:hover {
            background: var(--primary-dark);
        }

        /* Upload Status */
        .upload-status {
            margin-top: 10px;
            padding: 10px;
            border-radius: var(--border-radius);
            display: none;
            text-align: center;
        }

        .upload-status.success {
            background: rgba(40, 199, 111, 0.1);
            color: var(--success);
            display: block;
        }

        .upload-status.error {
            background: rgba(234, 84, 85, 0.1);
            color: var(--danger);
            display: block;
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

        /* Responsive Design */
        @media (max-width: 992px) {
            .admin-main {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
            }
            
            .videos-container {
                grid-template-columns: 1fr;
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
            
            .video-card {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 576px) {
            .videos-container {
                grid-template-columns: 1fr;
            }
            
            .main {
                padding: 15px;
            }
            
            .video-card-header {
                padding: 12px 15px;
                font-size: 16px;
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
                        <a href="#" class="active"><li><i class="fa fa-video"></i> Videos</li></a>
                        <a href="applications.php"><li><i class="fa fa-user-check"></i>Scholarship Applications</li></a>
                        <a href="volunteers.php"><li><i class="fa fa-hands-helping"></i> Volunteers</li></a>
                        <a href="blog.php"><li><i class="fa fa-blog"></i> Blog</li></a>
                        <a href="banner-imgs.php"><li><i class="fa fa-images"></i> Banner Images</li></a>
                        <a href="logout.php" class="logout"><li><i class="fa fa-sign-out"></i> Logout</li></a>
                    </ul>
                </nav>
            </div>
            
            <div class="main">
                <h1><i class="fa fa-video"></i> Video Management</h1>
                
                <div class="videos-container">
                    <div class="video-card">
                        <div class="video-card-header">
                            Home Page Video
                        </div>
                        <div class="video-player">
                            <video id="home_video_player" controls></video>
                        </div>
                        <form class="video-form" action="upload_video.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="video_id" value="home_video">
                            <input type="file" name="video" accept="video/*" required />
                            <button type="submit" name="submit">Upload Video</button>
                            <div class="upload-status" id="home-status"></div>
                        </form>
                    </div>
                    
                    <div class="video-card">
                        <div class="video-card-header">
                            About Us Page Video
                        </div>
                        <div class="video-player">
                            <video id="about_video_player" controls></video>
                        </div>
                        <form class="video-form" action="upload_video.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="video_id" value="about_video">
                            <input type="file" name="video" accept="video/*" required />
                            <button type="submit" name="submit">Upload Video</button>
                            <div class="upload-status" id="about-status"></div>
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
    
    <button id="topBtn" onclick="scrollToTop()">&uarr;</button>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/script.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '../videos.json',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#home_video_player').attr('src', '../' + data.home_video);
                    $('#about_video_player').attr('src', '../' + data.about_video);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching video data: ' + error);
                }
            });
            
            // Handle form submissions with AJAX
            $('.video-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var statusElement = form.find('.upload-status');
                var fileInput = form.find('input[type="file"]')[0];
                var file = fileInput.files[0];

                // ✅ Check file size before uploading
                var maxSize = 40 * 1024 * 1024; // 40MB
                if (file && file.size > maxSize) {
                    var sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                    statusElement.removeClass('success').addClass('error')
                        .text("File is " + sizeMB + " MB. Maximum allowed size is 40MB.");
                    return; // stop here, don’t upload
                }

                // ✅ AJAX upload with progress bar
                $.ajax({
                    url: 'upload_video.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                statusElement.removeClass('error success')
                                .text("Uploading... " + percentComplete + "%");
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(response) {
                        statusElement.removeClass('error').addClass('success').text(response.message);

                        var videoId = form.find('input[name="video_id"]').val();
                        $('#' + videoId + '_player')
                            .attr('src', '../videos/' + response.file_path)
                            .get(0).load(); // force reload
                            console.log("done update");
                    },
                    error: function(xhr) {
                        let msg = xhr.responseText || 'Error uploading video.';
                        statusElement.removeClass('success').addClass('error').text(msg);
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