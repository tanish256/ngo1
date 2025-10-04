<?php
session_start();
if (isset($_SESSION['role'])) {
    header("Location: dashboard.php");
    exit;
}

require 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_name = :username");
        $stmt->execute(['username' => $inputUsername]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($inputPassword, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];

            // Regenerate session ID for security
            session_regenerate_id(true);
            
            if ($_SESSION['role'] == 'admin') {
                header("Location: index.php");
            } else {
                header("Location: ../index.html");
            }
            exit;
        } else {
            $error = "Invalid username or password!";
        }
    } catch (PDOException $e) {
        $error = "Database error: Please try again later.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hayatu Charity Foundation - Admin Login</title>
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
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #F5F7FF;
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('bg login.png');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            opacity: 0.1;
            z-index: -1;
        }

        .login-container {
            display: flex;
            width: 85%;
            max-width: 1000px;
            height: 550px;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            background: white;
        }

        .login-brand {
            flex: 1;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .login-brand::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .login-brand::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .brand-logo {
            margin-bottom: 30px;
            text-align: center;
            z-index: 1;
        }

        .brand-logo img {
            width: 180px;
            margin-bottom: 15px;
        }

        .brand-logo h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .brand-content {
            text-align: center;
            z-index: 1;
        }

        .brand-content p {
            font-size: 16px;
            opacity: 0.9;
            max-width: 300px;
        }

        .login-form {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: white;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h2 {
            font-size: 24px;
            color: var(--dark);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .form-header p {
            color: var(--gray);
            font-size: 14px;
        }

        .login-form form {
            width: 100%;
            max-width: 350px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 14px;
            transition: var(--transition);
        }

        .form-group input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(45, 91, 255, 0.1);
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 10px;
        }

        .login-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .error-message {
            background: rgba(234, 84, 85, 0.1);
            color: var(--danger);
            padding: 10px 15px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            font-size: 14px;
            display: <?php echo $error ? 'flex' : 'none'; ?>;
            align-items: center;
            gap: 10px;
        }

        .error-message i {
            font-size: 16px;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
                height: auto;
                width: 90%;
            }
            
            .login-brand {
                padding: 30px;
            }
            
            .login-form {
                padding: 30px;
            }
        }

        @media (max-width: 576px) {
            .login-container {
                width: 95%;
            }
            
            .login-brand, .login-form {
                padding: 20px;
            }
            
            .brand-logo img {
                width: 120px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-brand">
            <div class="brand-logo">
                <img src="../images/hayatu.svg" alt="Hayatu Charity Foundation">
                <h1>ADMIN PORTAL</h1>
            </div>
        </div>
        
        <div class="login-form">
            <div class="form-header">
                <h2>Welcome Back</h2>
                <p>Sign in to your admin account</p>
            </div>
            
            <?php if ($error): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo $error; ?></span>
            </div>
            <?php endif; ?>
            
            <form action="login.php" method="POST" autocomplete="off">
                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Username" required autocomplete="off">
                </div>
                
                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required autocomplete="off">
                </div>
                
                <button type="submit" class="login-btn">Sign In</button>
            </form>
        </div>
    </div>

    <script>
        // Simple form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const username = document.querySelector('input[name="username"]');
            const password = document.querySelector('input[name="password"]');
            
            if (!username.value.trim()) {
                e.preventDefault();
                username.focus();
                return false;
            }
            
            if (!password.value.trim()) {
                e.preventDefault();
                password.focus();
                return false;
            }
        });
    </script>
</body>
</html>