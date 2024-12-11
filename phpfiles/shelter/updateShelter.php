<?php
session_start();

if (!isset($_SESSION["Shelter_ID"])) {
    echo "Shelter_ID is not set in session.";
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../config.php";

$Shelter_name = $phone_number = $Street = $City = $State = $Zip = " ";
$name_err = $phone_err = $street_err = $city_err = $state_err = $zip_err = "";

if (isset($_GET["Shelter_ID"]) && !empty(trim($_GET["Shelter_ID"]))) {
    $_SESSION["Shelter_ID"] = $_GET["Shelter_ID"];

    $sql1 = "SELECT * FROM shelter WHERE Shelter_ID = ?";

    if ($stmt1 = mysqli_prepare($link, $sql1)) {
        mysqli_stmt_bind_param($stmt1, "s", $param_Shelter_ID);
        $param_Shelter_ID = trim($_GET["Shelter_ID"]);

        if (mysqli_stmt_execute($stmt1)) {
            $result1 = mysqli_stmt_get_result($stmt1);
            if (mysqli_num_rows($result1) > 0) {
                $row = mysqli_fetch_array($result1);
                $Shelter_name = $row['Shelter_name'];
                $phone_number = $row['phone_number'];
                $Street = $row['Street'];
                $City = $row['City'];
                $State = $row['State'];
                $Zip = $row['Zip'];
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Shelter_ID = $_SESSION["Shelter_ID"];

    $Shelter_name = trim($_POST["Shelter_name"]);
    if (empty($Shelter_name)) {
        $name_err = "Please enter the shelter name.";
    }

    $phone_number = trim($_POST["phone_number"]);
    if (empty($phone_number)) {
        $phone_err = "Please enter the phone number.";
    }

    $Street = trim($_POST["Street"]);
    if (empty($Street)) {
        $street_err = "Please enter the street.";
    }

    $City = trim($_POST["City"]);
    if (empty($City)) {
        $city_err = "Please enter the city.";
    }

    $State = trim($_POST["State"]);
    if (empty($State)) {
        $state_err = "Please enter the state.";
    }

    $Zip = trim($_POST["Zip"]);
    if (empty($Zip)) {
        $zip_err = "Please enter the zip code.";
    }

    if (empty($name_err) && empty($phone_err) && empty($street_err) && empty($city_err) && empty($state_err) && empty($zip_err)) {
        $sql = "UPDATE shelter SET Shelter_name=?, phone_number=?, Street=?, City=?, State=?, Zip=? WHERE Shelter_ID=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_name, $param_phone, $param_street, $param_city, $param_state, $param_zip, $param_Shelter_ID);
            
            $param_name = $Shelter_name;
            $param_phone = $phone_number;
            $param_street = $Street;
            $param_city = $City;
            $param_state = $State;
            $param_zip = $Zip;
            $param_Shelter_ID = $Shelter_ID;

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
    <title>Update Shelter</title>
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
                        <h3>Update Record for Shelter <?php echo $_GET["Shelter_ID"]; ?> </h3>
                    </div>
                    <p>Please edit the input values and submit to update.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Shelter Name</label>
                            <input type="text" name="Shelter_name" class="form-control" value="<?php echo $Shelter_name; ?>">
                            <span class="help-block"><?php echo $name_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                            <label>Phone Number</label>
                            <input type="text" name="phone_number" class="form-control" value="<?php echo $phone_number; ?>">
                            <span class="help-block"><?php echo $phone_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($street_err)) ? 'has-error' : ''; ?>">
                            <label>Street</label>
                            <input type="text" name="Street" class="form-control" value="<?php echo $Street; ?>">
                            <span class="help-block"><?php echo $street_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                            <label>City</label>
                            <input type="text" name="City" class="form-control" value="<?php echo $City; ?>">
                            <span class="help-block"><?php echo $city_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($state_err)) ? 'has-error' : ''; ?>">
                            <label>State</label>
                            <input type="text" name="State" class="form-control" value="<?php echo $State; ?>">
                            <span class="help-block"><?php echo $state_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($zip_err)) ? 'has-error' : ''; ?>">
                            <label>Zip</label>
                            <input type="text" name="Zip" class="form-control" value="<?php echo $Zip; ?>">
                            <span class="help-block"><?php echo $zip_err; ?></span>
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