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


</style>
</head>

<title>Landing Page</title>
<link rel="icon" type="image/x-icon" href="S24-Team05/images/Logo.png">
<body>
  <div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Login</h1>
      <h1> </h1>
      <h1>Or</h1>
      <h1> </h1>
      <h1>Create</h1>
      <h1> </h1>
      <h1>Account</h1>
    </div>
  </div>

  
  <!-- Add links that redirect to login and account creation -->
<form action="S24-Team05/account/login.php">
  <input type="submit" class="link" value="Login" />
</form>

<form action="S24-Team05/account/driver_account_creation.php">
  <input type="submit" class="link" value="Create Account" />
</form>

  <!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>
</html>