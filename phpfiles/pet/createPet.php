<?php
require_once "../config.php";

$Pet_ID = $Pet_name = $Pet_type = $Pet_breed = $Pet_age = $Pet_status = $Shelter_ID = $Adopter_ID = "";
$Pet_ID_err = $Pet_name_err = $Pet_type_err = $Pet_breed_err = $Pet_age_err = $Pet_status_err = $Shelter_ID_err = $Adopter_ID_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Pet_ID
    $Pet_ID = trim($_POST["Pet_ID"]);
    if (empty($Pet_ID)) {
        $Pet_ID_err = "Please enter a Pet ID.";
    } else {
        $sql = "SELECT Pet_ID FROM pet WHERE Pet_ID = ?";
        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("s", $Pet_ID);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $Pet_ID_err = "This Pet ID is already taken.";
                }
            }
            $stmt->close();
        }
    }

    // Validate Pet_name
    $Pet_name = trim($_POST["Pet_name"]);
    if (empty($Pet_name)) {
        $Pet_name_err = "Please enter a name for the pet.";
    }elseif(!filter_var($Pet_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Pet_name_err = "Please enter a valid First Name.";}

    // Validate Pet_type
    $Pet_type = trim($_POST["Pet_type"]);
    if (empty($Pet_type)) {
        $Pet_type_err = "Please enter the type of pet.";
    }

    // Validate Pet_breed
    $Pet_breed = trim($_POST["Pet_breed"]);
    if (empty($Pet_breed)) {
        $Pet_breed_err = "Please enter the breed of the pet.";
    }

    // Validate Pet_age
    $Pet_age = trim($_POST["Pet_age"]);
    if (empty($Pet_age) || !is_numeric($Pet_age)) {
        $Pet_age_err = "Please enter a valid age.";
    }

    // Validate Pet_status
    $Pet_status = trim($_POST["Pet_status"]);
    if (empty($Pet_status)) {
        $Pet_status_err = "Please enter the status of the pet.";
    }

    // Validate Shelter_ID
    $Shelter_ID = trim($_POST["Shelter_ID"]);
    if (empty($Shelter_ID)) {
        $Shelter_ID_err = "Please enter a Shelter ID.";
    }

    // Validate Adopter_ID (optional)
    $Adopter_ID = !empty(trim($_POST["Adopter_ID"])) ? trim($_POST["Adopter_ID"]) : null;


    // Check for errors before inserting into database
    if (empty($Pet_ID_err) && empty($Pet_name_err) && empty($Pet_type_err) && empty($Pet_breed_err) && 
        empty($Pet_age_err) && empty($Pet_status_err) && empty($Shelter_ID_err)) {
        $sql = "INSERT INTO pet (Pet_ID, Pet_name, Pet_type, Pet_breed, Pet_age, Pet_status, Shelter_ID, Adopter_ID) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("ssssssss", $Pet_ID, $Pet_name, $Pet_type, $Pet_breed, $Pet_age, $Pet_status, $Shelter_ID, $Adopter_ID);
            if ($stmt->execute()) {
                header("location: ../index.php");
                exit();
            } else {
                echo "Something went wrong. Please provide vaild entries and try again later.";
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
    <title>Add Pet</title>
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
        <h2>Add Pet</h2>
        <p>Please fill this form to add a new pet record.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($Pet_ID_err)) ? 'has-error' : ''; ?>">
                <label>Pet ID</label>
                <input type="number" name="Pet_ID" class="form-control" value="<?php echo $Pet_ID; ?>">
                <span class="help-block"><?php echo $Pet_ID_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Pet_name_err)) ? 'has-error' : ''; ?>">
                <label>Pet Name</label>
                <input type="text" name="Pet_name" class="form-control" value="<?php echo $Pet_name; ?>">
                <span class="help-block"><?php echo $Pet_name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Pet_type_err)) ? 'has-error' : ''; ?>">
                <label>Pet Type</label>
                <input type="text" name="Pet_type" class="form-control" value="<?php echo $Pet_type; ?>">
                <span class="help-block"><?php echo $Pet_type_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Pet_breed_err)) ? 'has-error' : ''; ?>">
                <label>Pet Breed</label>
                <input type="text" name="Pet_breed" class="form-control" value="<?php echo $Pet_breed; ?>">
                <span class="help-block"><?php echo $Pet_breed_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Pet_age_err)) ? 'has-error' : ''; ?>">
                <label>Pet Age</label>
                <input type="number" name="Pet_age" class="form-control" value="<?php echo $Pet_age; ?>">
                <span class="help-block"><?php echo $Pet_age_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Pet_status_err)) ? 'has-error' : ''; ?>">
                <label>Pet Status</label>
                <input type="text" name="Pet_status" class="form-control" value="<?php echo $Pet_status; ?>">
                <span class="help-block"><?php echo $Pet_status_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Shelter_ID_err)) ? 'has-error' : ''; ?>">
                <label>Shelter ID</label>
                <input type="number" name="Shelter_ID" class="form-control" value="<?php echo $Shelter_ID; ?>">
                <span class="help-block"><?php echo $Shelter_ID_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Adopter_ID_err)) ? 'has-error' : ''; ?>">
                <label>Adopter ID (Optional)</label>
                <input type="number" name="Adopter_ID" class="form-control" value="<?php echo $Adopter_ID; ?>">
                <span class="help-block"><?php echo $Adopter_ID_err; ?></span>
            </div>
            <input type="submit" class="btn btn-primary" value="Submit">
            <a href="../index.php" class="btn btn-default">Cancel</a>
        </form>
    </div>
</body>
</html>

