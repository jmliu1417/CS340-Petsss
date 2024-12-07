<!DOCTYPE html>
<html>
    <head>
        <title>Update Shelter</title>
    </head>

<body>
        <h2>Update Adopter information</h2>
    <p>Please fill in this form and select "update"</p>
    <form action="process-form.php" method="post">
        <p>
            <label for="inputFName">First name:<sup>*</sup></label>
            <input type="text" name="fname" id="inputFName">
        </p>
        <p>
            <label for="inputLName">Last name:<sup>*</sup></label>
            <input type="text" name="lname" id="inputLName">
        </p>
        <p>
            <label for="inputDOB">Date:</label>
            <input type="date" name="DOB" id="inputDate" value="2024-12-06" min="1900-01-01" max="2026-12-31">
        </p>
        <p>
            <label for="inputStreet">Street:<sup>*</sup></label>
            <textarea name="street" id="inputStreet"></textarea>
        </p>
        <p>
            <label for="inputCity">City:<sup>*</sup></label>
            <input type="text" name="city" id="inputCity">
        </p>
        <p>
            <label for="inputState">State:<sup>*</sup></label>
            <input type="text" name="state" id="inputState">
        </p>
        <p>
            <label for="inputZip">Zip:<sup>*</sup></label>
            <input type="text" name="zip" id="inputZip">
        </p>
        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
    </form>

</body>
</html> 

<?php

require_once "config.php";

$Adopter_fname = $Adopter_lname = $Street = $State = " ";
// $Adopter_ID = $Zip = 0;
$Adopter_DOB = '00-00-0000';

$name_err = "";

// if(isset($_POST[]))

if(isset($_POST["Adopter_ID"]) && !empty($_POST["Adopter_ID"])){
    // Get hidden input value
    $Adopter_ID = $_POST["Adopter_ID"];

    //validate name
    $input_fname = trim($_POST["Adopter_fname"]);
    if(empty($input_fname)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $Adopter_fname = $input_fname;
    }

}