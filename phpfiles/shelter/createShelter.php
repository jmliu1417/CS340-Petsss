<?php
require_once "../config.php";

$Shelter_ID = $Shelter_name = $phone_number = $Street = $City = $State = $Zip = "";
$Shelter_ID_err = $Shelter_name_err = $phone_number_err = $Street_err = $City_err = $State_err = $Zip_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Shelter_ID
    $Shelter_ID = trim($_POST["Shelter_ID"]);
    if (empty($Shelter_ID)) {
        $Shelter_ID_err = "Please enter a Shelter ID.";
    } else {
        $sql = "SELECT Shelter_ID FROM shelter WHERE Shelter_ID = ?";
        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("i", $Shelter_ID);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $Shelter_ID_err = "This Shelter ID is already taken.";
                }
            }
            $stmt->close();
        }
    }

    // Validate Shelter_name
    $Shelter_name = trim($_POST["Shelter_name"]);
    if (empty($Shelter_name)) {
        $Shelter_name_err = "Please enter the shelter name.";
    }

    // Validate phone_number
    $phone_number = trim($_POST["phone_number"]);
    if (empty($phone_number)) {
        $phone_number_err = "Please enter the phone number.";
    }

    // Validate Street
    $Street = trim($_POST["Street"]);
    if (empty($Street)) {
        $Street_err = "Please enter the street address.";
    }

    // Validate City
    $City = trim($_POST["City"]);
    if (empty($City)) {
        $City_err = "Please enter the city.";
    }

    // Validate State
    $State = trim($_POST["State"]);
    if (empty($State)) {
        $State_err = "Please enter the state.";
    }

    // Validate Zip
    $Zip = trim($_POST["Zip"]);
    if (empty($Zip) || !is_numeric($Zip)) {
        $Zip_err = "Please enter a valid ZIP code.";
    }

    // Check for errors before inserting into database
    if (empty($Shelter_ID_err) && empty($Shelter_name_err) && empty($phone_number_err) &&
        empty($Street_err) && empty($City_err) && empty($State_err) && empty($Zip_err)) {
        $sql = "INSERT INTO shelter (Shelter_ID, Shelter_name, phone_number, Street, City, State, Zip) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("isssssi", $Shelter_ID, $Shelter_name, $phone_number, $Street, $City, $State, $Zip);
            if ($stmt->execute()) {
                header("location: ../index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $link->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Shelter</title>
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
        <h2>Add Shelter</h2>
        <p>Please fill this form to add a new shelter record.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($Shelter_ID_err)) ? 'has-error' : ''; ?>">
                <label>Shelter ID</label>
                <input type="number" name="Shelter_ID" class="form-control" value="<?php echo $Shelter_ID; ?>">
                <span class="help-block"><?php echo $Shelter_ID_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Shelter_name_err)) ? 'has-error' : ''; ?>">
                <label>Shelter Name</label>
                <input type="text" name="Shelter_name" class="form-control" value="<?php echo $Shelter_name; ?>">
                <span class="help-block"><?php echo $Shelter_name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($phone_number_err)) ? 'has-error' : ''; ?>">
                <label>Phone Number</label>
                <input type="text" name="phone_number" class="form-control" value="<?php echo $phone_number; ?>">
                <span class="help-block"><?php echo $phone_number_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Street_err)) ? 'has-error' : ''; ?>">
                <label>Street</label>
                <input type="text" name="Street" class="form-control" value="<?php echo $Street; ?>">
                <span class="help-block"><?php echo $Street_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($City_err)) ? 'has-error' : ''; ?>">
                <label>City</label>
                <input type="text" name="City" class="form-control" value="<?php echo $City; ?>">
                <span class="help-block"><?php echo $City_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($State_err)) ? 'has-error' : ''; ?>">
                <label>State</label>
                <input type="text" name="State" class="form-control" value="<?php echo $State; ?>">
                <span class="help-block"><?php echo $State_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Zip_err)) ? 'has-error' : ''; ?>">
                <label>ZIP</label>
                <input type="number" name="Zip" class="form-control" value="<?php echo $Zip; ?>">
                <span class="help-block"><?php echo $Zip_err; ?></span>
            </div>
            <input type="submit" class="btn btn-primary" value="Submit">
            <a href="../index.php" class="btn btn-default">Cancel</a>
        </form>
    </div>
</body>
</html>
