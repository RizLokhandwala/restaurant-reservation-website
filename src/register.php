
<?php


?>

<?php



$port = $_SERVER['WEBSITE_MYSQL_PORT'];
$host = "localhost:$port";
$username = "azure";
$password = "6#vWHD_$";
$db_name = "4351project3";

//Initializes MySQLi
$mysqli = new mysqli($host,$username,$password,$db_name);

if($mysqli->connect_errno){
    echo"Failed to connect to MySQL: ". $mysqli->connect_error;
    exit();
}







    if(isset($_POST['submit'])){
     
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $fName = $_POST['firstName'];
        $lName = $_POST['lastName'];
     
        $phoneNum = $_POST['phoneNum'];
        $email = $_POST['email'];
        $role = 'user';
      
$queryUser2 = "INSERT INTO `user_info` (`user_ID`, `username`, `first_name`, `last_name`, `phone_number`, `email`, `password`, `role`, `reward_points`, `payment_method`, `pref_store`) VALUES (NULL, '$username', '$fName', '$lName', '$phoneNum', '$email', '$password', 'user', '0', NULL, NULL);";
       
        
        
         if ($mysqli->query($queryUser2) === FALSE) {
                // echo $mysqli->error;
                echo "eror sending query";
    
                header('location: register.php');
                exit(0);
            } 
            
            
     
        
    
    }





?>








<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Landing Page</title>
        <link rel="stylesheet" href="./styles.css">
        <link rel="stylesheet" href="./register_styles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> 
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
        <div id="register_form">
     
         .
           
    <div class="wrapper">
        <div class="title">
            Registration Form
        </div>
        
        <div class="form">
       
 <form action="login.php" class="form" id="form" method="POST">   

    
    

                <div class="inputfield">
                    <label>Username</label>
                    <input type="text" id="quantity" name="username" min="1" max="45" class="input" placeholder="UserName" required >

                </div>
                <div class="inputfield">
                    <label>Password</label>
                    <input type="text" name="password" class="input" placeholder="Password" required>

                </div>
                <div class=" inputfield">
                    <label>First Name</label>
                    <input type="text" class="input" name='firstName' placeholder="First Name" required>

                </div>
                
                 <div class=" inputfield">
                    <label>Last Name</label>
                    <input type="text" class="input" name='lastName' placeholder="Last Name" required>

                </div>
                
                 <div class=" inputfield">
                    <label>Phone Number</label>
                    <input type="number" class="input" name='phoneNum' min='10' max='10' placeholder="Phone Number" required>

                </div>
                
                
                 <div class=" inputfield">
                    <label>email</label>
                    <input type="email" class="input" name='email' placeholder="Email" required>

                </div>
                
        
         <div class="inputfield">
                 <!--<button type="submit" name='submitC'>Submit</button>-->
                   <input type="submit" name="submit" value="submit" class="btn" required>
             </div>
         
</form>    

       

        </div>
    </div>

      
            
     

        </div>
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
    <style>
        
    #register_form {
    width: 100%;
    height: 800px;
    background-color: #cbd1d6;
}
    </style>
    
     <style>
        body {
            margin: 0px auto;
            font-family: Arial, Helvetica, sans-serif;
        }

        .topnav {
            margin-top: auto;
            overflow: hidden;
            background-color: #333;
        }

        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: #04AA6D;
            color: white;
        }

        .topnav-right {
            float: right;
        }




        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }




        body {
            background: #ffffff;
            /* #fec107*/
            padding: 0 10px;
        }

        .wrapper {
            max-width: 500px;
            width: 100%;
            background: #fff;
            margin: 100px auto;
            /*change from 20 px changes box space from nav bar */
            box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.125);
            padding: 30px;
        }

        .wrapper .title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #04AA6D;
            /*#fec107;*/
            text-transform: uppercase;
            text-align: center;

        }

        .wrapper .form {
            width: 100%;
        }

        .wrapper .form .inputfield {
            /*  */
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }



        .wrapper .form .inputfield label {
            /*  */
            width: 200px;
            color: #757575;
            margin-right: 10px;
            font-size: 14px;
        }



        .wrapper .form .inputfield .input,
        .wrapper .form .inputfield .textarea {
            /*  */
            width: 100%;
            outline: none;
            border: 1px solid #d5dbd9;
            font-size: 15px;
            padding: 8px 10px;
            border-radius: 30px;
            /* 3 px orignally*/
            transition: all 0.3s ease;
        }


        .wrapper .form .inputfield .custom_select:before {
            /*  */
            content: "";
            position: absolute;
            top: 12px;
            right: 10px;
            border: 8px solid;
            border-color: #d5dbd9 transparent transparent transparent;
            pointer-events: none;
        }

        .wrapper .form .inputfield .custom_select select {
            /*  */
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            outline: none;
            width: 100%;
            height: 100%;
            border: 0px;
            padding: 8px 10px;
            font-size: 15px;
            border: 1px solid #d5dbd9;
            border-radius: 3px;
        }


        .wrapper .form .inputfield .input:focus,
        .wrapper .form .inputfield .textarea:focus,
        .wrapper .form .inputfield .custom_select select:focus {
            border: 1px solid #fec107;
        }

        .wrapper .form .inputfield p {
            /*  */
            font-size: 14px;
            color: #757575;
        }


        .wrapper .form .inputfield .check input[type="checkbox"]:checked~.checkmark {
            /*  */
            background: #fec107;
        }

        .wrapper .form .inputfield .check input[type="checkbox"]:checked~.checkmark:before {
            /*  */
            display: block;
        }

        .wrapper .form .inputfield .btn {
            /*  */
            width: 100%;
            padding: 8px 10px;
            font-size: 15px;
            border: 0px;
            background: #fec107;
            color: #fff;
            cursor: pointer;
            border-radius: 3px;
            outline: none;
        }

        .wrapper .form .inputfield .btn:hover {
            /*  */
            background: #ffd658;
        }

        .wrapper .form .inputfield:last-child {
            /*  */
            margin-bottom: 0;
        }

        @media (max-width:420px) {

            /*  */
            .wrapper .form .inputfield {
                flex-direction: column;
                align-items: flex-start;
            }

            .wrapper .form .inputfield label {
                /*  */
                margin-bottom: 5px;
            }

            .wrapper .form .inputfield.terms {
                /*  */
                flex-direction: row;
            }


            /** history table **/





        }
    </style>
    