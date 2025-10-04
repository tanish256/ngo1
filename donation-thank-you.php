<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Successful - Hayatu Charity Foundation</title>
    <link rel="shortcut icon" href="images/ico.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/donation.css">
    <style>
        .thank-you-container {
            text-align: center;
            padding: 50px 20px;
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .thank-you-container h1 {
            color: #4CAF50;
            font-size: 2.5em;
        }
        .thank-you-container p {
            font-size: 1.2em;
            color: #555;
        }
        .back-to-home {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="root">
        <header>
            <img id="header_bg_img" class="bg" src="images/img4.webp" alt="" />
            <nav class="container">
                <div class="logo"><img src="images/hayatu.svg" alt="" /></div>
                <ul id="menuk">
                    <a href="index.html"><li>Home</li></a>
                    <a href="projects.html"><li>Projects</li></a>
                    <a href="stories.html"><li>Our Stories</li></a>
                    <a href="gallery.html"><li>Gallery</li></a>
                    <a href="about.html"><li>About Us</li></a>
                    <a href="contact.html"><li>Contact</li></a>
                </ul>
            </nav>
        </header>

        <div class="thank-you-container">
            <h1>Thank You for Your Donation!</h1>
            <p>Your generous contribution is greatly appreciated. You will receive a confirmation email shortly.</p>
            <p>Your support helps us continue our mission to make a difference.</p>
            <a href="index.html" class="back-to-home">Back to Home</a>
        </div>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> Hayatu Charity Foundation. All Rights Reserved.</p>
        </footer>
    </div>
</body>
</html>