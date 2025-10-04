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
<title>Hayatu Charity Foundation - Volunteers</title>
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

        /* Volunteer Grid */
        .volunteer {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .volunteer .card {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            background: white;
            display: flex;
            flex-direction: column;
        }

        .volunteer .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .volunteer .card-content {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .volunteer .card h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: var(--dark);
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .volunteer .card p {
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

        .volunteer .card-actions {
            display: flex;
            gap: 10px;
        }

        .volunteer .card-actions button {
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

        .volunteer .card-actions .view-btn {
            background: var(--primary);
            color: white;
        }

        .volunteer .card-actions .delete-btn {
            background: var(--danger);
            color: white;
        }

        .volunteer .card-actions button:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        /* Modal Styles for Volunteer Details */
        .volunteer_modal_wrapper {
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

        .Volunteer_Layout {
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

        .Volunteer_Layout h2 {
            margin-bottom: 20px;
            color: var(--primary);
            text-align: center;
        }

        /* Two-column layout for details */
        #volunteerDetails {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 15px 30px; /* vertical gap, horizontal gap */
            margin-top: 10px;
        }

        #volunteerDetails p {
            margin: 0;
            font-size: 14px;
            color: var(--dark);
            word-wrap: break-word;
        }

        /* Action buttons at bottom */
        .Volunteer_Layout .action-btns {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .Volunteer_Layout .action-btns button {
            flex: 1;
            padding: 12px 0;
            border-radius: var(--border-radius);
            font-weight: 600;
            cursor: pointer;
            border:none;
            color:white;
            transition: var(--transition);
        }

        .Volunteer_Layout .delete-btn { 
            background: var(--danger); 
        }

        .Volunteer_Layout .delete-btn:hover { 
            opacity:0.9; 
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
            
            .volunteer {
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
            
            .volunteer {
                grid-template-columns: 1fr;
            }
            
            .Volunteer_Layout {
                padding: 15px;
            }
        }

        @media (max-width: 576px) {
            .main {
                padding: 15px;
            }
            
            .volunteer .card-actions {
                flex-direction: column;
            }
            
            .volunteer .card-actions button {
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
                    <a href="volunteers.php" class="active"><li><i class="fa fa-hands-helping"></i> Volunteers</li></a>
                    <a href="blog.php"><li><i class="fa fa-blog"></i> Blog</li></a>
                    <a href="banner-imgs.php"><li><i class="fa fa-images"></i> Banner Images</li></a>
                    <a href="logout.php" class="logout"><li><i class="fa fa-sign-out"></i> Logout</li></a>
                </ul>
            </nav>
        </div>

        <div class="main">
            <h1><i class="fa fa-hands-helping"></i> Volunteers</h1>
            <div class="volunteer" id="volunteers-container">
                <!-- Volunteers will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Volunteer Detail Modal -->
<div class="volunteer_modal_wrapper" id="volunteerModal">
    <div class="Volunteer_Layout">
        <button class="close-modal" onclick="closeVolunteerModal()">&times;</button>
        <h2 id="volunteerName">Volunteer Name</h2>
        <p><strong>Email:</strong> <span id="volunteerEmail"></span></p>
        <p><strong>Phone:</strong> <span id="volunteerPhone"></span></p>
        <p><strong>Submitted on:</strong> <span id="volunteerDate"></span></p>
        <p><strong>Details:</strong></p>
        <div id="volunteerDetails"></div>
        <div class="action-btns">
            <button class="delete-btn" id="deleteBtn">Delete Volunteer</button>
        </div>
    </div>
</div>

<div id="notification" class="notification">
    <i class="fas fa-check-circle"></i>
    <span id="notification-text"></span>
</div>

<script src="../js/jquery.min.js"></script>
<script>
    let selectedVolunteerId = null;

    async function fetchVolunteers() {
        try {
            let response = await fetch("../get_volunteers.php");
            let data = await response.json();
            let container = document.getElementById('volunteers-container');
            container.innerHTML = '';

            if (data.volunteers && data.volunteers.length > 0) {
                data.volunteers.forEach(volunteer => {
                    let card = document.createElement('div');
                    card.className = 'card';
                    card.innerHTML = `
                        <div class="card-content">
                            <h3>${volunteer.first_name} ${volunteer.last_name}</h3>
                            <p><strong>Email:</strong> ${volunteer.email}</p>
                            <p><strong>Phone:</strong> ${volunteer.phone}</p>
                            <p><strong>Areas of Interest:</strong> ${volunteer.areas_of_interest ? volunteer.areas_of_interest.substring(0, 50) + '...' : 'Not specified'}</p>
                            <p><strong>Availability:</strong> ${volunteer.availability || 'Not specified'}</p>
                            <div class="card-actions">
                                <button class="view-btn" onclick="openVolunteerModal(${volunteer.id})"><i class="fa fa-eye"></i> View</button>
                                <button class="delete-btn" onclick="deleteVolunteer(${volunteer.id})"><i class="fa fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    `;
                    container.appendChild(card);
                });

            } else {
                container.innerHTML = `<div style="grid-column: 1/-1; text-align:center; padding:40px; color:#888;">
                    <i class="fa fa-hands-helping" style="font-size:50px; margin-bottom:15px;"></i>
                    <h3>No volunteers found</h3>
                    <p>Check back later or refresh the page</p>
                </div>`;
            }
        } catch (error) {
            console.error("Error fetching volunteers:", error);
            showNotification("Error loading volunteers", "error");
        }
    }

    async function openVolunteerModal(id) {
        try {
            let response = await fetch(`../get_volunteers.php?id=${id}`);
            let data = await response.json();
            if (data.error) { showNotification(data.error, 'error'); return; }

            let volunteer = data.volunteer;

            selectedVolunteerId = volunteer.id;
            document.getElementById('volunteerName').textContent = `${volunteer.first_name} ${volunteer.last_name}`;
            document.getElementById('volunteerEmail').textContent = volunteer.email;
            document.getElementById('volunteerPhone').textContent = volunteer.phone || '-';
            document.getElementById('volunteerDate').textContent = volunteer.created_at;
            
            document.getElementById('volunteerDetails').innerHTML = `
                <p><strong>First Name:</strong> ${volunteer.first_name}</p>
                <p><strong>Last Name:</strong> ${volunteer.last_name}</p>
                <p><strong>Email:</strong> ${volunteer.email}</p>
                <p><strong>Phone:</strong> ${volunteer.phone || '-'}</p>
                <p><strong>Areas of Interest:</strong> ${volunteer.areas_of_interest || '-'}</p>
                <p><strong>Availability:</strong> ${volunteer.availability || '-'}</p>
                <p><strong>Motivation:</strong> ${volunteer.motivation || '-'}</p>
                <p><strong>Terms Accepted:</strong> ${volunteer.terms_accepted ? 'Yes' : 'No'}</p>
            `;

            document.getElementById('volunteerModal').style.display = 'flex';
        } catch (error) {
            console.error(error);
            showNotification("Error loading volunteer details", "error");
        }
    }

    function closeVolunteerModal() {
        selectedVolunteerId = null;
        document.getElementById('volunteerModal').style.display = 'none';
    }

    document.getElementById('deleteBtn').onclick = () => { deleteVolunteer(selectedVolunteerId); }

    async function deleteVolunteer(id) {
        if (!id) return;
        if (!confirm('Are you sure you want to delete this volunteer?')) return;

        try {
            let response = await fetch("../delete_volunteer.php", {
                method: "POST",
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body: `id=${id}`
            });
            let result = await response.json();
            if (result.success) {
                showNotification("Volunteer deleted successfully!", "success");
                closeVolunteerModal();
                fetchVolunteers();
            } else {
                showNotification(result.error || "Error deleting volunteer", "error");
            }
        } catch (error) {
            console.error(error);
            showNotification("Error deleting volunteer", "error");
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
        fetchVolunteers();
    });
</script>
</body>
</html>