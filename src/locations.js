// Initialize and add the map
function viewTab(evt, tab_name) {
  // Declare all variables
  var i, tab_content, tab_links;

  // Get all elements with class="tabcontent" and hide them
  tab_content = document.getElementsByClassName("tab_content");
  for(i=0; i<tab_content.length; i++) {
    tab_content[i].getElementsByClassName.display="none";
  }

  // Get all elements with class="tab_links" and remove the class "active"
  tab_links = document.getElementsByClassName("tab_links");
  for(i=0; i<tab_links.length; i++) {
    tab_links[i].className = tab_links[i].className.replace(" active", "");
    console.log("hello");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(tab_name).style.display = "block";
  evt.currentTarget.className += " active";
}

function initMap() {
    // Locations:
    const SUGARLAND = {lat: 29.5984, lng: -95.6226};
    const HOUSTON = {lat: 29.7604, lng: -95.3698};
    const RICHMOND = {lat: 29.5822, lng: -95.7608};
    const STAFFORD = {lat: 29.6161, lng: -95.5577};
    const AUSTIN = {lat: 30.2672, lng: -97.7431};
    const KATY = {lat: 29.7858, lng: -95.8245};
    const SANANTONIO = {lat: 29.4252, lng: -98.4946};
    
    // The location of Uluru
    const texas = { lat: 31.9686, lng: -99.9018 };
    // The map, centered at Uluru
    
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 8,
      center: KATY,
    });
    

    // The marker, positioned at Uluru
    const marker = new google.maps.Marker({
      position: SUGARLAND,
      map: map,
    });
    const marker2 = new google.maps.Marker({
      position: HOUSTON,
      map: map,
    });
    const marker3 = new google.maps.Marker({
      position: RICHMOND,
      map: map,
    });
    const marker4 = new google.maps.Marker({
      position: STAFFORD,
      map: map,
    });
    const marker5 = new google.maps.Marker({
      position: SANANTONIO,
      map: map,
    });
    const marker6 = new google.maps.Marker({
      position: KATY,
      map: map,
    });
    const marker7 = new google.maps.Marker({
      position: AUSTIN,
      map: map,
    });
  }
  
  window.initMap = initMap;