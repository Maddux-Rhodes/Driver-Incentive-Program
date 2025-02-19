<?php include "../../../inc/dbinfo.inc"; ?>
<?php
  session_start();
  if(!$_SESSION['login'] || strcmp($_SESSION['account_type'], "administrator") != 0) {
    echo "Invalid page.<br>";
    echo "Redirecting.....";
    sleep(2);
    header( "Location: http://team05sif.cpsc4911.com/", true, 303);
    exit();
    //unset($_SESSION['login']);
  }
?>
<html>
<body>

<?php
// Create connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {  
    echo "Database connection failed.";  
}  

// Get query variables from POST
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // this hashes the password. use password_verify to compare hash to password
$birthday = $_POST['birthday'];
$phone = $_POST['phone'];
$regDateTime = new DateTime('now');
$regDate = $regDateTime->format('Y-m-d');
$archived = 0;
$user_type = 'administrator';

// Create queries to check for taken account info (username, email, etc)
$username_query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$email_query = mysqli_query($conn, "SELECT * FROM administrators WHERE administrator_email='$email'");
$phone_query = mysqli_query($conn, "SELECT * FROM administrators WHERE administrator_phone_number='$phone'");

// Function to check for valid dates
function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

// Check for taken/invalid account info
if ($username_query->fetch_row()){
    echo '<script>alert("This username is already taken!\n\nPlease choose a different username and retry...")</script>';
    echo '<script>window.location.href = "admin_account_creation.php"</script>';
} elseif ($email_query->fetch_row()){
    echo '<script>alert("This email is already in use!\n\nPlease choose a different email and retry...")</script>';
    echo '<script>window.location.href = "admin_account_creation.php"</script>';
} elseif ($phone_query->fetch_row()){
    echo '<script>alert("This phone number is already in use!\n\nPlease choose a different phone number and retry...")</script>';
    echo '<script>window.location.href = "admin_account_creation.php"</script>';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo '<script>alert("Invalid email address format!\n\nPlease enter in a valid email address and retry...")</script>';
    echo '<script>window.location.href = "admin_account_creation.php"</script>';
} elseif (validateDate($birthday) == false) {
    echo '<script>alert("Invalid birthdate entered!\n\nPlease enter in a valid birthdate and retry...")</script>';
    echo '<script>window.location.href = "admin_account_creation.php"</script>';
} elseif (strlen($_POST['password']) < 8) {
    echo '<script>alert("Invalid password entered!\n\nYour password needs to be at least 8 characters long...")</script>';
    echo '<script>window.location.href = "admin_account_creation.php"</script>';
} else{
    // Prepare query on admins table
    $company_name = $username . " (ADMIN)";
    $sql_admins = "INSERT INTO administrators (administrator_first_name, administrator_last_name, administrator_username, administrator_email, administrator_password, administrator_birthday, administrator_phone_number, administrator_archived, administrator_associated_sponsor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_admins = $conn->prepare($sql_admins);
    $stmt_admins->bind_param("sssssssis", $fname, $lname, $username, $email, $password, $birthday, $phone, $archived, $company_name);

    // Prepare query on users table
    $sql_users = "INSERT INTO users (username, user_type, user_email, user_view_type) VALUES (?, ?, ?, ?)";
    $stmt_users = $conn->prepare($sql_users);
    $stmt_users->bind_param("ssss", $username, $user_type, $email, $user_type);

    $sql_org = "INSERT INTO organizations (organization_username, organization_archived) VALUES (?, ?)";
    $stmt_org = $conn->prepare($sql_org);
    $stmt_org->bind_param("si", $company_name, $archived);

    if ($stmt_admins->execute() && $stmt_users->execute() && $stmt_org->execute()) {
        echo '<script>alert("Your account is ready!\n\nRedirecting to login page...")</script>';
        echo '<script>window.location.href = "login.php"</script>';
    }
    else{
        echo '<script>alert("Failed to create account...\n\nCheck your information and retry...")</script>';
        echo '<script>window.location.href = "admin_account_creation.php"</script>';
    }
}
?>

</body>
</html>