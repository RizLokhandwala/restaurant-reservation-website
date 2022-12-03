<html>
  <head>
    <title>Add Map</title>
	<script type="text/javascript" src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <link rel="stylesheet" href="./styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="./locations_styles.css" />
    <script type="text/javascript" src="./locations.js"></script>
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
        <a href="./login.php">Login </a>
      </div>
      <div class="menu_dropdown">
        <button id="dropdown_button"><img class="icon" src="./media/kebab.jpg"></button>
      </div>
    </nav>
    <div class="main container">
      <div class="find_restaraunt">
        <h2>Find a Restaurant</h2>
        <p>Start off by selecting a location so we know where to reserve your table.</p>
        
        <!--viewTab Function-->
		<?php 
			echo '<script type="text/JavaScript"> 
     				function viewTab(evt, tab_name) {
            			// Declare all variables
            			var i, tab_content, tab_links;

            			// Get all elements with class="tabcontent" and hide them
            			tab_content = document.getElementsByClassName("tab_content");
            			for(i=0; i<tab_content.length; i++) {
              				tab_content[i].style.display="none";
              				console.log(tab_content[i]);
            			}
          
            			// Get all elements with class="tab_links" and remove the class "active"
            			tab_links = document.getElementsByClassName("tab_links");
            			for(i=0; i<tab_links.length; i++) {
              				tab_links[i].className = tab_links[i].className.replace(" active", "");
            			}
          
            			// Show the current tab, and add an "active" class to the button that opened the tab
            			document.getElementById(tab_name).style.display = "block";
            			evt.currentTarget.className += " active";
          			}  
          			
          			// get enter key to submit 
        document.onkeydown=function(evt){
        var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
        if(keyCode == 13)
        {
            //your function call here
            document.test.submit();
        }
    }
          			
          			
     			</script>';
     			
		?>

        <!--Tab links-->
        <div class="tab container">
          <button class="tab_links" onclick="viewTab(event, 'nearby')" id="default_open" >Nearby Locations</button>
          <button class="tab_links" onclick="viewTab(event, 'my_locations')">My Locations</button>
        </div>
            <!--Get the element with the id="default_open" and click on it-->
        <!--Tab content-->
        <div id="nearby" class="tab_content">
          <form name="form" action="" method="post">
            <input type="text" name="nearby_location_search_bar" class="search_bar" id="nearby_location_search_bar" placeholder="Search by city, state, or zip code">
          </form>
        
            <?php
                $searchValue = $_POST['nearby_location_search_bar'];
                session_start();
          
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
                 
                $displayStores = "SELECT * FROM locations WHERE city LIKE '$searchValue' OR zip LIKE '$searchValue' OR state LIKE '$searchValue'";
                if ($searchValue) {
                    $sendquery1 = mysqli_query($mysqli, $displayStores);
                    if ($mysqli->query($sendquery1) === FALSE) {
                        echo "error sending query";
                
                        header('location: locations.php');
                        exit(0);
                    }
                    else {
                      $store_IDs = array();
                      $store_titles = array();
                      $addresses = array();
                      $cities = array();
                      $states = array();
                      $zips = array();
                      
                      $i = 0;
                      //$storeID($sendquery1->num_rows);
                        if ($sendquery1->num_rows > 0) {
                            while($row = $sendquery1->fetch_assoc()) {
                                $store_IDs[$i] = $row['store_ID'];
                                $store_titles[$i] = $row['store_title'];
                                $addresses[$i] = $row['address'];
                                $cities[$i] = $row['city'];
                                $states[$i] = $row['state'];
                                $zips[$i] = $row['zip'];
                                $i++;
                            }  
                        }
                       
                      
                    }
                    for ($iter = 0; $iter < $sendquery1->num_rows; $iter++) {
                        echo '<div style="font-size:16px; margin-bottom: 10px;">
                                  <p style="color:crimson; margin:10px; font-size: 20px;">' . $store_titles[$iter] . '</p>
                                  <p style="margin:10px; margin-left: 20px;">' . $addresses[$iter] . '</p>
                                  <p style="margin:10px; margin-left: 20px;">' . $cities[$iter] . ', ' . $states[$iter] . ' ' . $zips[$iter] . '</p>
                                  
                                  <a href="./reservation.php?store_ID=' . $store_IDs[$iter] . '#location=' . $store_titles[$iter] . '"><button style="width: 200px; height: 30px; background-color: inherit; color: white; border: 3px solid white; margin-left: 10px; margin-bottom: 30px; cursor: pointer;">Reserve Table</button>
                              </div>';
                    }
                }  
            ?>
        </div>

    
    
    
    
    
    

        <div id="my_locations" class="tab_content">
          <p>my locations</p>
        </div>
        <script>
          document.getElementById("default_open").click();
        </script>
      </div>
      <!--The div element for the map -->
      <div id="map"></div>
    </div>

    <!-- 
     The `defer` attribute causes the callback to execute after the full HTML
     document has been parsed. For non-blocking uses, avoiding race conditions,
     and consistent behavior across browsers, consider loading using Promises
     with https://www.npmjs.com/package/@googlemaps/js-api-loader.
    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASJI9743_5Q9H5Smprz2LfJP9jpX-xLpg&callback=initMap&v=weekly" defer></script>
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