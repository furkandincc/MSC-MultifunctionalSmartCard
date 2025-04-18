<?php
if (isset($_POST["login-submit"])) {
    echo "Checkpoint 1";  // Add more checkpoints as needed

    require "connection.php";

    echo "Checkpoint 2";  // Add more checkpoints as needed

    $uid = $_POST["userID"];
    $pswd = $_POST["pass"];

    echo "Checkpoint 3";  // Add more checkpoints as needed

    if (empty($uid) || empty($pswd)) {
        header("Location:staff.login.php?error=emptyfields");
        exit();
    } else {
        echo "Checkpoint 4";  // Add more checkpoints as needed

        $sql = "SELECT * FROM `staff_login` WHERE s_ssn=?";
        $stmt = mysqli_stmt_init($conn);

        echo "Checkpoint 5";  // Add more checkpoints as needed

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:staff.login.php?error=sqlerror");
            exit();
        } else {
            echo "Checkpoint 6";  // Add more checkpoints as needed

            mysqli_stmt_bind_param($stmt, "s", $uid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            echo "Checkpoint 7";  // Add more checkpoints as needed

            if ($row = mysqli_fetch_assoc($result)) {
                echo "Checkpoint 8";  // Add more checkpoints as needed

                if ($pswd !== $row["pass"]) {
                    header("Location:staff.login.php?error=wrongpass");
                    exit();
                } elseif ($pswd == $row["pass"]) {
                    echo "Checkpoint 9";  // Add more checkpoints as needed

                    session_start();
                    $_SESSION["userID"] = $row["s_ssn"];
                    $_SESSION["uc"] = "3";

                    // Debugging statement to log UID and redirect URL
                    error_log("Debug: UID = $uid, Redirecting to sdashboard.php?id=" . urlencode($uid));

                    echo "Checkpoint 10";  // Add more checkpoints as needed

                    // Redirect to sdashboard.php with the specified ID
                    header("Location:sdashboard.php?id=" . urlencode($uid));
                    exit();
                } else {
                    echo "Checkpoint 11";  // Add more checkpoints as needed

                    header("Location:staff.login.php?error=wrongpass");
                    exit();
                }
            } else {
                echo "Checkpoint 12";  // Add more checkpoints as needed

                header("Location:staff.login.php?error=nouser");
                exit();
            }
        }
    }
} else {
    echo "Checkpoint 13";  // Add more checkpoints as needed

    header("Location:index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Add your head content here -->
</head>

<body>

    <form id="login-form" action="staff_login.process.php" method="post" onsubmit="return validateForm()">
        <!-- Your login form fields go here -->
        <input type="text" name="userID" placeholder="User ID">
        <input type="password" name="pass" placeholder="Password">
        <button type="submit" name="login-submit">Login</button>
    </form>

    <script>
        function validateForm() {
            // You can add additional validation here if needed
            return true;
        }
    </script>

</body>

</html>
