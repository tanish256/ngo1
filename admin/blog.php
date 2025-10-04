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
    <title>Hayatu Charity Foundation - Admin Blog</title>
    <link rel="shortcut icon" href="../images/hayatu.svg" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
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

        /* Add Blog Button */
        .add-blog-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: var(--border-radius);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .add-blog-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Blog Grid */
        .blog {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .blog .card {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            background: white;
            display: flex;
            flex-direction: column;
        }

        .blog .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .blog .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .blog .card-content {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .blog .card h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: var(--dark);
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .blog .card p {
            color: var(--gray);
            font-size: 14px;
            margin-bottom: 15px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            flex-grow: 1;
        }

        .blog .card-actions {
            display: flex;
            gap: 10px;
        }

        .blog .card-actions button {
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

        .blog .card-actions .edit-btn {
            background: var(--warning);
            color: white;
        }

        .blog .card-actions .delete-btn {
            background: var(--danger);
            color: white;
        }

        .blog .card-actions button:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        /* Modal Styles */
        .story_wrapper, .story_wrapper2 {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-y: auto;
        }

        .Story_Layout {
            background: white;
            border-radius: var(--border-radius);
            width: 100%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 25px;
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
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

        .form-input {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: var(--transition);
        }

        .form-input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(45, 91, 255, 0.1);
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
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: var(--primary-dark);
        }

        .delete-btn-form {
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

        .delete-btn-form:hover {
            background: #d33;
        }

        .image-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .image-preview img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: var(--border-radius);
            border: 1px solid #ddd;
        }

        /* Quill Editor Styling */
        .ql-toolbar.ql-snow {
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            border: 1px solid #ddd;
        }

        .ql-container.ql-snow {
            border-radius: 0 0 var(--border-radius) var(--border-radius);
            border: 1px solid #ddd;
            min-height: 200px;
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
            
            .blog {
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
            
            .blog {
                grid-template-columns: 1fr;
            }
            
            .Story_Layout {
                padding: 15px;
            }
        }

        @media (max-width: 576px) {
            .main {
                padding: 15px;
            }
            
            .blog .card-actions {
                flex-direction: column;
            }
            
            .blog .card-actions button {
                width: 100%;
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
                        <a href="#" class="active"><li><i class="fa fa-blog"></i> Blog</li></a>
                        <a href="banner-imgs.php"><li><i class="fa fa-images"></i> Banner Images</li></a>
                        <a href="logout.php" class="logout"><li><i class="fa fa-sign-out"></i> Logout</li></a>
                    </ul>
                </nav>
            </div>
            
            <div class="main">
                <h1><i class="fa fa-blog"></i> Blog Management</h1>
                
                <button class="add-blog-btn" onclick="showAddForm()">
                    <i class="fa fa-plus"></i> Add New Blog Post
                </button>
                
                <div class="blog" id="blog-container">
                    <!-- Blog posts will be loaded here -->
                </div>
            </div>
        </div>
        
        <!-- Add Blog Form Modal -->
        <div class="story_wrapper" id="addFormModal">
            <div class="Story_Layout">
                <button class="close-modal" onclick="closeAddForm()">&times;</button>
                <h2>Add New Blog Post</h2>
                <form id="AddStory" class="story-form" enctype="multipart/form-data">
                    <input type="text" name="title" placeholder="Blog Title" required class="form-input">
                    <label>Main Image:</label>
                    <input type="file" name="image" class="form-input" accept="image/*" required>
                    <label>Additional Images (up to 6):</label>
                    <input type="file" name="images[]" class="form-input" multiple accept="image/*" data-max-files="6">
                    <div id="editor"></div>
                    <button type="submit" class="submit-btn">Create Post</button>
                </form>
            </div>
        </div>
        
        <!-- Edit Blog Form Modal -->
        <div class="story_wrapper2" id="editFormModal">
            <div class="Story_Layout">
                <button class="close-modal" onclick="closeEditForm()">&times;</button>
                <h2>Edit Blog Post</h2>
                <form id="EditStory" class="story-form" enctype="multipart/form-data">
                    <input type="hidden" id="editId" name="id">
                    <input type="text" id="editTitle" name="title" placeholder="Blog Title" required class="form-input">
                    
                    <label>Current Main Image:</label>
                    <div id="current-main-image" class="image-preview"></div>
                    <label>Change Main Image:</label>
                    <input type="file" name="image" class="form-input" accept="image/*">
                    
                    <label>Current Additional Images:</label>
                    <div id="current-additional-images" class="image-preview"></div>
                    <label>Add More Images (up to 6):</label>
                    <input type="file" name="images[]" class="form-input" multiple accept="image/*" data-max-files="6">
                    
                    <div id="editor2"></div>
                    <button type="submit" class="submit-btn">Update Post</button>
                    <button type="button" id="deletePost" class="delete-btn-form">Delete Post</button>
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
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        // Initialize Quill editors
        const Font = Quill.import('formats/font');
        Font.whitelist = ['mirza', 'roboto'];
        Quill.register(Font, true);
        
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ header: [1, 2, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            },
            placeholder: 'Write your blog content here...'
        });
        
        var quill2 = new Quill('#editor2', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ header: [1, 2, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            },
            placeholder: 'Write your blog content here...'
        });

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
        function showAddForm() {
            $('#addFormModal').css('display', 'flex');
        }

        function closeAddForm() {
            $('#addFormModal').css('display', 'none');
            $('#AddStory')[0].reset();
            quill.setText('');
        }

        function showEditForm() {
            $('#editFormModal').css('display', 'flex');
        }

        function closeEditForm() {
            $('#editFormModal').css('display', 'none');
        }

        // Close modals when clicking outside
        $(document).on('click', function(event) {
            if ($(event.target).hasClass('story_wrapper')) {
                closeAddForm();
            }
            if ($(event.target).hasClass('story_wrapper2')) {
                closeEditForm();
            }
        });

        // Fetch blog posts
        async function fetchPosts() {
            try {
                let response = await fetch("../get_blogs.php");
                let data = await response.json();
                let blogContainer = document.getElementById('blog-container');
                blogContainer.innerHTML = '';
                
                if (data.blogs && data.blogs.length > 0) {
                    data.blogs.forEach(blog => {
                        let blogHtml = `
                            <div class="card">
                                <img src="../${blog.banner_img}" alt="${blog.title}">
                                <div class="card-content">
                                    <h3>${blog.title}</h3>
                                    <p>${stripHtmlTags(blog.content.substring(0, 150))}...</p>
                                    <div class="card-actions">
                                        <button class="edit-btn" onclick="editBlog(${blog.id})">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                        <button class="delete-btn" onclick="deleteBlog(${blog.id})">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>`;
                        blogContainer.innerHTML += blogHtml;
                    });
                } else {
                    blogContainer.innerHTML = `
                        <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #888;">
                            <i class="fa fa-blog" style="font-size: 50px; margin-bottom: 15px;"></i>
                            <h3>No blog posts found</h3>
                            <p>Create your first blog post to get started</p>
                        </div>`;
                }
            } catch (error) {
                console.error("Error fetching blog posts:", error);
                showNotification("Error loading blog posts", "error");
            }
        }

        // Strip HTML tags for preview
        function stripHtmlTags(html) {
            let tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        }

        // Add new blog post
        document.getElementById('AddStory').addEventListener('submit', async function(event) {
            event.preventDefault();
            
            let formData = new FormData(this);
            formData.append('content', quill.root.innerHTML);
            
            try {
                let response = await fetch("../create-story.php", {
                    method: "POST",
                    body: formData
                });
                
                let result = await response.json();
                
                if (result.success) {
                    showNotification("Blog post created successfully!", "success");
                    closeAddForm();
                    fetchPosts();
                } else {
                    showNotification(result.error || "Error creating blog post", "error");
                }
            } catch (error) {
                console.error("Error saving blog post:", error);
                showNotification("Error creating blog post", "error");
            }
        });

        // Edit blog post
        async function editBlog(blogId) {
            try {
                let response = await fetch(`../get_blogs.php?id=${blogId}`);
                let blog = await response.json();
                
                if (blog.error) {
                    showNotification(blog.error, "error");
                    return;
                }
                
                // Populate the edit form
                document.getElementById('editId').value = blog.id;
                document.getElementById('editTitle').value = blog.title;
                quill2.root.innerHTML = blog.content;
                
                // Display current main image
                let currentMainImage = document.getElementById('current-main-image');
                currentMainImage.innerHTML = '';
                if (blog.banner_img) {
                    let img = document.createElement('img');
                    img.src = `../${blog.banner_img}`;
                    img.alt = "Current main image";
                    currentMainImage.appendChild(img);
                }
                
                // Display current additional images
                let currentAdditionalImages = document.getElementById('current-additional-images');
                currentAdditionalImages.innerHTML = '';
                
                if (blog.image_1) {
                    try {
                        let additionalImages = JSON.parse(blog.image_1);
                        if (Array.isArray(additionalImages)) {
                            additionalImages.forEach(imgPath => {
                                let img = document.createElement('img');
                                img.src = `../${imgPath}`;
                                img.alt = "Additional image";
                                currentAdditionalImages.appendChild(img);
                            });
                        }
                    } catch (e) {
                        console.error("Error parsing additional images JSON:", e);
                    }
                }
                
                // Set up delete button
                document.getElementById('deletePost').onclick = function() {
                    if (confirm("Are you sure you want to delete this blog post?")) {
                        deleteBlog(blog.id);
                    }
                };
                
                // Show the edit form
                showEditForm();
            } catch (error) {
                console.error("Error fetching blog details:", error);
                showNotification("Error loading blog details", "error");
            }
        }

        // Update blog post
        document.getElementById('EditStory').addEventListener('submit', async function(event) {
            event.preventDefault();
            
            let formData = new FormData(this);
            formData.append('content', quill2.root.innerHTML);
            
            try {
                let response = await fetch("../create-story.php", {
                    method: "POST",
                    body: formData
                });
                
                let result = await response.json();
                
                if (result.success) {
                    showNotification("Blog post updated successfully!", "success");
                    closeEditForm();
                    fetchPosts();
                } else {
                    showNotification(result.error || "Error updating blog post", "error");
                }
            } catch (error) {
                console.error("Error updating blog post:", error);
                showNotification("Error updating blog post", "error");
            }
        });

        // Delete blog post
        async function deleteBlog(blogId) {
            if (!confirm("Are you sure you want to delete this blog post? This action cannot be undone.")) {
                return;
            }
            
            try {
                let response = await fetch("../create-story.php", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `delete=${blogId}`
                });
                
                let result = await response.text();
                
                if (result.includes("success") || result.includes("deleted")) {
                    showNotification("Blog post deleted successfully!", "success");
                    closeEditForm();
                    fetchPosts();
                } else {
                    showNotification("Error deleting blog post", "error");
                }
            } catch (error) {
                console.error("Error deleting blog post:", error);
                showNotification("Error deleting blog post", "error");
            }
        }

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

        // Initialize page
        $(document).ready(function() {
            fetchPosts();
        });
    </script>
</body>
</html>