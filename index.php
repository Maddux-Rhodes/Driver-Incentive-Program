<?php include "../inc/dbinfo.inc"; ?>

<html>
<head>

<!-- CSS Styling -->
<style type="text/css">
table {
  margin-left: auto;
  margin-right: auto;
}
h1 {
  text-align: center;
  text-decoration:underline;
}
tbody {}
td {
  font-family: 'Lucida Grande', monospace;
  background-color: #fff5d7;
  text-align: center;
}
th {
  background-color: #ff5e6c;
  font-family: 'Lucida Grande', monospace;
}
thead {}
tr {}

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
  font-family: 'Lucida Grande', monospace;
  font-size: 20px;
}

body {
  background-color: #fffff2;
  background-image: url("images/Logo.png");
  background-repeat: no-repeat;
  background-position: 50% 600%;
  background-size: 500px 400px;
}

</style>


</head>

<title>About Page</title>
<link rel="icon" type="image/x-icon" href="/images/Logo.png">
<body>
<h1>ABOUT PAGE</h1>

<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <th style="width:100px">Team Number:</th>
    <th style="width:100px">Version Number:</th>
    <th style="width:150px">Release Date:</th>
    <th style="width:200px">Product Name:</th>
    <th style="width:300px">Product Description</th>
  </tr>

<?php
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        $database = mysqli_select_db($connection, DB_DATABASE);
        $result = mysqli_query($connection, "SELECT * FROM about ORDER BY ID DESC LIMIT 1");
        $query_data = mysqli_fetch_row($result);

        echo "<tr style='height:250px'>";
        echo "<td>", $query_data[1], "</td>",
             "<td>", $query_data[2], "</td>",
             "<td>", $query_data[3], "</td>",
             "<td>", $query_data[4], "</td>",
             "<td>", $query_data[5], "</td>";
        echo "</tr>";
?>

</table>

<!-- Add links that redirect to login and account creation -->
<form action="login.php">
  <input type="submit" class="link" value="Go to Login Page" />
</form>

<form action="accountcreation.php">
  <input type="submit" class="link" value="Go to Account Creation" />
</form>

<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>
</html>
 
