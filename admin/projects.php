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
    <title>Hayatu Charity Foundation - Admin Projects</title>
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
            gap: 10px;
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

        /* Add Project Button */
        .add-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .add-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Projects Grid */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .project-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .project-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .project-content {
            padding: 20px;
        }

        .project-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--dark);
        }

        .project-description {
            color: var(--gray);
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .project-actions {
            display: flex;
            gap: 10px;
        }

        .project-actions button {
            padding: 8px 15px;
            border-radius: var(--border-radius);
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .edit-btn {
            background: var(--warning);
            color: white;
        }

        .edit-btn:hover {
            background: #FF8B23;
        }

        .delete-btn {
            background: var(--danger);
            color: white;
        }

        .delete-btn:hover {
            background: #E43132;
        }

        /* Modal Styles */
        .story_wrapper {
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
            justify-content: center;
            align-items: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .Story_Layout {
            background-color: white;
            padding: 30px;
            border-radius: var(--border-radius);
            width: 90%;
            max-width: 600px;
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
            color: var(--gray);
            transition: var(--transition);
        }

        .close-modal:hover {
            color: var(--danger);
        }

        .story-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-input, .form-textarea {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            transition: var(--transition);
        }

        .form-input:focus, .form-textarea:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(45, 91, 255, 0.1);
        }

        .form-textarea {
            min-height: 150px;
            resize: vertical;
        }

        .submit-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
        }

        .submit-btn:hover {
            background: var(--primary-dark);
        }

        #del_btn {
            background: var(--danger);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            margin-top: 10px;
        }

        #del_btn:hover {
            background: #E43132;
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
            
            .projects-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
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
            
            .projects-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .main {
                padding: 15px;
            }
            
            .Story_Layout {
                padding: 20px;
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
                        <a href="#" class="active"><li><i class="fa fa-project-diagram"></i> Projects</li></a>
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
                <h1><i class="fa fa-project-diagram"></i> Projects Management</h1>
                
                <button class="add-btn" onclick="addpj()"><i class="fa fa-plus"></i> Add New Project</button>
                
                <div class="projects-grid" id="projects-list"></div>
            </div>
        </div>
        
        <!-- Add Project Modal -->
        <div class="story_wrapper" id="add-project-modal">
            <div class="Story_Layout">
                <span class="close-modal" onclick="closeModal('add-project-modal')">&times;</span>
                <form id="AddProject" class="story-form">
                    <input id="title" type="text" name="title" placeholder="Project Title" required class="form-input">
                    <input id="image" type="file" name="image" class="form-input" required>
                    <textarea id="content" name="content" placeholder="Project Description" required class="form-textarea"></textarea>
                    <button type="submit" class="submit-btn">Create Project</button>
                </form>
            </div>
        </div>
        
        <!-- Edit Project Modal -->
        <div class="story_wrapper" id="edit-project-modal">
            <div class="Story_Layout">
                <span class="close-modal" onclick="closeModal('edit-project-modal')">&times;</span>
                <form id="AddProjecte" class="story-form">
                    <input type="hidden" name="id" id="eid">
                    <input id="etitle" type="text" name="title" placeholder="Project Title" required class="form-input">
                    <input id="eimage" type="file" name="image" class="form-input">
                    <textarea id="econtent" name="content" placeholder="Project Description" required class="form-textarea"></textarea>
                    <button type="submit" class="submit-btn">Update Project</button>
                    <button id="del_btn" type="button">Delete Project</button>
                </form>
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

        // Modal functions
        function addpj() {
            $('#add-project-modal').css("display", "flex");
        }

        function closeModal(modalId) {
            $('#' + modalId).css("display", "none");
            $('#' + modalId + ' form')[0].reset();
        }

        // Close modal when clicking outside content
        $('.story_wrapper').click(function(e) {
            if (e.target === this) {
                closeModal($(this).attr('id'));
            }
        });

        // Load projects when page loads
        $(document).ready(function() {
            loadProjects();
            
            // Scroll to top functionality
            window.onscroll = function() {
                const topBtn = document.getElementById("topBtn");
                if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                    topBtn.style.display = "block";
                } else {
                    topBtn.style.display = "none";
                }
            };
        });

        function loadProjects() {
            $.ajax({
                url: "../get-projets.php",
                type: "GET",
                success: function(response) {
                    const projectsList = $("#projects-list");
                    projectsList.empty();
                    
                    if (response.length === 0) {
                        projectsList.html(`
                            <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #888;">
                                <i class="fa fa-project-diagram" style="font-size: 50px; margin-bottom: 15px;"></i>
                                <h3>No projects found</h3>
                                <p>Add some projects to get started</p>
                            </div>
                        `);
                        return;
                    }
                    
                    response.forEach(function(project) {
                        const projectHtml = `
                            <div class="project-card">
                                <img src="../${project.image}" alt="${project.title}" class="project-image">
                                <div class="project-content">
                                    <h3 class="project-title">${project.title}</h3>
                                    <p class="project-description">${project.description}</p>
                                    <div class="project-actions">
                                        <button class="edit-btn" onclick="pedit(${project.id})">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                        <button class="delete-btn" onclick="deleteProject(${project.id})">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        projectsList.append(projectHtml);
                    });
                },
                error: function(xhr) {
                    showNotification("Error loading projects.", "error");
                    console.error("Error fetching projects:", xhr.responseText);
                }
            });
        }

        // Add project form submission
        $("#AddProject").on("submit", function(event) {
            event.preventDefault();
            
            let formData = new FormData(this);
            
            $.ajax({
                url: "../create-project.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    showNotification("Project created successfully!", "success");
                    closeModal('add-project-modal');
                    loadProjects();
                },
                error: function(xhr, status, error) {
                    showNotification("Error creating project.", "error");
                    console.error(error);
                }
            });
        });

        // Edit project form submission
        $("#AddProjecte").on("submit", function(event) {
            event.preventDefault();
            
            let formData = new FormData(this);
            
            $.ajax({
                url: "../create-project.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    showNotification("Project updated successfully!", "success");
                    closeModal('edit-project-modal');
                    loadProjects();
                },
                error: function(xhr, status, error) {
                    showNotification("Error updating project.", "error");
                    console.error(error);
                }
            });
        });

        // Delete project button
        $("#del_btn").on("click", function() {
            const id = $('#eid').val();
            
            if (confirm("Are you sure you want to delete this project? This action cannot be undone.")) {
                $.ajax({
                    url: "../create-project.php",
                    type: "POST",
                    data: { del: id },
                    success: function(response) {
                        showNotification("Project deleted successfully.", "success");
                        closeModal('edit-project-modal');
                        loadProjects();
                    },
                    error: function(xhr, status, error) {
                        showNotification("Error deleting project.", "error");
                        console.error(error);
                    }
                });
            }
        });

        // Edit project function
        function pedit(id) {
            $.ajax({
                url: '../get-projets.php',
                type: 'GET',
                data: { id: id },
                success: function(response) {
                    if (response.error) {
                        showNotification("Error loading project details.", "error");
                    } else {
                        $('#etitle').val(response[0].title);
                        $('#eid').val(response[0].id);
                        $('#econtent').val(response[0].description);
                        $('#edit-project-modal').css("display", "flex");
                    }
                },
                error: function(xhr, status, error) {
                    showNotification("Error loading project details.", "error");
                }
            });
        }

        // Delete project function
        function deleteProject(id) {
            if (confirm("Are you sure you want to delete this project? This action cannot be undone.")) {
                $.ajax({
                    url: "../create-project.php",
                    type: "POST",
                    data: { del: id },
                    success: function(response) {
                        showNotification("Project deleted successfully.", "success");
                        loadProjects();
                    },
                    error: function(xhr, status, error) {
                        showNotification("Error deleting project.", "error");
                        console.error(error);
                    }
                });
            }
        }

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>
</html>