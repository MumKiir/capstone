<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Red+Rose:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">

</head>
<body>
    
    
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
    
    <div class="container">
    <h1><span class="white-text">Crop</span><span class="blue-text">Guard</span></h1>
    <h2 class="mb-3">Sign Up</h2>
    <form method="post" id="loginForm">
        <div class="form-group">
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" class="form-control" placeholder="Email" required>
        </div>
        <div class="form-group">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" id="login_btn">Log in</button>
    </form>
    <p class="mb-3 text-center">
                <span class="grey-text">Don't have an account?</span>
                <a href="signup.html" class="blue-text">Sign Up</a>
            </p>  
    </div>

</body>
</html>







