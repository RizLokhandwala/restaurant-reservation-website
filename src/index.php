<?php
    session_start();
    $userID = $_SESSION['user_ID'];
    if (isset($userID)) {
        $login = "My Account";
    }
    else {
        $login = "Login";
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Landing Page</title>
        <link rel="stylesheet" href="./styles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"> 
        
    </head>
    <body style="margin: 0;">
        <nav class="header container">
            <div class="left_box">
                <div class="logo">
                    <a href="./index.html"><img src="./media/logo.jpg"/></a>
                </div>
                <div class="header_links">
                    <a href="./menu.html">Menu </a>
                    <a href="./reservation.php">Reserve Table </a>
                    <a href="./locations.php">Find Restaurant </a>
                
                </div>
                
            </div>
            <div class="header_links right_box">
                <a href="./<?php echo $login ?>.php"><?php echo $login ?></a>
            </div>
            <div class="menu_dropdown">
                <button id="dropdown_button"><img class="icon" src="./media/kebab.jpg"></button>
            </div>
        </nav>
        <div class="video_layer">                
            <div class="top-video">
               <video id="home_video" preload="auto" autoplay="" playsinline="" muted="" poster="noposter" loop="true" src="./media/home_video.mp4">
                </video> 
            </div>
        </div>
        <div class="sign_up_layer">
            
            <div class="blank_space"></div>
            
            <div class="container">
                <p class="sign_up_text center">Sign Up for news, Offers, Rewards, and More!</p>
                <a href="./register.html"><button class="join_button">Join Now!</button></a>
            </div>
            
        </div>
      
        <div class="promotion">
            <a href="./reservation.php?date=2022-12-31"><img src="./media/happy_ny_banner.jpg" style="width:100%; height:auto;"></a>
        </div>
        
        <div class="more_blank_space"><!--IMPORTANT, KEEP AT BOTTOM OF BODY-->></div>

    </body> 
    <footer>
        <div class="about_layer container">
            <div class="footer_nav container">
                <div class="footer_nav_links"><a href="./reservation.php">Reserve Table</a></div>
                <div class="footer_nav_links"><a href="./about.html">About Us</a></div>
                <div class="footer_nav_links"><a href="contactUs.html">Contact Us</a></div>
                <div class="footer_nav_links"><a href="https://project4351.scm.azurewebsites.net/dev/wwwroot/">Source Code</a></div>
            </div>
        </div>

    </footer>
</html>