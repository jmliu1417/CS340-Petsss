<?php

require_once "../config.php";


$Adopter_ID = $Adopter_fname = $Adopter_lname = $Adopter_dob = $Street = $City = $State = $Zip = "";
$Adopter_ID_err = $Adopter_fname_err = $Adopter_lname_err = $Adopter_dob_err = $Street_err = $City_err = $State_err = $Zip_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $Adopter_ID = trim($_POST["Adopter_ID"]);
    if(empty($Adopter_ID)){
        $Adopter_ID_err = "Please enter a Adopter ID.";
    } else {
        // Check if the ID already exists in the database
        $sql = "SELECT Adopter_ID FROM adopters WHERE Adopter_ID = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $Adopter_ID);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $Adopter_ID_err = "This Adopter ID is already occupied.";
                }
            }
            $stmt->close();
        }
    }
    
    $Adopter_fname = trim($_POST["Adopter_fname"]);
    if(empty($Adopter_fname)){
        $Adopter_fname_err = "Please enter a First Name.";
    } elseif(!filter_var($Adopter_fname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Adopter_fname_err = "Please enter a valid First Name.";}

    
    $Adopter_lname = trim($_POST["Adopter_lname"]);
    if(empty($Adopter_lname)){
        $Adopter_lname_err = "Please enter a Last Name.";
    } elseif(!filter_var($Adopter_lname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Adopter_lname_err = "Please enter a valid Last Name.";
    } 

    $Adopter_dob = trim($_POST["Adopter_dob"]);
    if(empty($Adopter_dob)){
        $Adopter_dob_err = "Please enter a Date of Birth.";
    } 
    
    $Street = trim($_POST["Street"]);
    if(empty($Street)){
        $Street_err = "Please enter a Street Address";
    } elseif(!filter_var($Street, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Street_err = "Please enter a valid Street.";
    } 
    
    $City = trim($_POST["City"]);
    if(empty($City)){
        $City_err = "Please enter a Street Address";
    } elseif(!filter_var($City, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $City_err = "Please enter a valid City.";
    } 

    $State = trim($_POST["State"]);
    if(empty($State)){
        $State_err = "Please enter a State Address";
    } elseif(!filter_var($State, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $State_err = "Please enter a valid State.";
    } 
    
    $Zip = trim($_POST["Zip"]);
    if (empty($Zip)) {
        $Zip_err = "Please enter a Zip code.";
    } elseif (!preg_match("/^\d{5}(-\d{4})?$/", $Zip)) {
        $Zip_err = "Please enter a valid Zip code (e.g., 12345 or 12345-6789).";
    }
    

    if (empty($Adopter_ID_err) && empty($Adopter_fname_err) && empty($Adopter_lname_err)  
    && empty($Adopter_dob_err) && empty($Street_err) && empty($City_err) && empty($State_err) && empty($Zip_err)) {
    
    // Prepare an insert statement
    $sql = "INSERT INTO adopter (Adopter_ID, Adopter_fname, Adopter_lname, Adopter_dob, Street, City,  `State`, Zip) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
         
    if ($stmt = mysqli_prepare($mysqli, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssssssss", 
            $param_Adopter_ID, 
            $param_Adopter_fname, 
            $param_Adopter_lname, 
            $param_Adopter_dob, 
            $param_Street, 
            $param_City, 
            $param_State, 
            $param_Zip
        );
        
        // Set parameters
        $param_Adopter_ID = $Adopter_ID;
        $param_Adopter_fname = $Adopter_fname;
        $param_Adopter_lname = $Adopter_lname;
        $param_Adopter_dob = $Adopter_dob;
        $param_Street = $Street;
        $param_City = $City;
        $param_State = $State;
        $param_Zip = $Zip;
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Record created successfully, redirect to landing page
            header("location: index.php");
            exit();
        } else {
            echo "<center><h4>Error while adding new adopter</h4></center>";
            $Adopter_ID_err = "The Adopter ID is already taken. Please use a unique ID.";
        }
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
}


// Close connection
mysqli_close($mysqli);

    
}


?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Create Adopter</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


	<style type="text/css">
        .wrapper{
            width: 70%;
            margin:0 auto;
        }
        /* table tr td:last-child a{
            margin-right: 15px;
        } */
    </style>
    <!-- <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
		 $('.selectpicker').selectpicker();
    </script> -->
    </head>
<body>
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Adopters</h2>
                    </div>
                    <p>Please fill this form as a record.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($Adopter_ID_err)) ? 'has-error' : ''; ?>">
                        <label>Adopter ID</label>
                        <input type="number" name="Adopter_ID" class="form-control" value="<?php echo htmlspecialchars($Adopter_ID); ?>" min="1" step="1">
                        <span class="help-block"><?php echo $Adopter_ID_err; ?></span>
                    </div>

                 
						<div class="form-group <?php echo (!empty($Adopter_fname_err)) ? 'has-error' : ''; ?>">
                            <label>First Name</label>
                            <input type="text" name="Adopter_fname" class="form-control" value="<?php echo $Adopter_fname; ?>">
                            <span class="help-block"><?php echo $Adopter_fname_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($Adopter_lname_err)) ? 'has-error' : ''; ?>">
                            <label>Last Name</label>
                            <input type="text" name="Adopter_lname" class="form-control" value="<?php echo $Adopter_lname; ?>">
                            <span class="help-block"><?php echo $Adopter_lname_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Adopter_dob_err)) ? 'has-error' : ''; ?>">
                            <label>Birth date</label>
                            <input type="date" name="Adopter_dob" class="form-control" value="<?php echo $Adopter_dob; ?>">
                            <span class="help-block"><?php echo $Adopter_dob_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($Street_err)) ? 'has-error' : ''; ?>">
                            <label>Street</label>
                            <input type="text" name="Street" class="form-control" value="<?php echo $Street; ?>">
                            <span class="help-block"><?php echo $Street_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($City_err)) ? 'has-error' : ''; ?>">
                        <label>City</label>
                            <input type="text" name="City" class="form-control" value="<?php echo $City; ?>">
                            <span class="help-block"><?php echo $City_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($State_err)) ? 'has-error' : ''; ?>">
                        <label>State</label>
                            <input type="text" name="State" class="form-control" value="<?php echo $State; ?>">
                            <span class="help-block"><?php echo $State_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($Zip_err)) ? 'has-error' : ''; ?>">
                            <label>Zip Code</label>
                            <input type="number" name="Zip" class="form-control" value="<?php echo htmlspecialchars($Zip); ?>" min="0" max="99999" step="1">
                            <span class="help-block"><?php echo $Zip_err; ?></span>
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
