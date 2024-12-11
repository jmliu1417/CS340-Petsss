<?php
session_start();

if (!isset($_SESSION["Volunteer_ID"])) {
    echo "Volunteer_ID is not set in session.";
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../config.php";

$Volunteer_fname = $Volunteer_lname = $Volunteer_phone_number = " ";
$fname_err = $lname_err = $phone_err = "";

if (isset($_GET["Volunteer_ID"]) && !empty(trim($_GET["Volunteer_ID"]))) {
    $_SESSION["Volunteer_ID"] = $_GET["Volunteer_ID"];

    $sql1 = "SELECT * FROM volunteer WHERE Volunteer_ID = ?";

    if ($stmt1 = mysqli_prepare($link, $sql1)) {
        mysqli_stmt_bind_param($stmt1, "s", $param_Volunteer_ID);
        $param_Volunteer_ID = trim($_GET["Volunteer_ID"]);

        if (mysqli_stmt_execute($stmt1)) {
            $result1 = mysqli_stmt_get_result($stmt1);
            if (mysqli_num_rows($result1) > 0) {
                $row = mysqli_fetch_array($result1);
                $Volunteer_fname = $row['Volunteer_fname'];
                $Volunteer_lname = $row['Volunteer_lname'];
                $Volunteer_phone_number = $row['Volunteer_phone_number'];
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Volunteer_ID = $_SESSION["Volunteer_ID"];

    $Volunteer_fname = trim($_POST["Volunteer_fname"]);
    if (empty($Volunteer_fname)) {
        $fname_err = "Please enter a first name.";
    }

    $Volunteer_lname = trim($_POST["Volunteer_lname"]);
    if (empty($Volunteer_lname)) {
        $lname_err = "Please enter a last name.";
    }

    $Volunteer_phone_number = trim($_POST["Volunteer_phone_number"]);
    if (empty($Volunteer_phone_number)) {
        $phone_err = "Please enter a phone number.";
    }

    if (empty($fname_err) && empty($lname_err) && empty($phone_err)) {
        $sql = "UPDATE volunteer SET Volunteer_fname=?, Volunteer_lname=?, Volunteer_phone_number=? WHERE Volunteer_ID=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssi", $param_fname, $param_lname, $param_phone, $param_Volunteer_ID);
            
            $param_fname = $Volunteer_fname;
            $param_lname = $Volunteer_lname;
            $param_phone = $Volunteer_phone_number;
            $param_Volunteer_ID = $Volunteer_ID;

            if (mysqli_stmt_execute($stmt)) {
                header("location: ../index.php");
                exit();
            } else {
                echo "<center><h2>Error when updating</center></h2>";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Volunteer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h3>Update Record for Volunteer <?php echo $_GET["Volunteer_ID"]; ?> </h3>
                    </div>
                    <p>Please edit the input values and submit to update.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($fname_err)) ? 'has-error' : ''; ?>">
                            <label>First Name</label>
                            <input type="text" name="Volunteer_fname" class="form-control" value="<?php echo $Volunteer_fname; ?>">
                            <span class="help-block"><?php echo $fname_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($lname_err)) ? 'has-error' : ''; ?>">
                            <label>Last Name</label>
                            <input type="text" name="Volunteer_lname" class="form-control" value="<?php echo $Volunteer_lname; ?>">
                            <span class="help-block"><?php echo $lname_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                            <label>Phone Number</label>
                            <input type="text" name="Volunteer_phone_number" class="form-control" value="<?php echo $Volunteer_phone_number; ?>">
                            <span class="help-block"><?php echo $phone_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
