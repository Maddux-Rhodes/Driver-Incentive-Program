<?php
        session_start();
        if(!$_SESSION['login'] && strcmp($_SESSION['account_type'], "sponsor") != 0) {
            echo "Invalid page.<br>";
            echo "Redirecting.....";
            sleep(2);
            header( "Location: http://team05sif.cpsc4911.com/", true, 303);
            exit();
            //unset($_SESSION['login']);
        }
    ?>
<html>

<head>
<style type="text/css">
body {
  background-color: #fff5d1;
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
  color: #FEF9E6;
}

p {
  font-family: "Monaco", monospace;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
  color: #FF0000;
}

#flex-container-header {
  display: flex;
  flex: 1;
  justify-content: stretch;
  margin-top: 2.5%;
  background-color: #ff5e6c;
}

#flex-container-child {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1.5%;
  margin-left: 2%
}

form {
  text-align: center;
  margin: 20px 20px;
}

input[type=text], input[type=password] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

input[type=submit] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

#hyperlink-wrapper {
  text-align: center;
  margin-top: 20px;
}

#hyperlink {
  text-align: center;
  justify-content: center;
  font-family: "Monaco", monospace;
  font-size: 1.25vmax;
  margin-top: 10px;
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
    <a href="/S24-Team05/account/logout.php">Logout</a>
    <a href="/">About</a>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Audit Log 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="/S24-Team05/audit/logins_drivers_under_sponsor.php">Login Attempts</a>
      <a href="/S24-Team05/audit/password_changes_under_sponsor.php">Password Changes</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Set Driving Behavior
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="/S24-Team05/points/set_behavior.php">Add New Behavior</a>
      <a href="/S24-Team05/points/remove_behavior.php">Remove Behavior</a>
    </div>
  </div> 
</div>

<body>

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Welcome</h1>
      <h1>Sponsor!</h1>
   </div>
</div>
</body>

<form action="http://team05sif.cpsc4911.com/S24-Team05/points/assign_points.php">
  <input type="submit" class="link" value="Give Points To Driver" />
</form>

<form action="http://team05sif.cpsc4911.com/S24-Team05/points/remove_points.php">
  <input type="submit" class="link" value="Remove Points From Driver" />
</form>

<form action="http://team05sif.cpsc4911.com/S24-Team05/points/sponsor_view_driver_points.php">
  <input type="submit" class="link" value="View Driver Points" />
</form>

<form action="http://team05sif.cpsc4911.com/S24-Team05/points/assign_bonus_points.php">
  <input type="submit" class="link" value="Assign Bonus Points" />
</form>

<form action="http://team05sif.cpsc4911.com/S24-Team05/points/change_dollar_to_point_ratio.php">
  <input type="submit" class="link" value="Change Dollar-to-Point Ratio For Drivers" />
</form>

</html>