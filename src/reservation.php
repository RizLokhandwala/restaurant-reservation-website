<?php //Initializes MySQLi
    
    session_start();
    
    $port = $_SERVER['WEBSITE_MYSQL_PORT'];
    $host = "localhost:$port";
    $username = "azure";
    $password = "6#vWHD_$";
    $db_name = "4351project3";
    
    $mysqli = new mysqli($host,$username,$password,$db_name);
    if($mysqli->connect_error){
        echo"Failed to connect to MySQL: ". $mysqli->connect_error;
        exit();
    }
?>

<?php // get info for the location section on page
    // echo '<script>alert("Hello Valued Customer, a no show will have minimum $10 charge")</script>';
    // get curStoreID from URL
    $curStoreID = $_GET['store_ID'];
    $chosenDate = $_GET['date'];
    $userID = $_SESSION['user_ID'];
    
    if (!$curStoreID) {
        $curStoreID = 1;
    }
    $query = "SELECT * FROM locations WHERE store_ID = '$curStoreID'";
    if ($curStoreID) {
        $result = mysqli_query($mysqli, $query);
        if ($mysqli->query($result) === FALSE) {
            echo "error sending query";
                
            header('location: locations.php');
            exit(0);
        }
        // populate data
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $store_title = $row['store_title'];
            $address = $row['address'];
            $city = $row['city'];
            $state = $row['state'];
            $zip = $row['zip'];
            $phone = $row['phone_number'];
        }
        
    }
    
    $user_query = "SELECT * FROM user_info WHERE user_ID = '$userID'";
    if ($userID) {
        $result = mysqli_query($mysqli, $user_query);
        if ($mysqli->query($result) === FALSE) {
            echo "error sending query";
            
            header('location: locations.php');
            exit(0);
        }
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
    }
    $loaded = TRUE;
            
?>

<?php
    if ($loaded) {
        if ($_POST['date_input'] == "") {
            
        }
        else {
            $chosenDate = $_POST['date_input'];
            
        }
        $num_guests = $_POST['num_guests'];

    
        if ($chosenDate AND $num_guests AND $curStoreID) {
            $continue = TRUE;
        }
    }
    
        
?>

<?php
        if ($continue) {
        // queries to be used:
            $tables_at_location_query = "SELECT * FROM table_info WHERE store_ID = '$curStoreID';";
            $reservations_on_that_day = "SELECT * FROM reservations WHERE date = '$chosenDate';";
        
        $result = mysqli_query($mysqli, $tables_at_location_query);
        if ($mysqli->query($result) === FALSE) {
            echo "error sending query";
                
            header('location: locations.php');
            exit(0);
        }
        if ($result->num_rows > 0) {
            // instantiate variables
            $extra_seats = array();
            $e=0;
            
            $few_seats = array();
            $f=0;
            
            $perfect_seats = array();
            $p=0;
            
            // loop through query
             while($row = $result->fetch_assoc()) {
                $ns = $row['num_seats'];
                $id = $row['table_ID'];
                
                if ($ns > $num_guests) {
                    $extra_seats[$id] = $ns;
                }
                else if ($ns < $num_guests) {
                    $few_seats[$id] = $ns;
                }
                else {
                    $perfect_seats[$id] = $ns;
                }
             }
        }
    
        
        $result = mysqli_query($mysqli, $reservations_on_that_day);
        if ($mysqli->query($result) === FALSE) {
            echo "error sending query";
            
            header('location: locations.php');
        }
        if ($result->num_rows > 0) {
            // loop through reservations to see if table has already been reserved
            while ($row = $result->fetch_assoc()) {
                $id = $row['table_ID'];
                
                // if table is taken, remove from arrays
                unset($extra_seats[$id]);
                unset($few_seats[$id]);
                unset($perfect_seats[$id]);
                
            }
            
        }
        
        $combinations = array();
        $index = 0;
        
        foreach($few_seats as $first_id => $first_ns) {
            foreach($few_seats as $second_id => $second_ns) {
                if ($first_id < $second_id) {
                    if ($first_ns + $second_ns >= $num_guests) {
                        $combinations[$index] = [$first_id, $second_id];
                        $index++;
                    }
                }
            }
        }
    }
    $tables_ready = TRUE;
	
?>

