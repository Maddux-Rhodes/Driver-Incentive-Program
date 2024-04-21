<?php include "../../../inc/dbinfo.inc"; 
session_start();?>
<style>
    body {
        background-color: #fff5d1;
    }
    /* Table formatting from https://www.w3schools.com/css/css_table.asp */
    #point-details {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #point-details td, #point-details th {
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }

    #point-details tr:nth-child(even){background-color: #f2f2f2;}
    #point-details tr:nth-child(odd){background-color: white;}

    #point-details tr:hover {background-color: #ddd;}

    #point-details th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #b8a97b;
        color: white;
    }

    .navbar {
    overflow: hidden;
    background-color: #FEF9E6;
    font-family: "Monaco", monospace;
    margin-bottom: 1.5%
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
    padding: 14px 16px;
    background-color: inherit;
    font-family: inherit;
    margin: 0;
    } 
    
</style>


<div class="navbar">
  <div class="menu">
    <a href="/S24-Team05/account/homepageredirect.php">Home</a>
    <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
    <a href="/S24-Team05/account/logout.php">Logout</a>
    <a href="/S24-Team05/admin_about_page.php">About</a>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Audit Log 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="/S24-Team05/audit/logins.php">Login Attempts - All </a>
      <a href="/S24-Team05/audit/logins_all_drivers.php">Login Attempts - Drivers</a>
      <a href="/S24-Team05/audit/logins_all_sponsors.php">Login Attempts - Sponsors</a>
      <a href="/S24-Team05/audit/logins_all_admins.php">Login Attempts - Admins</a>
      <a href="/S24-Team05/audit/password_changes.php">Password Changes - All</a>
      <a href="/S24-Team05/audit/password_changes_all_drivers.php">Password Changes - Drivers</a>
      <a href="/S24-Team05/audit/password_changes_all_sponsors.php">Password Changes - Sponsors</a>
      <a href="/S24-Team05/audit/password_changes_all_admins.php">Password Changes - Admins</a>
      <a href="/S24-Team05/audit/point_changes_all_drivers.php">Point Changes - All Drivers</a>
      <a href="/S24-Team05/audit/email_changes.php">Email Changes - All</a>
      <a href="/S24-Team05/audit/username_changes.php">Username Changes - All</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Create Account
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="/S24-Team05/account/driver_account_creation.php">Driver Account</a>
      <a href="/S24-Team05/account/sponsor_account_creation.php">Sponsor Account</a>
      <a href="/S24-Team05/account/admin_account_creation.php">Admin Account</a>
    </div>
  </div>
  <div class="menu">
    <a href="/S24-Team05/account/admin_view_organizations.php">View Organizations</a>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Archive Accounts
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="/S24-Team05/account/admin_archive_account.php">Archive Account</a>
      <a href="/S24-Team05/account/admin_unarchive_account.php">Unarchive Account</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Edit User
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="/S24-Team05/account/admin_edit_driver_account.php">Edit Driver</a>
      <a href="/S24-Team05/account/admin_edit_sponsor_account.php">Edit Sponsor</a>
      <a href="/S24-Team05/account/admin_edit_admin_account.php">Edit Admin</a>
    </div>
  </div>
</div>

