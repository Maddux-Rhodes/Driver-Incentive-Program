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

$order_status = "Cancelled";
$order_id = $_POST['order_id'];
$order_point_cost = $_POST['order_point_cost'];

$regDateTime = new DateTime('now');
$regDate = $regDateTime->format("Y-m-d H:i:s");

$sql_orders = "UPDATE orders SET order_status=? WHERE order_id='$order_id'";
$stmt_orders = $connection->prepare($sql_orders);
$stmt_orders->bind_param("s", $order_status);

$driver_info = mysqli_query($connection, "SELECT * FROM drivers");

while($rows=$driver_info->fetch_assoc()) { 
    if($rows['driver_username'] == $_SESSION['username']) {
        $driver_id = $rows['driver_id'];
        $driver_points = $rows['driver_points'];
    }
}

$new_points = $driver_points + $order_point_cost;

$sql_point_update = "UPDATE drivers SET driver_points=? WHERE driver_id='$driver_id'";
$stmt_point_update = $connection->prepare($sql_point_update);
$stmt_point_update->bind_param("i", $new_points);

$reason = "Order-{$order_id} was cancelled.";
$username = $_SESSION['username'];
$sql_audit = "INSERT INTO audit_log_point_changes (audit_log_point_changes_username, audit_log_point_changes_date, audit_log_point_changes_reason, audit_log_point_changes_number) VALUES (?, ?, ?, ?)";
$stmt_audit = $conn->prepare($sql_audit);
$stmt_audit->bind_param("ssss", $username, $regDate, $reason, $order_point_cost);

if ($stmt_orders->execute() && $stmt_point_update->execute() && $stmt_audit->execute()) {
    echo '<script>alert("Order successfully cancelled!\n")</script>';
    echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/order/order_history.php"</script>';
}
?>