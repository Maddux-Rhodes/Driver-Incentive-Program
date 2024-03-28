<?php include "../../../inc/dbinfo.inc"; ?>

<html>
<body>

<?php
session_start();

// Create connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {  
    echo "Database connection failed.";  
}  

$sponsor_id = $_POST['sponsor_id'];
$sponsor_name = $_POST['sponsor_name'];
$driver_id = $_POST['driver_id'];

echo("Before org entry");
echo $sponsor_id;
echo $sponsor_name;
echo $driver_id;
$orgEntry = mysqli_query($conn, "SELECT * FROM driver_sponsor_assoc WHERE driver_id=$driver_id AND assoc_sponsor_id=$sponsor_id");
echo("Before assocPoints");
$assocPoints = ($orgEntry->fetch_assoc())['assoc_points'];

$updateSponsorQuery = "UPDATE drivers SET associated_sponsor=?, driver_points=? WHERE driver_id=$driver_id";
$updateSponsorSTMT = $conn->prepare($updateSponsorQuery);
$updateSponsorSTMT->bind_param("si", $sponsor_name, $assocPoints);

if ($updateSponsorSTMT->execute()) {
    echo '<script>alert("Successfully switched sponsors!\n")</script>';
    echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/account/driverhomepage.php"</script>';
}
else{
    echo '<script>alert("Failed to switch sponsors...")</script>';
    echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/account/driverhomepage.php"</script>';
}
?>

</body>
</html>