<?php
// Get the title slug from the URL
include_once 'config.php';
$titleSlug = $_GET['title'] ?? ''; // Get the slug from the URL (e.g., delicious_food)

// Fetch blog content from database (or an API) based on the slug
// You can replace this with your database query or API call
// $blogData = fetchBlogBySlug($titleSlug);
try {
    // Use a prepared statement to select the project with the given id
    $stmt = $pdo->prepare("
    SELECT * FROM posts WHERE LOWER(REPLACE(REPLACE(title, '', ''), ' ', '-')) = ? ORDER BY date_edited DESC");
    $stmt->execute([strtolower($titleSlug)]); // Search for the title with spaces replaced by hyphens
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$blog) {
        echo json_encode($blog);
        
    }
    
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}

if (!$blog) {
    echo "<p>Blog not found.</p>";
    //echo $blog;
    //exit;
}

// Display the blog content
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hayatu Charity Foundation</title>
    <link rel="shortcut icon" href="../images/ico.png" type="image/x-icon" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter&family=Jomhuria&family=Kaushan+Script&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../css/style.css" />
  </head>
  <body>
    <style>
      li{
        list-style-type: none;
      }
        header{
            height: 80px;
            background: white !important;
            nav{
                height: 100%;
                background-color: white;
                ul{
                    a{
                    color: black;
                    font-weight: normal;
                    text-decoration: none;
                }
                }
                svg{
                path{
                        stroke: black;
                }
            }
            }
        }
        .ss{
            flex-direction: row-reverse;
            .img{
                width: 45%;
            }
            .info{
                width: 33%;
            }
        }
        section.causes{
           padding-inline: 0;
           margin-inline:0 ;
           width: 90%;
            h2,p.cause{
                margin-inline: 0;
                text-align: center;
                width: 100%;
            }
        }
    </style>
    <div class="root">
      <header>
        <nav class="container">
          <div class="logo"><img src="../images/hayatu2.svg" alt="" /></div>
          <ul id="menuk">
            <a href="../index.html"><li>Home</li></a>
            <a href="../projects.html"><li>Projects</li></a>
            <a href="../stories.html" class="live"><li>Our Stories</li></a>
            <a href="../gallery.html"><li>Gallery</li></a>
            <a href="../about.html"><li>About Us</li></a>
            <a href="../contact.html"><li>Contact</li></a>
            <div class="buttons l">
              <button onclick="window.location.href='../contact.html'">Volunteer</button>
              <button onclick="window.location.href='../donation.html'">Donate</button>
            </div>
          </ul>
          <svg id="menul" xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 200 200">
            <g stroke-width="6.5" stroke-linecap="round">
              <path
                d="M72 82.286h28.75"
                fill="#009100"
                fill-rule="evenodd"
                stroke="#fff"
              />
              <path
                d="M100.75 103.714l72.482-.143c.043 39.398-32.284 71.434-72.16 71.434-39.878 0-72.204-32.036-72.204-71.554"
                fill="none"
                stroke="#fff"
              />
              <path
                d="M72 125.143h28.75"
                fill="#009100"
                fill-rule="evenodd"
                stroke="#fff"
              />
              <path
                d="M100.75 103.714l-71.908-.143c.026-39.638 32.352-71.674 72.23-71.674 39.876 0 72.203 32.036 72.203 71.554"
                fill="none"
                stroke="#fff"
              />
              <path
                d="M100.75 82.286h28.75"
                fill="#009100"
                fill-rule="evenodd"
                stroke="#fff"
              />
              <path
                d="M100.75 125.143h28.75"
                fill="#009100"
                fill-rule="evenodd"
                stroke="#fff"
              />
            </g>
          </svg>
          <div class="buttons">
            <button onclick="window.location.href='../contact.html'">Volunteer</button>
            <button onclick="window.location.href='../donation.html'">Donate</button>
          </div>
        </nav>
      </header>
      <section class="adv">
        <p>A small donation can be a life changing moment for someone Donate to change someones life</p>
      </section>
      <section class="blog">

        <div class="blog1"> 
            <h2 class="head"><?php echo $blog['title'] ?>
            </h2>
            <img src="../<?php echo $blog['banner_img'] ?>" alt="" class="head">
            <style>
                p{
                    margin:2px 0;
                }
                .additional-images {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 10px;
                    margin-top: 20px;
                }
                .additional-images img {
                    width: 100%;
                    height: auto;
                    object-fit: cover;
                }
            </style>
            <?php echo $blog['content'] ?>
            <div class="head grid">
                <?php 
                if (!empty($blog['image_1'])) {
                    $additional_images = json_decode($blog['image_1'], true);
                    if (is_array($additional_images)) {
                        foreach ($additional_images as $img_path) {
                            echo '<img src="../' . $img_path . '" alt="Additional Image" class="gallery-image">';
                        }
                    }
                }
                ?>
            </div>
        </div>


      </section>

      <section class="b4footer">
        <h2>
          HAYATU CHARITY FOUNDATION IS AN ORGANIZATION AIMED AT HELPING AND
          PROMOTING CHILDREN AROUND THE WORLD
        </h2>
        <div class="img">
          <img src="../images/rm2.jpg" alt="" />
        </div>
        <div class="donate-form">
          <div class="heads">
            <h4>HELP US</h4>
            <h3>DONATE NOW</h3>
          </div>
          <input type="text" placeholder="your email" />
          <input type="text" placeholder="your name" />
          <input type="text" placeholder="amount" />
          <input type="text" placeholder="message" />
          <button>Proceed</button>
        </div>
      </section>
      <footer>
        <nav>
          <div class="logo">
            <img src="../images/hayatu.svg" alt="" />
          </div>
          <ul>
            <a href="../index.html"><li>Home</li></a>
            <a href="../projects.html"><li>Projects</li></a>
            <a href="#" ><li>Our Stories</li></a>
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
            <i class="fab fa-twitter-square"></i>
          </a>
          <a href="https://www.facebook.com/profile.php?id=61566345901391" target="_blank">
            <i class="fa-brands fa-square-facebook"></i>
          </a>
        </div>
      </footer>
      <div id="modal" class="modal">
        <span class="close" id="close">&times;</span>
        <img class="modal-content" id="modal-img">
        <div class="caption-container">
          <button  class="prev ctrl" id="prev">&#10094;</button>
          <button class="next ctrl" id="next">&#10095;</button>
        </div>
      </div>
      <div class="copyright">
        <p>@copyright all rights reserved hayatucharityfoundation.com</p>
        <p>powered by <span class="blue">SCEC Technologies</span></p>
      </div>
    </div>
    <a href="https://api.whatsapp.com/send?phone=256706171731" class="float" target="_blank">
      <i class="fa-brands fa-whatsapp my-float"></i>
      </a>
    <button id="topBtn" onclick="scrollToTop()">&uarr;</button>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/script.js"></script>
  </body>
</html>