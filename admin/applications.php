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
<title>Hayatu Charity Foundation - Applications</title>
<link rel="shortcut icon" href="../images/hayatu.svg" type="image/x-icon" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
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
<style>
/* Reuse your CSS from the blog page */
/* Card layout */
.application .card-actions button {
    background: var(--primary);
    color: white;
    border: none;
}
.application .card-actions .reject-btn {
    background: var(--danger);
}

/* Modal Styles for Application Details */
.app_modal_wrapper {
    display: none;
    position: fixed;
    top:0; left:0; width:100%; height:100%;
    background: rgba(0,0,0,0.7);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    padding: 20px;
    overflow-y: auto;
}
.App_Layout {
    background: white;
    border-radius: var(--border-radius);
    width: 100%;
    max-width: 600px;
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
.close-modal:hover { color: var(--danger); }
.App_Layout h2 { margin-bottom: 20px; color: var(--primary); }
.App_Layout p { margin-bottom: 10px; color: var(--dark); }
.App_Layout .action-btns { display: flex; gap: 10px; margin-top: 20px; }
.App_Layout .action-btns button {
    flex: 1; padding: 10px; border-radius: var(--border-radius); font-weight: 600; cursor: pointer; border:none; color:white; transition: var(--transition);
}
.App_Layout .approve-btn { background: var(--success); }
.App_Layout .reject-btn { background: var(--danger); }
.App_Layout .approve-btn:hover { opacity:0.9; }
.App_Layout .reject-btn:hover { opacity:0.9; }
.application{
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.application .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    padding: 15px;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
    border-radius: var(--border-radius);
    
}
.application .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 25px rgba(0,0,0,0.15);
}
.application .card-actions button {
    background: var(--primary);
    color: white;
    border-radius: var(--border-radius);
    padding: 8px 12px;
    font-weight: 600;
}
.application .card-actions button:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

/* Modal Styles for Application Details */
.app_modal_wrapper {
    display: none;
    position: fixed;
    top:0; left:0; width:100%; height:100%;
    background: rgba(0,0,0,0.7);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    padding: 20px;
    overflow-y: auto;
}

.App_Layout {
    background: white;
    border-radius: var(--border-radius);
    width: 100%;
    max-width: 800px;
    max-height: 90vh;
    overflow-y: auto;
    padding: 25px;
    position: relative;
    box-shadow: 0 15px 25px rgba(0,0,0,0.2);
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

.App_Layout h2 {
    margin-bottom: 20px;
    color: var(--primary);
    text-align: center;
}

/* Two-column layout for details */
#appDetails {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 15px 30px; /* vertical gap, horizontal gap */
    margin-top: 10px;
}

#appDetails p {
    margin: 0;
    font-size: 14px;
    color: var(--dark);
    word-wrap: break-word;
}

#appDetails a {
    color: var(--primary);
    text-decoration: none;
}

#appDetails a:hover {
    text-decoration: underline;
}

/* Action buttons at bottom */
.App_Layout .action-btns {
    display: flex;
    gap: 15px;
    margin-top: 25px;
}

.App_Layout .action-btns button {
    flex: 1;
    padding: 12px 0;
    border-radius: var(--border-radius);
    font-weight: 600;
    cursor: pointer;
    border:none;
    color:white;
    transition: var(--transition);
}

.App_Layout .approve-btn { background: var(--success); }
.App_Layout .reject-btn { background: var(--danger); }

.App_Layout .approve-btn:hover, 
.App_Layout .reject-btn:hover { opacity:0.9; }

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
                    <a href="applications.php" class="active"><li><i class="fa fa-user-check"></i>Scholarship Applications</li></a>
                    <a href="volunteers.php"><li><i class="fa fa-hands-helping"></i> Volunteers</li></a>
                    <a href="blog.php"><li><i class="fa fa-blog"></i> Blog</li></a>
                    <a href="banner-imgs.php"><li><i class="fa fa-images"></i> Banner Images</li></a>
                    <a href="logout.php" class="logout"><li><i class="fa fa-sign-out"></i> Logout</li></a>
                </ul>
            </nav>
        </div>

        <div class="main">
            <h1><i class="fa fa-user-check"></i> Scholarship Applications</h1>
            <div class="application" id="applications-container">
                <!-- Applications will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Application Detail Modal -->
<div class="app_modal_wrapper" id="appModal">
    <div class="App_Layout">
        <button class="close-modal" onclick="closeAppModal()">&times;</button>
        <h2 id="appName">Applicant Name</h2>
        <p><strong>Email:</strong> <span id="appEmail"></span></p>
        <p><strong>Phone:</strong> <span id="appPhone"></span></p>
        <p><strong>Submitted on:</strong> <span id="appDate"></span></p>
        <p><strong>Details:</strong></p>
        <p id="appDetails"></p>
        <div class="action-btns">
            <button class="approve-btn" id="approveBtn">Approve</button>
            <button class="reject-btn" id="rejectBtn">Reject</button>
        </div>
    </div>
</div>

<div id="notification" class="notification">
    <i class="fas fa-check-circle"></i>
    <span id="notification-text"></span>
</div>

<script src="../js/jquery.min.js"></script>
<script>
    let selectedAppId = null;


