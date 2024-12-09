<?php
	session_start();	
// Include config file
	require_once "../config.php";
 
// Note: You can not update SSN  
// Define variables and initialize with empty values
$Pet_name = $Pet_type = $Pet_breed = $Pet_age = $Pet_time = $Pet_status = "" ;
$pname_err = $pt_err =  $pbreed_err =$page_err= $ptime_err = $pstat_err ="" ;
// Form default values

if(isset($_GET["Pet_name"]) && !empty(trim($_GET["Pet_name"]))){
	$_SESSION["Pet_name"] = $_GET["Pet_name"];
	$Pet_ID = $_SESSION["Pet_ID"];

    // Prepare a select statement
    $sql1 = "SELECT * FROM PETS 
         LEFT JOIN SHELTERS ON PETS.Shelter_ID = SHELTERS.Shelter_ID
         LEFT JOIN ADOPTERS ON PETS.Adopter_ID = ADOPTERS.Adopter_ID
         WHERE PETS.Pet_ID = ?";
  
    if($stmt1 = mysqli_prepare($link, $sql1)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt1, "ss", $Pet_ID);      
        // Set parameters
       $param_id = $Pet_ID;
	//    $param_Dname = $_SESSION["Dname"];

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt1)){
            $result1 = mysqli_stmt_get_result($stmt1);
			if(mysqli_num_rows($result1) > 0){

				$row = mysqli_fetch_array($result1);

				$Pet_name = $row['Pet_name'];
				$Pet_type = $row['Pet_type'];
				$Pet_breed = $row['Pet_breed'];	
				$Pet_age = $row['Pet_age'];
                $Pet_time = $row['Pet_time'];
                $Pet_status = $row['Pet_status'];
                $Shelter_ID = $row['Shelter_ID'];
                $Adopter_ID = $row['Adopter_ID'] ?? null; // Optional foreign key
			}
		}
	}
}

// Post information about the employee when the form is submitted
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // the ssn is hidden and can not be changed
    $Adopter_ID = $_SESSION["Adopter_ID"];
	//$old_Dname = $_SESSION["Dname"];
	
    // Validate Dependent name
    $Pet_name = trim($_POST["Pet_name"]);
    if(empty($Pet_name)){
        $pname_err = "Please enter a Pet_name.";
    } elseif(!filter_var($Pet_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $pname_err = "Please enter a valid name.";
    } 
    // Validate Relationship
    $Pet_type = trim($_POST["Pet_type"]);
    if(empty($Pet_type)){
        $pt_err = "Please enter a Pet_type.";
    } elseif(!filter_var($Pet_type, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $pt_err = "Please enter a valid Pet_type.";
    } 

    $Pet_breed = trim($_POST["Pet_breed"]);
    if(empty($Pet_breed)){
        $pbreed_err = "Please enter a Pet_breed.";
    } elseif(!filter_var($Pet_breed, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $pbreed_err = "Please enter a valid Pet_breed.";
    } 
 
	// Validate Sex
    $Pet_age = trim($_POST["Pet_age"]);
    if(empty($Pet_age)){
        $page_err = "Please enter Pet_age.";     
    }
	// Validate Birthdate
    $Pet_time = trim($_POST["Pet_time"]);
    if(empty($Pet_time)){
        $ptime_err = "Please enter pet time.";     
    }	

    $Pet_status = trim($_POST["Pet_status"]);
    if(empty($Pet_status)){
        $pstat_err = "Please enter Pet_status.";     
    }	

    $Shelter_ID = trim($_POST["Shelter_ID"]);
    if (empty($Shelter_ID)) {
        $shelter_err = "Shelter_ID is required.";
    } else {
        $sql = "SELECT Shelter_ID FROM SHELTERS WHERE Shelter_ID = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $Shelter_ID);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 0) {
                    $shelter_err = "Invalid Shelter_ID.";
                }
            } else {
                echo "Error validating Shelter_ID.";
            }
        }
    }

    // Check input errors before inserting into database
    if(empty($Dname_err) && empty($Relationship_err) && 
					empty($Sex_err) && empty($Bdate_err)){
        // Prepare an update statement

        $sql = "UPDATE DEPENDENT SET Dependent_name=?, Sex=?, Bdate =?, 
				Relationship = ? WHERE Essn=? AND Dependent_name=?";
    
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_Dname, $param_Sex, 
					$param_Bdate, $param_Relationship,$param_Ssn, $param_oldDname);
            
            // Set parameters
            $param_Dname = $Dname;
			$param_Sex = $Sex;            
			$param_Relationship = $Relationship;
            $param_Bdate = $Bdate;
            $param_oldDname = $old_Dname;
            $param_Ssn = $Ssn;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "<center><h2>Error duplicate name ".$Dname." </center></h2>";
				$Dname = $_SESSION['Dname'];
            }
        }    
	
        // Close statement
        mysqli_stmt_close($stmt);
    }
	
    // Close connection
    mysqli_close($link);

} 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company DB</title>
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
                        <h3>Update Record for Dependent =  <?php echo $_GET["Dname"]; ?> </H3>
                    </div>
                    <p>Please edit the input values and submit to update.
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
						<div class="form-group <?php echo (!empty($Dname_err)) ? 'has-error' : ''; ?>">
                            <label>Dependent's Name</label>
                            <input type="text" name="Dname" class="form-control" value="<?php echo $Dname; ?>">
                            <span class="help-block"><?php echo $Dname_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($Relationship_err)) ? 'has-error' : ''; ?>">
                            <label>Relationship</label>
                            <input type="text" name="Relationship" class="form-control" value="<?php echo $Relationship; ?>">
                            <span class="help-block"><?php echo $Relationship_err;?></span>
                        </div>
				
						<div class="form-group <?php echo (!empty($Sex_err)) ? 'has-error' : ''; ?>">
                            <label>Sex</label>
                            <input type="text" name="Sex" class="form-control" value="<?php echo $Sex; ?>">
                            <span class="help-block"><?php echo $Sex_err;?></span>
                        </div>
						                  
						<div class="form-group <?php echo (!empty($Bdate_err)) ? 'has-error' : ''; ?>">
                            <label>Birth date</label>
                            <input type="date" name="Bdate" class="form-control" value="<?php echo $Bdate; ?>">
                            <span class="help-block"><?php echo $Bdate_err;?></span>
                        </div>
              
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>						
              
                </div>
            </div>        
        </div>
    </div>
</body>
</html>