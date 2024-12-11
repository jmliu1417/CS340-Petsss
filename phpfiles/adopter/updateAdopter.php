<?php
session_start();

if (!isset($_SESSION["Adopter_ID"])) {
    echo "Adopter_ID is not set in session.";
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../config.php";

$Adopter_fname = $Adopter_lname = $Street = $State = $Zip = $Adopter_DOB = $City = " ";
$fname_err = $lname_err = $street_err = $state_err = $city_err = $DOB_err = $zip_err = "";

if(isset($_GET["Adopter_ID"]) && !empty(trim($_GET["Adopter_ID"]))){
    // Get hidden input value

    $_SESSION["Adopter_ID"] = $_GET["Adopter_ID"];

    //prep select statement?
    $sql1 = "SELECT * FROM adopter WHERE Adopter_ID = ?";

    if($stmt1 = mysqli_prepare($link, $sql1)){
        //bind variables to prepared statement?
        mysqli_stmt_bind_param($stmt1, "s", $param_Adopter_ID);      
        // Set parameters
       $param_Adopter_ID = trim($_GET["Adopter_ID"]);

        if(mysqli_stmt_execute($stmt1)) {
            $result1 = mysqli_stmt_get_result($stmt1);
            if(mysqli_num_rows($result1) > 0){

                $row = mysqli_fetch_array($result1);

                $Adopter_fname = $row['Adopter_fname'];
				$Adopter_lname = $row['Adopter_lname'];
				$Adopter_DOB = $row['Adopter_dob'];
				$Street = $row['Street'];
				$City = $row['City'];
				$State = $row['State'];
				$Zip = $row['Zip'];
            }
        }
    }
}

//Data form proccessing

if($_SERVER["REQUEST_METHOD"] == "POST"){

    echo("line 52");
    //hidden ID
    $Adopter_ID = $_SESSION["Adopter_ID"];

    //start validating stuff! first with name

    $Adopter_fname = trim($_POST["Adopter_fname"]);
    if(empty($Adopter_fname)){
        $fname_err = "Please enter a first name.";
    }elseif(!filter_var($Adopter_fname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
        $fname_err = "Please enter a valid first name.";
    }
    echo($Adopter_fname);

    $Adopter_lname = trim($_POST["Adopter_lname"]);
    if(empty($Adopter_lname)){
        $lname_err = "Please enter a last name.";
    } elseif(!filter_var($Adopter_lname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $lname_err = "Please enter a valid last name.";
    }  

    echo($Adopter_lname);

    // Validate date of birth
    $Adopter_DOB = trim($_POST["Adopter_dob"]);
    if(empty($Adopter_DOB)){
        $DOB_err = "Please enter date of birth.";     
    }

    //confirtm street
    $Street = trim($_POST["Street"]);
    if(empty($Street)){
        $street_err = "Please enter Street.";     
    }
	
    //city
    $City = trim($_POST["City"]);
    if(empty($City)){
        $city_err = "Please enter city.";     
    }

    //State
    $State = trim($_POST["State"]);
    if(empty($State)){
        $state_err = "Please enter state.";     
    }
    echo($State);
    //zip
    $Zip = trim($_POST["Zip"]);
    if(empty($Zip)){
        $zip_err = "Please enter zip.";     
    }

    // Check input errors before inserting into database
    if(empty($fname_err) && empty($lname_err) && empty($DOB_err) && empty($street_err) && empty($city_err) && empty($state_err) && empty($zip_err)){
        // Prepare an update statement, why is state green?
        
        $sql = "UPDATE adopter SET Adopter_fname=?, Adopter_lname=?, Adopter_dob=?, Street = ?, City = ?, State = ?, Zip = ? WHERE Adopter_ID=?";
    echo($sql);
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssi", $param_fname, $param_lname,$param_DOB, $param_street,$param_city, $param_state, $param_zip, $param_Adopter_ID);
            echo("line 108");
            // Set parameters
            $param_fname = $Adopter_fname;
			$param_lname = $Adopter_lname;            
			$param_DOB = $Adopter_DOB;
            $param_street = $Street;
            $param_city = $City;
            $param_state = $State;
            $param_zip = $Zip;
            $param_Adopter_ID = $Adopter_ID;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: ../index.php");
                exit();
            } else{
                echo "<center><h2>Error when updating</center></h2>";
            }
        }        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);

}else{
     // Check existence of sID parameter before processing further
	// Form default values
    echo("line 128");
	if(isset($_GET["Adopter_ID"]) && !empty(trim($_GET["Adopter_ID"]))){
		$_SESSION["Adopter_ID"] = $_GET["Adopter_ID"];

		// Prepare a select statement
		$sql1 = "SELECT * FROM adopter WHERE Adopter_ID = ?";
  
		if($stmt1 = mysqli_prepare($link, $sql1)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt1, "s", $param_Adopter_ID);      
			// Set parameters
			$param_Adopter_ID = trim($_GET["Adopter_ID"]);

			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt1)){
				$result1 = mysqli_stmt_get_result($stmt1);
				if(mysqli_num_rows($result1) == 1){

					$row = mysqli_fetch_array($result1);

					$Adopter_fname = $row['Adopter_fname'];
					$Adopter_lname = $row['Adopter_lname'];
					$Adopter_DOB = $row['Adopter_dob'];
					$Street = $row['Street'];
					$City = $row['City'];
					$State = $row['State'];
					$Zip = $row['Zip'];

                    echo("line 166");
				} else{
					// URL doesn't contain valid id. Redirect to error page
					header("location: ../error.php");
					exit();
				}                
			} else{
				echo "Error in SSN while updating";
			}		
		}
			// Close statement
			mysqli_stmt_close($stmt1);
        
			// Close connection
			mysqli_close($link);
	}  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: ../error.php");
        exit();
	}	
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Adopter</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
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
                        <h3>Update Record for Adopter_ID =  <?php echo $_GET["Adopter_ID"]; ?> </h3>
                    </div>
                    <p>Please edit the input values and submit to update.
                    <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
						<div class="form-group <?php echo (!empty($fname_err)) ? 'has-error' : ''; ?>">
                            <label>First Name</label>
                            <input type="text" name="Adopter_fname" class="form-control" value="<?php echo $Adopter_fname; ?>">
                            <span class="help-block"><?php echo $fname_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($lname_err)) ? 'has-error' : ''; ?>">
                            <label>Last Name</label>
                            <input type="text" name="Adopter_lname" class="form-control" value="<?php echo $Adopter_lname; ?>">
                            <span class="help-block"><?php echo $lname_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($DOB_err)) ? 'has-error' : ''; ?>">
                            <label>Adopter DPB</label>
                            <input type="date" name="Adopter_dob" class="form-control" value="<?php echo $Adopter_DOB; ?>">
                            <span class="help-block"><?php echo $DOB_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($street_err)) ? 'has-error' : ''; ?>">
                            <label></label>
                            <input type="text" name="Street" class="form-control" value="<?php echo $Street; ?>">
                            <span class="help-block"><?php echo $street_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                            <label>City</label>
                            <input type="text" min="1" max="20" name="City" class="form-control" value="<?php echo $City; ?>">
                            <span class="help-block"><?php echo $city_err;?></span>
                        </div>	
                        <div class="form-group <?php echo (!empty($state_err)) ? 'has-error' : ''; ?>">
                            <label>City</label>
                            <input type="text" min="1" max="20" name="State" class="form-control" value="<?php echo $State; ?>">
                            <span class="help-block"><?php echo $state_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($zip_err)) ? 'has-error' : ''; ?>">
                            <label>Zip</label>
                            <input type="text"  name="Zip" class="form-control" value="<?php echo $Zip; ?>">
                            <span class="help-block"><?php echo $zip_err;?></span>
                        </div>							
                        <input type="hidden" name="Adopter_ID" value="<?php echo $Adopter_ID; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>