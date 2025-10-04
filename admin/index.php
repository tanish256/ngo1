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
    <title>Hayatu Charity Foundation - Admin Gallery</title>
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

        /* Upload Area */
        .Neon {
            background: #F8F9FF;
            border: 2px dashed #D9DFFF;
            border-radius: var(--border-radius);
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            transition: var(--transition);
        }

        .Neon:hover {
            border-color: var(--primary);
            background: #F0F3FF;
        }

        .Neon-input-dragDrop {
            color: var(--dark);
        }

        .Neon-input-icon {
            font-size: 50px;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .Neon-input-text h3 {
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--dark);
        }

        .Neon-input-text span {
            color: var(--gray);
            display: inline-block;
            margin: 15px 0;
        }

        .Neon-input-choose-btn {
            background: var(--primary);
            color: white;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            display: inline-block;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
        }

        .Neon-input-choose-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Gallery Grid */
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .gallery-item {
            position: relative;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .gallery-image {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
            display: block;
            cursor: pointer;
            transition: var(--transition);
        }

        .gallery-item:hover .gallery-image {
            transform: scale(1.05);
        }

        .actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 8px;
            opacity: 0;
            transition: var(--transition);
        }

        .gallery-item:hover .actions {
            opacity: 1;
        }

        .actions button {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: white;
            font-size: 14px;
        }

        .actions button.edit-btn {
            background: var(--warning);
        }

        .actions button.delete-btn {
            background: var(--danger);
        }

        .actions button:hover {
            transform: scale(1.1);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin: 30px 0 10px;
            gap: 8px;
        }

        .pagination a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: var(--border-radius);
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            border: 1px solid #ddd;
            transition: var(--transition);
        }

        .pagination a:hover {
            background: #F5F7FF;
            border-color: var(--primary);
        }

        .pagination a.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.85);
            overflow: auto;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            position: relative;
            margin: auto;
            display: block;
            max-width: 90%;
            max-height: 80vh;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 4px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        }

        .close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            z-index: 1001;
            transition: var(--transition);
        }

        .close:hover {
            color: var(--secondary);
        }

        .caption-container {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            color: white;
        }

        .ctrl {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 15px;
            cursor: pointer;
            font-size: 20px;
            transition: var(--transition);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ctrl:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .prev {
            left: 30px;
        }

        .next {
            right: 30px;
        }

        /* Edit Modal */
        #editModal .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 25px;
            width: 90%;
            max-width: 500px;
            border-radius: var(--border-radius);
            position: relative;
            transform: none;
            top: 0;
        }

        #editModal h2 {
            margin-bottom: 20px;
            color: var(--dark);
            font-weight: 600;
        }

        #editModal input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            font-size: 16px;
            transition: var(--transition);
        }

        #editModal input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(45, 91, 255, 0.1);
        }

        #editModal button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
        }

        #editModal button:hover {
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

        /* Responsive Design */
        @media (max-width: 992px) {
            .admin-main {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
            }
            
            .gallery {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
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
            
            .gallery {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 15px;
            }
            
            .Neon {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .gallery {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .pagination a {
                width: 35px;
                height: 35px;
            }
            
            .main {
                padding: 15px;
            }
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
                        <a href="#" class="active"><li><i class="fa fa-image"></i> Gallery</li></a>
                        <a href="projects.php"><li><i class="fa fa-project-diagram"></i> Projects</li></a>
                        <a href="videos.php"><li><i class="fa fa-video"></i> Videos</li></a>
                        <a href="applications.php"><li><i class="fa fa-user-check"></i>Scholarship Applications</li></a>
                        <a href="volunteers.php"><li><i class="fa fa-hands-helping"></i> Volunteers</li></a>
                        <a href="blog.php"><li><i class="fa fa-blog"></i> Blog</li></a>
                        <a href="banner-imgs.php"><li><i class="fa fa-images"></i> Banner Images</li></a>
                        <a href="logout.php" class="logout"><li><i class="fa fa-sign-out"></i> Logout</li></a>
                    </ul>
                </nav>
            </div>
            
            <div class="main">
                <h1><i class="fa fa-image"></i> Gallery Management</h1>
                
                <div class="Neon Neon-theme-dragdropbox">
                    <input
                        style="
                            z-index: 999;
                            opacity: 0;
                            width: 100%;
                            height: 100%;
                            position: absolute;
                            top: 0;
                            left: 0;
                            cursor: pointer;
                        "
                        name="files[]"
                        id="filer_input2"
                        multiple="multiple"
                        type="file"
                    />
                    <div class="Neon-input-dragDrop">
                        <div class="Neon-input-inner">
                            <div class="Neon-input-icon">
                                <i class="fa fa-cloud-upload-alt"></i>
                            </div>
                            <div class="Neon-input-text">
                                <h3>Drag & Drop files here</h3>
                                <span>or</span>
                            </div>
                            <a class="Neon-input-choose-btn blue">Browse Files</a>
                        </div>
                    </div>
                </div>
                
                <div id="gallery" class="gallery"></div>
                
                <div id="pagination" class="pagination"></div>
                
                <div id="editModal" class="modal">
                    <div class="modal-content">
                        <span class="close" id="editClose">&times;</span>
                        <h2>Edit Image Alt Text</h2>
                        <input type="hidden" id="editId">
                        <input type="text" id="altText" placeholder="Enter alt text for accessibility">
                        <button id="saveAlt">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="modal" class="modal">
            <span class="close" id="close">&times;</span>
            <img class="modal-content" id="modal-img" alt="Enlarged view">
            <div class="caption-container">
                <button class="prev ctrl" id="prev">&lsaquo;</button>
                <button class="next ctrl" id="next">&rsaquo;</button>
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

        $(document).ready(function () {
            $("#filer_input2").change(function () {
                const files = $("#filer_input2")[0].files;
                
                if (files.length > 0) {
                    const formData = new FormData();
                    
                    for (let i = 0; i < files.length; i++) {
                        formData.append("files[]", files[i]);
                    }

                    $.ajax({
                        url: "upload.php",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            showNotification("Images uploaded successfully!", "success");
                            loadGallery(); // Reload gallery to show new images
                        },
                        error: function () {
                            showNotification("Error uploading files.", "error");
                        }
                    });
                }
            });
        });

        function loadGallery(page = 1) {
            $.ajax({
                url: "../get-img.php",
                type: "GET",
                data: { page: page },
                dataType: "json",
                success: function (response) {
                    const gallery = $("#gallery");
                    gallery.empty(); // Clear old images
                    
                    if (response.images.length === 0) {
                        gallery.html('<div class="no-images" style="grid-column: 1/-1; text-align: center; padding: 40px; color: #888;"><i class="fa fa-image" style="font-size: 50px; margin-bottom: 15px;"></i><h3>No images found</h3><p>Upload some images to get started</p></div>');
                        $("#pagination").empty();
                        return;
                    }
                    
                    $.each(response.images, function(index, image) {
                        const imgContainer = $("<div>").addClass("gallery-item");
                        const img = $("<img>").attr("src", "../" + image.file_path)
                                            .addClass("gallery-image")
                                            .attr("alt", image.alt_text);
                        const actions = $("<div>").addClass("actions");
                        const editBtn = $("<button>").html('<i class="fa fa-edit"></i>').addClass("edit-btn")
                                            .attr("data-id", image.id).attr("data-alt", image.alt_text || '');
                        const deleteBtn = $("<button>").html('<i class="fa fa-trash"></i>').addClass("delete-btn")
                                            .attr("data-id", image.id);

                        actions.append(editBtn).append(deleteBtn);
                        imgContainer.append(img).append(actions);
                        gallery.append(imgContainer);
                    });

                    setupPagination(response.totalPages, page);
                },
                error: function () {
                    showNotification("Error loading images.", "error");
                }
            });
        }

        function setupPagination(totalPages, currentPage) {
            const pagination = $("#pagination");
            pagination.empty();

            if (totalPages <= 1) return;

            // Previous button
            if (currentPage > 1) {
                const prevLink = $("<a>").attr("href", "#").html('&laquo;');
                prevLink.on("click", function (e) {
                    e.preventDefault();
                    loadGallery(currentPage - 1);
                });
                pagination.append(prevLink);
            }

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                const link = $("<a>").attr("href", "#").text(i);
                if (i === currentPage) {
                    link.addClass("active");
                }
                link.on("click", function (e) {
                    e.preventDefault();
                    loadGallery(i);
                });
                pagination.append(link);
            }

            // Next button
            if (currentPage < totalPages) {
                const nextLink = $("<a>").attr("href", "#").html('&raquo;');
                nextLink.on("click", function (e) {
                    e.preventDefault();
                    loadGallery(currentPage + 1);
                });
                pagination.append(nextLink);
            }
        }

        // Load images when page loads
        $(document).ready(function() {
            loadGallery(1);
        });

        // Handle delete button click
        $("#gallery").on("click", ".delete-btn", function() {
            const id = $(this).data("id");
            if (confirm("Are you sure you want to delete this image? This action cannot be undone.")) {
                $.ajax({
                    url: "delete-img.php",
                    type: "POST",
                    data: { id: id },
                    success: function(response) {
                        showNotification("Image deleted successfully.", "success");
                        loadGallery(1);
                    },
                    error: function() {
                        showNotification("Error deleting image.", "error");
                    }
                });
            }
        });

        // Handle edit button click
        $("#gallery").on("click", ".edit-btn", function() {
            const id = $(this).data("id");
            const alt = $(this).data("alt");
            $("#editId").val(id);
            $("#altText").val(alt);
            $("#editModal").show();
        });

        // Handle save alt text button click
        $("#saveAlt").on("click", function() {
            const id = $("#editId").val();
            const alt = $("#altText").val();
            $.ajax({
                url: "update-alt.php",
                type: "POST",
                data: { id: id, alt: alt },
                success: function(response) {
                    showNotification("Alt text updated successfully.", "success");
                    $("#editModal").hide();
                    loadGallery(1);
                },
                error: function() {
                    showNotification("Error updating alt text.", "error");
                }
            });
        });

        // Close the edit modal
        $("#editClose").on("click", function() {
            $("#editModal").hide();
        });

        // Image modal functionality
        $(document).ready(function () {
            let currentIndex = 0;
            const modal = $("#modal");
            const modalImg = $("#modal-img");
            const closeBtn = $("#close");
            const prevBtn = $("#prev");
            const nextBtn = $("#next");

            // Open the modal when an image is clicked
            $("#gallery").on("click", ".gallery-image", function() {
                currentIndex = $(".gallery-image").index(this);
                modal.show();
                modalImg.attr("src", $(this).attr("src"));
            });

            // Close the modal when the "x" button is clicked
            closeBtn.on("click", function() {
                modal.hide();
            });

            // Navigate to the next image
            nextBtn.on("click", function() {
                currentIndex = (currentIndex + 1) % $(".gallery-image").length;
                modalImg.attr("src", $(".gallery-image").eq(currentIndex).attr("src"));
            });

            // Navigate to the previous image
            prevBtn.on("click", function() {
                currentIndex = (currentIndex - 1 + $(".gallery-image").length) % $(".gallery-image").length;
                modalImg.attr("src", $(".gallery-image").eq(currentIndex).attr("src"));
            });

            // Close the modal if the user clicks outside the image
            $(window).on("click", function(event) {
                if ($(event.target).is(modal)) {
                    modal.hide();
                }
            });

            // Keyboard navigation
            $(document).on('keydown', function(e) {
                if (modal.is(":visible")) {
                    if (e.key === "ArrowLeft") {
                        prevBtn.click();
                    } else if (e.key === "ArrowRight") {
                        nextBtn.click();
                    } else if (e.key === "Escape") {
                        modal.hide();
                    }
                }
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