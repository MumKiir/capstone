<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Red+Rose:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="container"> 
        <nav>
            <h2><span class="white-text">Crop</span><span class="blue-text">Guard</span></h2>
            <ul>
                <?php if (isset($user)): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.html">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </nav>  
        <div class="content">
            <h1>Welcome<br>To CropGuard</h1>
            <p>Where innovation meets practical solutions. 
                Our journey is rooted in a shared passion for addressing real-world challenges with 
                creative and effective technology</p>
                <a href="camera.html" class="stat">Click here to Start</a>

        </div> 
    </div>
</body>

</html>
    
    
    
    
    
    
    
    
    
    
    