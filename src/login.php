

<?php
session_start();

//store the users loginID


?>


<?php

// $port = $_SERVER['WEBSITE_MYSQL_PORT'];
// $host = "localhost:$port";
// $username = "azure";
// $password = "6#vWHD_$";
// $db_name = "4351project3";

// //Initializes MySQLi
// $mysqli = new mysqli($host,$username,$password,$db_name);

// if($mysqli->connect_errno){
//     echo"Failed to connect to MySQL: ". $mysqli->connect_error;
//     exit();
// }


//     $errors = array('username' => '', 'user' => '');

//     if ($_SERVER['REQUEST_METHOD'] == "POST") {
//         $Username = $_POST['username'];
//         $Password = $_POST['userPassword'];

//         if (!empty($Username) && !empty($Password)) {

//             //Reads from DB
//             $query = "SELECT * FROM user_info WHERE username  = '$Username'  limit 1";

//             $result = mysqli_query($mysqli, $query);

//             if ($result && mysqli_num_rows($result) > 0) {
//                 $user_data = mysqli_fetch_assoc($result);
//                 // echo "$user_data good";
//                 // password_verify($Password,
//                 //  
//                 if ($Password == $user_data['password']) {
                    
//                     echo '$user_data[',password,']';
//                     echo "accessed here";
//                     // echo($user_data['Login_password']);
//                     $_SESSION['user_ID'] = $user_data['user_ID']; // connecting users to this
//                     $_SESSION['username'] = $user_data['username'];

//                     // $_SESSION['users_users_id'] = $user_data['users_users_id'];  // need the id from ehere

//                     header("Location: locations.php");
//                     // header("Location: createUser.php");
//                     // header("Location: indexFuelHist.php");
//                     die;
//                 } else {

//                     $errors['userPassword'] = "Password does not match the username, Try again.<br/><br/>";
//                 }
//             } //num rows



//             else {
//                 $errors['username'] = "Username does not exist. Need to create user account. Try Again <br/>";
//             }
//         } else {
//             $errors['username'] = "no infromation entered , Try Again <br/>";
//         }
//     }
//     
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


    $errors = array('username' => '', 'password' => '');

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $Username = $_POST['username'];
        $Password = $_POST['password'];

        if (!empty($Username) && !empty($Password)) {

            //Reads from DB
            $query = "SELECT * FROM user_info WHERE username  = '$Username'  limit 1";

            $result = mysqli_query($mysqli, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                // echo "$user_data good";
                // password_verify($Password,
                //  
                if ($Password == $user_data['password']) {
                    
                    echo '$user_data[',password,']';
                    echo "accessed here";
                    // echo($user_data['Login_password']);
                    $_SESSION['user_ID'] = $user_data['user_ID']; // connecting users to this
                    $_SESSION['username'] = $user_data['username'];

                    // $_SESSION['users_users_id'] = $user_data['users_users_id'];  // need the id from ehere

                    header("Location: index.php");
                    // header("Location: createUser.php");
                    // header("Location: indexFuelHist.php");
                    die;
                } else {

                    $errors['password'] = "Password does not match the username.  Try Again please <br/><br/>";
                }
            } //num rows



            else {
                $errors['username'] = "Username does not exist. Try Again please <br/>";
            }
        } else {
            // $errors['username'] = "  <br/>";
        }
    }
    ?>




<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Account Login</title>
        <link rel="stylesheet" href="./styles.css">
        <link rel="stylesheet" href="./login_styles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> 
    </head>
    <body style="margin: 0;">
        <nav class="header container">
            <div class="left_box">
                <div class="logo">
                    <a href="./index.php"><img src="./media/logo.jpg"/></a>
                </div>
                <div class="header_links">
                    <a href="./menu.html">Menu </a>
                    <a href="./locations.php">Reserve Table </a>
                    <a href="./locations.php">Find Restaurant </a>
                </div>
                
            </div>
            <div class="header_links right_box">
                <a href="./login.php">Login </a>
            </div>
            <div class="menu_dropdown">
                <button id="dropdown_button"><img class="icon" src="./media/kebab.jpg"></button>
            </div>
        </nav>
        <?php 
			echo '<script type="text/JavaScript"> 
        <script>
            function togglePasswordVisability() {
                var x = document.getElementById("password_input");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
        </script>';
        ?>
        <div class="login_layer container">
            <div class="create_account">
                <div class="create_words">
                    <h3>Create an Account</h3>
                </div>
                <div class="create_why">
                    <p>Make it easy to get your food.</p>
                    <ul>
                        <li>Receive rewards and special offers</li>
                        <li>Reserve tables faster</li>
                        <li>Review reservation and order history</li>
                    </ul> 
                </div>
                <div class="register">
                    <a href="./register.php"><button class="register_button">REGISTER</button></a>
                </div>
                 
            </div>
            <div class="middle_line">
                <img src="./media/vertical_line.jpg" style="width: 8px; height:300px; margin-top:100px; opacity: 0.5;">
            </div>
            <div class="login_side">
                <h3>Login To Your Account</h3>
                <div>
                    <label>Username*</label>
                </div>
                
                <form method="POST" class="login-form">
                
                <div>
                    <!--<input type="text" name="username" class="input_field" id="username_input">-->
                    <input type="text" name="username" placeholder="Username..." class="input-single" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>"><br>
                    
                </div>
                  <div class="errors">
                  <p>
                      <?php echo $errors['username']; ?>
                  </p>
              </div>
                
                <div>
                    <label>Password*</label>

                </div>
                <div>
                    <!--<input type="password" name="password" class="input_field" id="password_input"/>-->
                <input type="password" name="password" placeholder="Password..." id="ipassword" class="input-single">
                  <i><span class="material-icons-outlined" id="icon" onclick="toggle()"></span></i>
                </div>
                  <div class="errors">
                  <p>
                      <?php echo $errors['password']; ?>
                  </p>
              </div>
                
                
                <!--<div>-->
                <!--    <input type="checkbox" onclick="togglePasswordVisability()">Show Password-->

                <!--</div>-->
                
              <!--  <div class="errors">-->
              <!--    <p>-->
              <!--        <?php echo $errors['password']; ?>-->
              <!--    </p>-->
              <!--</div>-->
                
                <!--<div class="forgot_password">-->
                <!--    <a href="accountRecovery.html">forgot password?</a>-->
                <!--</div>-->
                
                 
                <div>
                    <button class="login_button" type='submit' >Login</button>
                </div>
                </form>

            </div>
            
        </div>
    </body>
    <footer>
        <div class="about_layer container">
            <div class="footer_nav container">
                <div class="footer_nav_links"><a href="./locations.php">Reserve Table</a></div>
                <div class="footer_nav_links"><a href="./about.html">About Us</a></div>
                <div class="footer_nav_links"><a href="contactUs.html">Contact Us</a></div>
                <div class="footer_nav_links"><a href="https://project4351.scm.azurewebsites.net/dev/wwwroot/">Source Code</a></div>
            </div>
        </div>
    </footer>