async function fetchApplications() {
    try {
        let response = await fetch("../get_applications.php");
        let data = await response.json();
        let container = document.getElementById('applications-container');
        container.innerHTML = '';

        if (data.applications && data.applications.length > 0) {
            data.applications.forEach(app => {
                let statusColor = app.status === 'approved' ? 'var(--success)' :
                                app.status === 'rejected' ? 'var(--danger)' :
                                'var(--warning)';

                let card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <div class="card-content">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <h3>${app.first_name} ${app.last_name}</h3>
                            <span style="
                                padding: 4px 10px;
                                border-radius: 12px;
                                background:${statusColor};
                                color:white;
                                font-size:12px;
                                text-transform:capitalize;
                            ">${app.status || 'pending'}</span>
                        </div>
                        <p><strong>Email:</strong> ${app.email}</p>
                        <p><strong>Submitted on:</strong> ${new Date(app.created_at).toLocaleDateString()}</p>
                        <div class="card-actions">
                            <button onclick="openAppModal(${app.id})"><i class="fa fa-eye"></i> View</button>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });

        } else {
            container.innerHTML = `<div style="grid-column: 1/-1; text-align:center; padding:40px; color:#888;">
                <i class="fa fa-user-check" style="font-size:50px; margin-bottom:15px;"></i>
                <h3>No applications found</h3>
                <p>Check back later or refresh the page</p>
            </div>`;
        }
    } catch (error) {
        console.error("Error fetching applications:", error);
        showNotification("Error loading applications", "error");
    }
}

    async function openAppModal(id) {
        try {
            let response = await fetch(`../get_applications.php?id=${id}`);
            let data = await response.json();
            if (data.error) { showNotification(data.error, 'error'); return; }

            let app = data.application;

            selectedAppId = app.id;
            document.getElementById('appName').textContent = `${app.first_name} ${app.last_name}`;
            document.getElementById('appEmail').textContent = app.email;
            document.getElementById('appPhone').textContent = app.phone || '-';
            document.getElementById('appDate').textContent = app.created_at;
            // Handle documents array safely
            let docs = [];
            try {
                docs = JSON.parse(app.documents || '[]'); // Parse JSON array
            } catch(e) {
                console.error("Error parsing documents:", e);
            }

            // Generate links for each document
            let docsHTML = docs.length > 0
                ? docs.map(doc => `<a href="../uploads/${doc}" target="_blank">${doc}</a>`).join('<br/>')
                : '-';
            document.getElementById('appDetails').innerHTML = `
                <p><strong>First Name:</strong> ${app.first_name}</p>
                <p><strong>Last Name:</strong> ${app.last_name}</p>
                <p><strong>Email:</strong> ${app.email}</p>
                <p><strong>Phone:</strong> ${app.phone || '-'}</p>
                <p><strong>Date of Birth:</strong> ${app.date_of_birth || '-'}</p>
                <p><strong>Gender:</strong> ${app.gender || '-'}</p>
                <p><strong>Nationality:</strong> ${app.nationality || '-'}</p>
                <p><strong>Address:</strong> ${app.address || '-'}</p>
                <p><strong>Current Grade:</strong> ${app.current_grade || '-'}</p>
                <p><strong>School Name:</strong> ${app.school_name || '-'}</p>
                <p><strong>GPA:</strong> ${app.gpa || '-'}</p>
                <p><strong>Previous Grades:</strong> ${app.previous_grades || '-'}</p>
                <p><strong>Achievements:</strong> ${app.achievements || '-'}</p>
                <p><strong>Parent Name:</strong> ${app.parent_name || '-'}</p>
                <p><strong>Parent Occupation:</strong> ${app.parent_occupation || '-'}</p>
                <p><strong>Family Income:</strong> ${app.family_income || '-'}</p>
                <p><strong>Siblings:</strong> ${app.siblings || '-'}</p>
                <p><strong>Challenges:</strong> ${app.challenges || '-'}</p>
                <p><strong>Scholarship Type:</strong> ${app.scholarship_type || '-'}</p>
                <p><strong>Requested Amount:</strong> ${app.requested_amount || '-'}</p>
                <p><strong>Reason:</strong> ${app.reason || '-'}</p>
                <p><strong>Goals:</strong> ${app.goals || '-'}</p>
                <p><strong>Extracurriculars:</strong> ${app.extracurriculars || '-'}</p>
                <p><strong>Documents:</strong><br/>${docsHTML}</p>
                <p><strong>Terms Accepted:</strong> ${app.terms_accepted ? 'Yes' : 'No'}</p>
                <p><strong>Consent Given:</strong> ${app.consent_given ? 'Yes' : 'No'}</p>
            `;


            document.getElementById('appModal').style.display = 'flex';
        } catch (error) {
            console.error(error);
            showNotification("Error loading application details", "error");
        }
    }


    function closeAppModal() {
        selectedAppId = null;
        document.getElementById('appModal').style.display = 'none';
    }

document.getElementById('approveBtn').onclick = () => { processApplication('approve'); }
document.getElementById('rejectBtn').onclick = () => { processApplication('reject'); }

async function processApplication(action) {
    if (!selectedAppId) return;
    if (!confirm(`Are you sure you want to ${action} this application?`)) return;

    try {
        let response = await fetch("../process_application.php", {
            method: "POST",
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: `action=${action}&id=${selectedAppId}`
        });
        let result = await response.json();
        if (result.success) {
            showNotification(`Application ${action}d successfully!`, "success");
            closeAppModal();
            fetchApplications();
        } else {
            showNotification(result.error || `Error ${action}ing application`, "error");
        }
    } catch (error) {
        console.error(error);
        showNotification(`Error ${action}ing application`, "error");
    }
}


    function showNotification(message, type) {
        const notification = $('#notification');
        const notificationText = $('#notification-text');
        
        notificationText.text(message);
        notification.removeClass('success error').addClass(type).addClass('show');
        
        setTimeout(() => {
            notification.removeClass('show');
        }, 3000);
    }

    $(document).ready(function() {
        fetchApplications();
    });
</script>
</body>
</html>
