<?php
 session_start();
 if(!$_SESSION["userID"])
 {
   header("Location:doctor.login.php");
 }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon" sizes="180x180" href="Resource/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="Resource/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="Resource/favicon/favicon-16x16.png">
  <link rel="manifest" href="Resource/favicon/site.webmanifest">
  <title>Dashboard</title>
  <style>
    * {
      margin: 0;
      padding: 0;
    }

    body {
      font-family: "Jost", sans-serif;
    }

    .top_img {
      width: 100%;
      background-color: #f9f9f3;
      text-align: center;
    }

    .top_img img {
      max-width: 100%;
      height: auto;
      margin: 5px auto;
    }

    .navigation-bar {
      background-color: black;
      overflow: hidden;
      height: 90px;
      text-align: center;
    }

    .navigation-bar a {
      display: inline-block;
      font-size: 16px;
      text-decoration: none;
      color: #ece2c1;
      padding: 30px 15px;
      margin: 0 10px;
    }

    .navigation-bar a:hover {
      background-color: #f1f1f1;
      color: black;
    }

    .welcome_mssg {
      font-family: "Barlow Condensed", sans-serif;
      font-size: 35px;
      background: #f9f9f3;
      text-align: center;
      padding: 20px;
    }

    .pi_table,
    .ci_table {
      width: 100%;
      padding: 20px;
    }

    .pi_table h3,
    .ci_table h3 {
      margin: 2%;
      text-align: left;
      font-size: 20px;
    }

    .pi_table table,
    .ci_table table {
      width: 100%;
      text-align: left;
      border-spacing: 10px;
    }

    .pi_table table td,
    .ci_table table td {
      font-size: 16px;
    }

    .ci_table a {
      display: inline-block;
      background: black;
      padding: 10px 20px;
      margin-left: 5px;
      text-decoration: none;
      font-family: "Nunito", sans-serif;
      font-size: 15px;
      color: #f1f1f1;
      border: 1px solid #f1f1f1;
      border-radius: 40px;
      outline: none;
    }

    .ci_table a:hover {
      background: #f1f1f1;
      color: black;
    }

    .res_div {
      width: 100%;
      height: 20%;
      text-align: center;
      margin-top: 30px;
    }

    .res {
      display: inline-block;
      background: #f9f9f9;
      padding: 10px;
      margin-left: auto;
      margin-right: auto;
      text-decoration: none;
      font-family: "Nunito", sans-serif;
      font-size: 15px;
      color: black;
      border: 1px solid black;
      border-radius: 40px;
      outline: none;
    }

    .res:hover {
      background: black;
      color: #f1f1f1;
    }

    .footer {
      margin-bottom: 80px;
    }
  </style>
</head>
<body>
  <div class="top_img"><img src="Resource/landd2.png" alt="Logo"></div>
  <div class="navigation-bar">
    <a href="ddashboard.php">Home</a>
    <a href="drecords.php">Records</a>
    <a href="dsearch.php">Search</a>
    <a href="dinsert.php">Insert</a>
    <a class='logout' href="logout.php">Logout</a>
  </div>

  <?php
    require "connection.php";
    $uid=$_SESSION["userID"];
    $sql="SELECT SSN, F_Name, CONCAT(F_Name,' ',L_Name) AS Full_name, d.Address, Contact_No, d.Email,h.name, Department, Speciality,Designation FROM doctor d, hospital h WHERE d.Hospital_ID=h.ID AND SSN=?";
    $stmt= mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
      header("Location:ddashboard.php?error=sqlerror");
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $uid);
      mysqli_stmt_execute($stmt);
      $result= mysqli_stmt_get_result($stmt);
      if ($row = mysqli_fetch_assoc($result))
      {
        $ssn=$row["SSN"];
        $fname=strtoupper($row["F_Name"]);
        $fullname=$row["Full_name"];
        $address=$row["Address"];
        $cont=$row["Contact_No"];
        $mail=$row["Email"];
        $hname=$row["name"];
        $dep=$row["Department"];
        $desg=$row["Designation"];
        $spec=$row["Speciality"];
        echo "
          <div class='welcome'><h2 class='welcome_mssg'> GREETINGS $fname</h2></div>

          <div class='pi_box'>
            <div class='pi_table'>
            <h3> Personal Info</h3>
              <table>
                <tr><th>FULL NAME</th>
                    <td>$fullname</td></tr>
                <tr><th>HOSPITAL NAME</th>
                   <td>$hname</td></tr>
                <tr><th>DEPARTMENT</th>
                    <td>$dep</td></tr>
                <tr><th>DESIGNATION</th>
                   <td>$desg</td></tr>
               <tr><th>SPECIALITY</th>
                  <td>$spec</td></tr>
              </table>
            </div>
          </div>

          <div class='ci_box'>
            <div class='ci_table'>
            <h3> Contact Info</h3>
              <table>
                <tr><th>ADDRESS</th>
                    <td>$address</td></tr>
                <tr><th>CONTACT NO</th>
                   <td>$cont</td></tr>
                <tr><th>E-MAIL</th>
                   <td>$mail</td></tr>
              </table>
              <a href='doctor_info_edit.php'>Edit</a>
            </div>
          </div>
          <div class='res_div'><a class='res' href='d_res_pass.php'>Reset Password</a></div>
        <div class='footer'></div>
        ";
      }
    }
   ?>
</body>
</html>
