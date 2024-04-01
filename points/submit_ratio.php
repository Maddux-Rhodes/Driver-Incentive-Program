<?php include "../../../inc/dbinfo.inc"; ?>

<html>
<body>

<?php
// Create connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {  
    echo "Database connection failed.";  
}  

session_start();
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$database = mysqli_select_db($connection, DB_DATABASE);

// Check whether account is admin viewing as sponsor or is an actual sponsor account
if(strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) {
  $result = mysqli_query($connection, "SELECT * FROM sponsors");

  // Get the sponsor id associated with the sponsor's username
  $username = $_SESSION['username'];
  while($rows=$result->fetch_assoc()) {
      if($rows['sponsor_username'] == $username) {
          $sponsor_name = $rows['associated_sponsor'];
      }
  }
} else if (strcmp($_SESSION['real_account_type'], "administrator") == 0) {
  $result = mysqli_query($connection, "SELECT * FROM administrators");
  
  // Get the sponsor id associated with the sponsor's username
  $username = $_SESSION['username'];
  while($rows=$result->fetch_assoc()) {
      if($rows['administrator_username'] == $username) {
          $sponsor_name = $rows['administrator_associated_sponsor'];
      }
  }
}

$point_ratio = $_POST['point_ratio'];



// Check for invald info

    // Prepare query on drivers table
    $sql_org = "UPDATE organizations SET organization_dollar2pt=? WHERE organization_username='$sponsor_name'";
    $stmt_org = $conn->prepare($sql_org);
    
    $stmt_org->bind_param("d", $point_ratio);
    
    /*EDIT FOR AUDIT LOG STUFF
    $sql_point_history = "INSERT INTO point_history (point_history_date, point_history_points, point_history_driver_id, point_history_reason) VALUES (?, ?, ?, ?)";
    $stmt_point_history = $conn->prepare($sql_point_history);
    $stmt_point_history->bind_param("ssss", $regDate, $point_val, $driver_id, $reason);*/

    if ($stmt_org->execute()) {
        echo '<script>alert("Ratio sucessfully changed!\n")</script>';
           echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/account/sponsorhomepage.php"</script>';
       }
       else{
           echo '<script>alert("Failed to change ratio...\n\nCheck your information and retry...")</script>';
           echo '<script>window.location.href = "assign_points.php"</script>';
       }
?>

</body>
</html>