<?php
    //error_reporting(E_ALL);
    //ini_set('display_errors',1);
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $sponsor = $_POST['sponsor'];

    //Formats the dates so they don't cause errors when naming the CSV file.
    $start_range = $_POST['start_date'];
    $start_range = (new DateTime($start_range))->format("Y-m-d");
    $end_range = $_POST['end_date'];
    
    //Adds 23:59:59 to the end range to make it include all orders on that day.
    $end_range_format = new DateTime($end_range);
    $end_range_format->add(new DateInterval("PT23H59M59S"));
    $end_range_format = $end_range_format->format("Y-m-d H:i:s");
    
    $end_range = (new DateTime($end_range))->format("Y-m-d");

    //Opens the CSV file for writing, overwrites any existing one. 
    $test = fopen("csvs/{$start_range}_{$end_range}_summary_for_$sponsor.csv", 'w');

    $header_array = array("Summary Sales By Sponsor Report - {$sponsor}");
    fputcsv($test, $header_array);
    
    fputcsv($test, array("Sponsor", "Category", "Units", "Sales"));

    ?>
    <table id="point-details">
    <tr>
        <th colspan = "3"; style = "background-color: #857f5b"> Summary Sales By Sponsor Report - <?php echo "{$sponsor}" ?></th>
        <th style = "background-color: #857f5b;"> <?php echo "{$start_range} - {$end_range}" ?></th>
    </tr>
    <tr>
        <th>Sponsor</th>
        <th>Category</th>
        <th>Units</th>
        <th>Sales</th>
    </tr>
    <?php

    if($sponsor === "All Sponsors") {

        //Grabs the total sales from ALL SPONSORS.
        $total_sponsor_sales_query = "SELECT *, SUM(order_contents_item_cost*dollar2point) AS total_sales FROM orders 
        JOIN order_contents 
            ON orders.order_id = order_contents.order_id
        JOIN organizations 
            ON orders.order_associated_sponsor=organizations.organization_username 
                WHERE order_contents_removed = 0 AND order_date_ordered BETWEEN '$start_range' AND '$end_range_format'";
        $total_sales = mysqli_query($connection, $total_sponsor_sales_query);
        $result = $total_sales->fetch_assoc();
        $total_sales =  number_format($result['total_sales'], 2);

        //Grabs the total sales from ALL SPONSORS for each category of item.
        $total_sponsor_sales_by_item_query = "SELECT *, SUM(order_contents_item_cost*dollar2point) AS total_sales, count(order_contents_item_type) AS qty FROM orders 
        JOIN order_contents 
            ON orders.order_id = order_contents.order_id
        JOIN organizations 
            ON orders.order_associated_sponsor=organizations.organization_username WHERE order_associated_sponsor LIKE '%' 
                AND order_contents_removed = 0 AND order_date_ordered BETWEEN '$start_range' AND '$end_range_format'
            GROUP BY organization_username, order_contents_item_type";
        $total_by_item = mysqli_query($connection, $total_sponsor_sales_by_item_query);

        while($row=$total_by_item->fetch_assoc()) {
            $sales_by_item =  number_format($row['total_sales'], 2);
            $qty = $row['qty'];
            //Stores the company, item_type, and sales by item in an array to be written to the CSV.
            $temp_array = array($row['organization_username'], $row['order_contents_item_type'], $qty, $sales_by_item);
            fputcsv($test, $temp_array);
            ?>
            <tr>
                <td><?php echo "{$row['organization_username']}" ?></td>
                <td><?php echo "{$row['order_contents_item_type']}" ?></td>
                <td><?php echo $qty ?></td>
                <td><?php echo "$","{$sales_by_item}" ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td><?php echo "<b>TOTAL</b>" ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo "<b>","$","{$total_sales}</b>" ?></td>
        </tr>
        <?php
    } else {
        //Grabs the total sales from the specified sponsor.
        $total_sponsor_sales_query = "SELECT *, SUM(order_contents_item_cost*dollar2point) AS total_sales FROM orders 
        JOIN order_contents 
            ON orders.order_id = order_contents.order_id
        JOIN organizations 
            ON orders.order_associated_sponsor=organizations.organization_username 
                WHERE order_associated_sponsor='$sponsor' AND order_contents_removed = 0 AND order_date_ordered BETWEEN '$start_range' AND '$end_range_format'
            GROUP BY order_associated_sponsor";
        $total_sales = mysqli_query($connection, $total_sponsor_sales_query);
        $result = $total_sales->fetch_assoc();
        $total_sales =  number_format(  $result['total_sales'], 2);
    
        //Grabs the total sales by item from the specified sponsor.
        $total_sponsor_sales_by_item_query = "SELECT *, SUM(order_contents_item_cost*dollar2point) AS total_sales, count(order_contents_item_type) AS qty FROM orders 
        JOIN order_contents 
            ON orders.order_id = order_contents.order_id
        JOIN organizations 
            ON orders.order_associated_sponsor=organizations.organization_username WHERE order_associated_sponsor='$sponsor' 
                AND order_contents_removed = 0 AND order_date_ordered BETWEEN '$start_range' AND '$end_range_format'
            GROUP BY order_contents_item_type";
        $total_by_item = mysqli_query($connection, $total_sponsor_sales_by_item_query);
        while($row=$total_by_item->fetch_assoc()) {
            $sales_by_item =  number_format($row['total_sales'], 2);
            $qty = $row['qty'];
            //Stores the company, item_type, and sales by item in an array to be written to the CSV.
            $temp_array = array($row['organization_username'], $row['order_contents_item_type'], $qty, $sales_by_item);
            fputcsv($test, $temp_array);
            ?>
            <tr>
                <td><?php echo "{$row['organization_username']}" ?></td>
                <td><?php echo "{$row['order_contents_item_type']}" ?></td>
                <td><?php echo $qty ?></td>
                <td><?php echo "$","{$sales_by_item}" ?></td>
            </tr>
            <?php
            //echo "{$row['organization_username']}: {$row['order_contents_item_type']}s have generated $$sales_by_item.<br>";
        }
        //fputcsv($test, array($sponsor, $total_sales));
        //echo "$sponsor has generated $$total_sales. <br>";
        ?>
        <tr>
            <td><?php echo "<b>TOTAL</b>" ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo "<b>{$total_sales}</b>" ?></td>
        </tr>
        <?php
    }
    //Closes the file pointer.
    fclose($test);
?>
<a href=" <?= "http://team05sif.cpsc4911.com/S24-Team05/reporting/csvs/{$start_range}_{$end_range}_summary_for_$sponsor.csv" ?>" download> Download csv... </a>