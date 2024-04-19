<?php include "../../inc/dbinfo.inc"; ?>

<html>

<head>
<style type="text/css">
body {
  background-color: #fff5d7;
  margin: 0;
  padding: 0;
  height: auto;
  width: auto;
}

h1 {
  text-align: left;
  margin-left: 5%;
  margin-top: 15%;
  font-family: "Monaco", monospace;
  /*font-size: 3em;*/
  font-size: 2.5vmax;
  color: #FEF9E6
}

h2 {
  text-align: left;
  margin-left: 2.5%;
  font-family: "Monaco", monospace;
  /*font-size: 2em;*/
  font-size: 2vmax;
}

h3 {
  text-align: left;
  margin-left: 2.5%;
  font-family: "Monaco", monospace;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
  color: #ff5e6c
}

p {
  font-family: "Monaco", monospace;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
}

#flex-container-header {
  display: flex;
  flex: 1;
  justify-content: stretch;
  margin-top: 2.5%;
  background-color: #ff5e6c;
}

#flex-container-description {
  display: flex;
  margin-top: 1%;
  margin-left: 2%;
  margin-right: 2%;
  background-color: #FEF9E6;
}

#flex-container-team-info {
  display: flex;
  /*height: 15%;*/
  width: auto;
  background-color: #FEF9E6;
  margin-top: 1%;
  margin-left: 5%;
  margin-right: 2%;
}

#flex-container-child {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1.5%;
}

#flex-container-child-2 {
  display: flex;
  flex: 1;
  justify-content: left;
  align-items: center;
  padding: 3.5%;
}

form {
  text-align: center;
  margin: 20px 20px;
}

.link{
  text-align: center;
  border-style: outset;
  color: black;
  background-color: #ffaaab;
  cursor: pointer;
  font-family: "Monaco", monospace;
  font-size: 20px;
}
.navbar {
  overflow: hidden;
  background-color: #FEF9E6;
  font-family: "Monaco", monospace;
  margin-bottom: -2.5%;
}

.navbar a {
  float: left;
  font-size: 16px;
  font-family: "Monaco", monospace;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: black;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: #fff5d1;
;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}

.menu { 
  float: none;
  color: black;
  font-size: 16px;
  margin: 0;
  text-decoration: none;
  display: block;
  text-align: left;
} 
.menu a{ 
  float: left;
  overflow: hidden;
  font-size: 16px;  
  border: none;
  outline: none;
  color: black;
  padding: 12px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
} 


</style>
</head>

<div class="navbar">
  <div class="menu">
    <a href="/S24-Team05/account/homepageredirect.php">Home</a>
    <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
    <a href="/S24-Team05/account/logout.php">Logout</a>
    <a href="/S24-Team05/driver_about_page.php">About</a>
    <?php if($curr_sponsor != "none") {?> <a href="/S24-Team05/catalog/catalog_home.php">Catalog</a> <?php } ?>
    <?php if($curr_sponsor != "none") {?> <a href="/S24-Team05/order/order_history.php">Orders</a> <?php } ?>
  </div>
  <?php if($curr_sponsor != "none") {?>
    <div class="dropdown">
      <button class="dropbtn">Switch Sponsor
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <?php
          $username = $_SESSION['username'];
          $driver_id = 0;
          $assoc_spons_query = 0;
          $sponsor_id = 0;
          $spons_id_query = 0;
          if(strcmp($_SESSION['real_account_type'], "driver") == 0) {
            $driver_id = mysqli_query($connection, "SELECT driver_id FROM drivers WHERE driver_username='$username' AND driver_archived=0");
            $driver_id = ($driver_id->fetch_assoc())['driver_id'];

            $assoc_spons_query = mysqli_query($connection, "SELECT * FROM driver_sponsor_assoc WHERE driver_id=$driver_id AND driver_sponsor_assoc_archived=0");
          }else{
            $assoc_spons_query = mysqli_query($connection, "SELECT sponsor_id FROM sponsors WHERE sponsor_username='$username' AND sponsor_archived=0");
            $sponsor_id = ($assoc_spons_query->fetch_assoc())['sponsor_id'];
          }
          while($row = $assoc_spons_query->fetch_assoc()){
            if(strcmp($_SESSION['real_account_type'], "driver") == 0){
              $sponsor_id = $row['assoc_sponsor_id'];
            }
            
            $sponsor_name = mysqli_query($connection, "SELECT organization_username FROM organizations WHERE organization_id=$sponsor_id");
            $sponsor_name = ($sponsor_name->fetch_assoc())['organization_username'];

            echo("<form action='http://team05sif.cpsc4911.com/S24-Team05/account/switch_sponsor.php' method='post'>
              <input type='hidden' name='driver_id' value='$driver_id'/>
              <input type='hidden' name='sponsor_id' value='$sponsor_id'/>
              <input type='hidden' name='sponsor_name' value='$sponsor_name'/>
              <input type='submit' class='link' value='$sponsor_name'/>
              </form>");


          }
        ?>
      </div>
    </div>
  <?php } ?>
</div>

<title>About Page</title>
<link rel="icon" type="image/x-icon" href="S24-Team05/images/Logo.png">
<body>
  <div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>About</h1>
      <h1> </h1>
      <h1>Page</h1>
    </div>
  </div>

  <div id = "flex-container-description">
    <div id = "flex-container-child">
      <?php
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        $database = mysqli_select_db($connection, DB_DATABASE);
        $result = mysqli_query($connection, "SELECT * FROM about ORDER BY ID DESC LIMIT 1");
        $query_data = mysqli_fetch_row($result);

        echo "<h2>", $query_data[4], "</h2>",
             "<p>", $query_data[5], "</p>";  
      ?>
    </div>
  </div>

  <div id = "flex-container-team-info">
    <div id = "flex-container-child-2">
      <h3>Team Number:</h3>
      <h3> </h3>
      <?php
        $result = mysqli_query($connection, "SELECT * FROM about ORDER BY ID DESC LIMIT 1");
        $query_data = mysqli_fetch_row($result);

        echo "<p>", $query_data[1], "</p>";  
      ?>
    </div>
  </div> 

  <div id = "flex-container-team-info">
    <div id = "flex-container-child-2">
      <h3>Sprint Number:</h3>
      <h3> </h3>
      <?php
        $result = mysqli_query($connection, "SELECT * FROM about ORDER BY ID DESC LIMIT 1");
        $query_data = mysqli_fetch_row($result);

        echo "<p>", $query_data[2], "</p>"; 
      ?>
   </div>
  </div>

  <div id = "flex-container-team-info">
    <div id = "flex-container-child-2">
      <h3>Release Date:</h3>
      <h3> </h3>
      <?php
        $result = mysqli_query($connection, "SELECT * FROM about ORDER BY ID DESC LIMIT 1");
        $query_data = mysqli_fetch_row($result);

        echo "<p>", $query_data[3], "</p>"; 
      ?>
   </div>
  </div>

  <!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>
</html>