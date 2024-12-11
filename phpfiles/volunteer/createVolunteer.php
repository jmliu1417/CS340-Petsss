<?php
require_once "../config.php";

$Volunteer_ID = $Volunteer_fname = $Volunteer_lname = $Volunteer_phone_number = "";
$Volunteer_ID_err = $Volunteer_fname_err = $Volunteer_lname_err = $Volunteer_phone_number_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Volunteer_ID = trim($_POST["Volunteer_ID"]);
    if (empty($Volunteer_ID)) {
        $Volunteer_ID_err = "Please enter a Volunteer ID.";
    } else {
        $sql = "SELECT Volunteer_ID FROM volunteer WHERE Volunteer_ID = ?";
        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("s", $Volunteer_ID);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $Volunteer_ID_err = "This Volunteer ID is already taken.";
                }
            }
            $stmt->close();
        }
    }

    $Volunteer_fname = trim($_POST["Volunteer_fname"]);
    if (empty($Volunteer_fname)) {
        $Volunteer_fname_err = "Please enter a First Name.";
    } elseif (!filter_var($Volunteer_fname, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $Volunteer_fname_err = "Please enter a valid First Name.";
    }

    $Volunteer_lname = trim($_POST["Volunteer_lname"]);
    if (empty($Volunteer_lname)) {
        $Volunteer_lname_err = "Please enter a Last Name.";
    } elseif (!filter_var($Volunteer_lname, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $Volunteer_lname_err = "Please enter a valid Last Name.";
    }

    $Volunteer_phone_number = trim($_POST["Volunteer_phone_number"]);
    if (empty($Volunteer_phone_number)) {
        $Volunteer_phone_number_err = "Please enter a Phone Number.";
    } elseif (!preg_match("/^\d{10}$/", $Volunteer_phone_number)) {
        $Volunteer_phone_number_err = "Please enter a valid 10-digit Phone Number.";
    }

    if (empty($Volunteer_ID_err) && empty($Volunteer_fname_err) && empty($Volunteer_lname_err) && empty($Volunteer_phone_number_err)) {
        $sql = "INSERT INTO volunteer (Volunteer_ID, Volunteer_fname, Volunteer_lname, Volunteer_phone_number) VALUES (?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssss", 
            $param_Volunteer_ID, $param_Volunteer_fname, $param_Volunteer_lname, $param_Volunteer_phone_number);

            $param_Volunteer_ID = $Volunteer_ID;
            $param_Volunteer_fname = $Volunteer_fname;
            $param_Volunteer_lname = $Volunteer_lname;
            $param_Volunteer_phone_number = $Volunteer_phone_number;

            if (mysqli_stmt_execute($stmt)) {
                header("location: ../index.php");
                exit();
            } else {
                echo "<center><h4>Error while adding new volunteer</h4></center>";
                //$Volunteer_ID_err = "The Volunteer ID is already taken. Please use a unique ID.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create Volunteer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 70%;
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
                    <h2>Create Volunteer</h2>
                </div>
                <p>Please fill this form to add a volunteer record.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($Volunteer_ID_err)) ? 'has-error' : ''; ?>">
                        <label>Volunteer ID</label>
                        <input type="number" name="Volunteer_ID" class="form-control" value="<?php echo htmlspecialchars($Volunteer_ID); ?>" min="1">
                        <span class="help-block"><?php echo $Volunteer_ID_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($Volunteer_fname_err)) ? 'has-error' : ''; ?>">
                        <label>First Name</label>
                        <input type="text" name="Volunteer_fname" class="form-control" value="<?php echo htmlspecialchars($Volunteer_fname); ?>">
                        <span class="help-block"><?php echo $Volunteer_fname_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($Volunteer_lname_err)) ? 'has-error' : ''; ?>">
                        <label>Last Name</label>
                        <input type="text" name="Volunteer_lname" class="form-control" value="<?php echo htmlspecialchars($Volunteer_lname); ?>">
                        <span class="help-block"><?php echo $Volunteer_lname_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($Volunteer_phone_number_err)) ? 'has-error' : ''; ?>">
                        <label>Phone Number</label>
                        <input type="text" name="Volunteer_phone_number" class="form-control" value="<?php echo htmlspecialchars($Volunteer_phone_number); ?>">
                        <span class="help-block"><?php echo $Volunteer_phone_number_err; ?></span>
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