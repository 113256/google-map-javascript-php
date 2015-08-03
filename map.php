<?php
require('includes/connect.php');
  $latitude = $longitude = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $latitude = $_POST['Latitude'];
    $longitude = $_POST['Longitude'];

     $query = "INSERT INTO `coord` (`latitude`, `longitude`)
  VALUES ('$latitude', '$longitude')";

  $req = $db->prepare($query);
  $req->execute();

  }


$searchQuery = "SELECT * FROM `coord` where 1=1";
 try 
    { 
        // These two statements run the query against your database table. 
        $resultAll = $db->prepare($searchQuery); 
        $resultAll->execute(); 
    } 
    catch(PDOException $ex) 
    { 
        // Note: On a production website, you should not output $ex->getMessage(). 
        // It may provide an attacker with helpful information about your code.  
        die("Failed to run query: " . $ex->getMessage()); 
    } 
         
    // Finally, we can retrieve all of the found rows into an array using fetchAll 
    $rows = $resultAll->fetchAll(); //this is the same as pushing each row of the result table into an array
    echo'<br>';


//url parameters
    $latitudeURL=$longitudeURL ="";
if(isset($_GET["lat"])){$latitudeURL = $_GET["lat"];}
if(isset($_GET["long"])){$longitudeURL = $_GET["long"];}






 ?>
<!DOCTYPE html>
<html manifest="cache.appcache">
<head>
  <?php require('includes/head.php');?>
	<title></title>
	
	
<style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      .controls {
        margin-top: 16px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

}

    </style>
	
<!--load the Google Places library using the libraries parameter in the bootstrap URL for the Google Maps JavaScript API.-->
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places" ></script>

	<script type="text/javascript" src="js/map.js"></script>
		<script>
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
	
	 


</head>



<body>
    

<table class ="table">
  <thead>
    <tr>
      <th>lat</th>
      <th>long</th>
    </tr>
  </thead>
  <tbody>
    <?php
      //mysqli_data_seek($resultAll,0);//return to 0th index
      //while ($row = mysqli_fetch_array($resultAll))//redundant
      foreach($rows as $row)
        {
        ?>
        <tr>
          
        <td><?php  echo $row['latitude'];?></td>  
        <td><?php echo $row['longitude'];?></td>
        <td><a class="btn btn-lg btn-success" href="newevent.php?lat=<?php echo $row['latitude']; ?>&long=<?php echo $row['longitude']?>" role="button">view static map</a></td>  
       
                  
        </tr>
        <?php } ?>


    
  </tbody>
</table>



<img border="0" src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $latitudeURL; ?>,<?php echo $longitudeURL; ?>&zoom=16&size=600x300&maptype=roadmap&markers=color:blue%7Clabel:L%7C<?php echo $latitudeURL; ?>,<?php echo $longitudeURL; ?>&sensor=false" class="map">


    <div id="">
    
    
    
    <div id="">

    <form action = "newevent.php" method= "post">
        
		<h1 style = "text-align:center;"> <strong>search for a place</strong> </h1>
		
		

		
				<!-- google maps-->
				<!-- id refers to the type (Address type) array  in map.js-->
				<!-- pac  = place autocomplete-->
				<label>Location</label>
            <input id="pac-input" name = "Location" class="controls" type="text" placeholder="Enter a location and the details will be filled in" required>
   
  
    <!--map appears here -->
	
	
	
	    <table id="address">
		
		<td>Address</td> <!-- if location doesnt work use address instead-->
		<td colspan = "3"><input id="Address" name="Address" disabled = "true"/>  </td>
		
      <tr>
        <td>Street address</td>
        <td><input class="field" id="street_number" name = "StreetNumber" disabled="true"></input></td>
        <td colspan="2"><input class="field" id="route" name = "Route" disabled="true"></input></td> <!-- route is street name e.g. gower street -->
      </tr>
	   
      <tr>
        <td>City</td>
        <td colspan="3"><input class="field" id="locality" name = "City"
              disabled="true"></input></td>
      </tr>
      <tr>
        <td>State</td>
        <td><input class="field" id="administrative_area_level_1" name = "State" disabled="true"></input></td>
		
        <td>Zip code</td>
        <td><input class="field" id="postal_code" name = "ZipCode" disabled="true"></input></td>
      </tr>
      <tr>
        <td>Country</td>
        <td colspan="3"><input class="field" id="country" name = "Country" disabled="true"></input></td>
	
      </tr>
	  

	  <tr>
	  <td>Latitude</td>
	  <td><input id="Latitude" class="field" name="Latitude" readonly /></td>
	  <td>Longitude</td>
<td><input  id="Longitude" class="field" name="Longitude" readonly /></td></tr>

    </table>
	
		
	
		


		<p class="center"><input class="button" type="submit" name ="submit" data-rel="popup" value="add to database"></p></br>
    </form>
    </div>
    </div>
	
<div id="map-canvas"></div>
	
</body>
</html>