<?php 
    if ($tables_ready) {
        $first = $_POST['first_name'];
        $last  = $_POST['last_name'];
        $user_phone = $_POST['user_phone'];
        $user_email = $_POST['user_email'];
        $warning = $_POST['warning'];
        $time = $_POST['pref_time'];
        
        $ready = TRUE;
        $choice = $_POST['table_radios'];
        if ($choice == 0){ // combination is picked
            $table_ids = $_POST['combinations'];
            $table_ids_arr = explode(",", $table_ids);
            $table_id1 = $table_ids_arr[0];
            $table_id2 = $table_ids_arr[1];
        }
        else if ($choice == 1) { //perfect table is picked
            $table_id1 = $_POST['perfect'];
            $table_id2 = 'NULL';
        }
        else if ($choice == 2) { // extra table is picked
            $table_id1 = $_POST['extra'];
            $table_id2 = 'NULL';
        }
        else {
            $ready = FALSE;
        }
        
    }
    
    if ($ready AND $first AND $last AND $user_phone AND $user_email AND $warning == "checked") {
        
        // Find reservation ID
        	$q = "SELECT MAX(reservation_ID) FROM reservations;";

        $result = mysqli_query($mysqli, $q);
        if ($mysqli->query($result) === FALSE) {
            echo "error sending query";
            
            header('location: locations.php');
            exit(0);
        }
    
        $data = $result->fetch_assoc();
        $reservation_ID = $data['MAX(reservation_ID)'] + 1;
        
        
        // make reservation (SEND TO SQL)
        if (isset($userID)) {
            $insertReservation = "INSERT INTO `reservations` (`date`, `reservation_ID`, `num_guests`, `user_ID`, `email`, `table_ID`, `second_table_ID`) VALUES ('$chosenDate', NULL, $num_guests, $userID, '$user_email', $table_id1, $table_id2);";
            
        }
        else {
            $insertReservation = "INSERT INTO `reservations` (`date`, `reservation_ID`, `num_guests`, `user_ID`, `email`, `table_ID`, `second_table_ID`) VALUES ('$chosenDate', NULL, $num_guests, NULL, '$user_email', $table_id1, $table_id2);";
            
        }
        if ($mysqli->query($insertReservation) === TRUE) {
            $_SESSION['time'] = $time;
            $_SESSION['location'] = $store_title;
            $_SESSION['date'] = $chosenDate;
            $_SESSION['reservation_ID'] = $reservation_ID;
            $_SESSION['name'] = $first;
            
            header("Location: confirmation.php");
            exit();
        }
        else {
            echo $insertReservation . '<br>';
            echo "Oops, something went wrong";
        }
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Landing Page</title>
        <link rel="stylesheet" href="./styles.css">
        <link rel="stylesheet" href="./reservation_styles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"> 
        
    </head>
    <body style="margin: 0;">
        <nav class="header container">
            <div class="left_box">
                <div class="logo">
                    <a href="./index.php"><img src="./media/logo.jpg"/></a>
                </div>
                <div class="header_links">
                    <a href="./menu.html">Menu </a>
                    <a href="./reservation.php">Reserve Table </a>
                    <a href="./locations.php">Find Restaurant </a>
                
                </div>
                
            </div>
            <div class="header_links right_box">
                <a href="./login.html">Login </a>
            </div>
            <div class="menu_dropdown">
                <button id="dropdown_button"><img class="icon" src="./media/kebab.jpg"></button>
            </div>
        </nav>
		
		<!--NEW STUFF GOES HERE-->
        <form name="form" action="" method="post" id="form">
        <div class="main">
            <div class="center_piece">
                <div class="cancel">
                    <div class="cancel_link_holder">
                        <a href="./cancel.php" id="top_cancel_link">CHANGE OR CANCEL YOUR RESERVATION</a>
                    </div>
                </div>
                <div class="title_piece">
                    <div class="title_word_holder">
                        <p>RESERVE A TABLE</p>
                    </div>
                </div>
                <div class="photos">
                    <img style="width: 950px; height: 256px; object-fit: "src="./media/reserve.jpg"/>
                </div> 
            </div>
            
            <div class="location_stuff container">
                <div class="left_spot">
                    <div class="store_title">
                        <p><?php echo $store_title; ?><p>
                    </div>
                    <div class="store_info">
                        <p><?php echo $address . " | " . $city . ", " . $state . " " . $zip . " | " . $phone;?><p>
                    </div>
                </div>
                <div class="right_spot">
                    <a href="./locations.php"><button type="button" id="change_location_button">Change My Location</button></a>
                </div>
            </div>
            <div class="preferences container">
                <div class="date">
                    <label>SELECT A DATE<label><br>
                    <input type="date" id="date_input" name="date_input" value="<?php echo $chosenDate?>"></input>
                </div>
                <div class="guests">
                    <label>HOW MANY GUESTS?</label><br>
                    <!--<input type="number" class="preferred_button" id="num_guests" name="num_guests"></input>-->
                    <input type="number" class="preferred_button" id="num_guests" name="num_guests"  value="<?php echo $num_guests?>"></input>
                </div>
                <div class="preferred_time">
                    <label>SELECT A PREFERRED TIME</label>
                    <input type="time" class="preferred_button" id="pref_time" name="pref_time"></input>
                </div>
                <div class="find_tables">
                    <button type="button" onclick="submitForm()" class="preferred_button">Find Tables</button>
                </div>
            </div>
            <?php if ($chosenDate == '2022-12-31'){
                        echo '<p style="color:crimson; text-align: center; font-size: 12px; padding-bottom: 20px;">Due to a high demand for reservations on New Years, we are placing a $20 downpayment on all reservations placed for this day. Thank you.</p>';
            } ?>
            <div class="available">
                <h5>SELECT AN AVAILABLE RESERVATION</h5>
                
                <p style="font-size: 14px; padding-top: 10px; padding-bottom: 10px;">Select an open table, or change your preferred time to see more options.</p>
                <div class="container available_times">
                    <div class="table_slot" id="table_combinations">
                        <label>Combination of Tables</label><br>
                        <select name="combinations">
                        <?php
                            foreach($combinations as $index => [$first_id, $second_id]) {
                                $ts = $few_seats[$first_id] + $few_seats[$second_id];
                                echo '<option value="' . $first_id . ',' . $second_id . '">Tables ' . $first_id . ' and ' . $second_id . ' with ' . $ts . ' seats</option>';
                            }
                        
                        ?>
                        </select>
                    </div>
                    <div>
                        <?php if(count($combinations) > 0) {
                            echo '<input type="radio" name="table_radios" class="table_radio" value="0" ></input>';
                        }
                        ?>
                    </div>
                    <div class="table_slot" id="just_right">
                        <label>Tables with <?php echo $num_guests; ?> seats</label><br>                                            
                        <select name="perfect">
                            <?php
                                foreach($perfect_seats as $id => $ns) {
                                    echo '<option value="' . $id . '">Table ' . $id . ' with ' . $ns . ' seats</option>';
                                    
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <?php if(count($perfect_seats) > 0) {
                            echo '<input type="radio" name="table_radios" class="table_radio" value="1"></input>';
                        }
                        ?>
                    </div>                        
                    <div class="table_slot" id="extra_space">
                        <label>Tables with more than <?php echo $num_guests; ?> seats</label><br>                        
                        <select name="extra">
                            <?php
                                foreach($extra_seats as $id => $ns) {
                                    echo '<option value="' . $id . '">Table ' . $id . ' with ' . $ns . ' seats</option>';
                                    
                                }    
                            ?>
                        </select>
                    </div>
                    <div>
                        <?php if(count($extra_seats) > 0) {
                            echo '<input type="radio" name="table_radios" class="table_radio" value="2"></input>';
                        }
                        ?>
                        
                    </div>
                </div>
            </div>
            <div class="info">
                <h5>PLEASE PROVIDE YOUR INFORMATION</h5><br>
                <div class="container">
                    <div id="info_left" style="display:inline;">
                        <div class="info_top">
                            <label>FIRST NAME*</label><br>
                            <input class="info_input" placeholder="First Name" id="first_name" name="first_name"><!--FILL THIS IN--></input>
                        </div>
                        <div class="info_bottom">
                            <label>PHONE NUMBER*</label><br>
                            <input class="info_input" placeholder="Phone Number" id="user_phone" name="user_phone"><!--FILL THIS IN--></input>
                        </div>
                    </div>
                    <div id="info_right" style="display:inline;">
                        <div class="info_top">
                            <label>LAST NAME*</label><br>
                            <input class="info_input" placeholder="Last Name" id="last_name" name="last_name"><!--FILL THIS IN--></input>
                        </div>
                        <div class="info_bottom">
                            <label>EMAIL ADDRESS*</label><br>
                            <input class="info_input" placeholder="Email Address" id="user_email" name="user_email"><!--FILL THIS IN--></input>
                        </div>
                    </div>
                </div>
            
            </div>
            
            
            <div class="finalize">
                <label class="right" style="color:crimson;">By clicking this checkbox you agree to a $10 fee for Not showing up to reservation.</label>
                 
                
                <input type="checkbox" class="right" name="warning" value="checked">   </input>
                
                <br>
                <a href="./index.php" class="cancel_link">CANCEL</a>
                <a><button>RESERVE</button></a>
            </div>
            
        </div>
        </form>
        <div class="more_blank_space"></div>
        <div class="even_more_blank_space"></div>
        <div class="even_more_blank_space"></div>
    
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
</html>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) { 
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>
    
    <script type="text/javascript">
        function submitForm() {
            document.getElementById("form").submit();
        }
    </script>
    