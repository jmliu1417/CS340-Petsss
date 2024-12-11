<?php
	session_start();	
// Include config file
	
 echo("please");

    if (!isset($_SESSION["Pet_ID"])) {
        echo "Pet_ID is not set in session.";
    }
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once "../config.php";


// Note: You can not update SSN  
// Define variables and initialize with empty values
$Pet_name = $Pet_type = $Pet_breed = $Pet_age = $Pet_time = $Pet_status = $Shelter_ID = $Adopter_ID = "";
$pname_err = $pt_err =  $pbreed_err =$page_err= $ptime_err = $pstat_err = $shelter_err = $adopt_err = "" ;
// Form default values
//echo("11");
if(isset($_GET["Pet_ID"]) && !empty(trim($_GET["Pet_ID"]))){
	$_SESSION["Pet_ID"] = $_GET["Pet_ID"];

    // Prepare a select statement
    $sql1 = "SELECT * FROM pet
         LEFT JOIN shelter ON pet.Shelter_ID = shelter.Shelter_ID
         LEFT JOIN adopter ON pet.Adopter_ID = adopter.Adopter_ID
         WHERE pet.Pet_ID = ?";
  
    if($stmt1 = mysqli_prepare($link, $sql1)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt1, "s", $param_pet_ID);      
        // Set parameters
        $param_pet_ID = trim($_GET["Pet_ID"]);
	//    $param_Dname = $_SESSION["Dname"];

    echo("line 29");

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
    $Pet_ID = $_SESSION["Pet_ID"];
	

	echo("67");
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
        $sql = "SELECT Shelter_ID FROM shelter WHERE Shelter_ID = ?";
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

    $Adopter_ID = trim($_POST["Adopter_ID"]);
if (!empty($Adopter_ID)) { // Only validate if Adopter_ID is provided
    $sql = "SELECT Adopter_ID FROM adopter WHERE Adopter_ID = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $Adopter_ID);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 0) {
                $adopt_err = "Invalid Adopter_ID."; // Error if not found in database
            }
        } else {
            echo "Error validating Adopter_ID.";
        }
        mysqli_stmt_close($stmt);
    }
}else{
    $Adopter_ID = null;
}


    // Check input errors before inserting into database
    if(empty($pname_err) && empty($pt_err) && 
					empty($pbreed_err) && empty($pbreed_err) && empty($ptime_err) 
                    && empty($page_err) && empty($pstat_err) && empty($shelter_err)){
        // Prepare an update statement

        $sql = "UPDATE pet SET Pet_name=?, Pet_type=?, Pet_breed =?, 
				Pet_age = ?, Pet_time = ?,Pet_status = ? ,Shelter_ID = ? , Adopter_ID = ? WHERE Pet_ID=?";
    
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssissssi", $param_pname, $param_ptype, 
					$param_pbreed, $param_page,$param_ptime, $param_pstat, $param_pshelt, $param_padopter, $param_pet_ID);
            
            // Set parameters
            
            $param_pname = $Pet_name;
			$param_ptype = $Pet_type;            
			$param_pbreed = $Pet_breed;
            $param_page = $Pet_age;
            $param_ptime = $Pet_time;
            $param_pstat = $Pet_status;
            $param_padopter = $Adopter_ID ?? null;
            $param_pshelt = $Shelter_ID;
            $param_pet_ID = $Pet_ID;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: ../index.php");
                exit();
            } else{
                echo "<center><h2>Error when updating</center></h2>";
				//$Dname = $_SESSION['Dname'];
            }
        }    
	
        // Close statement
        mysqli_stmt_close($stmt);
    }
	
    // Close connection
    mysqli_close($link);

} else{
    // Check existence of sID parameter before processing further
   // Form default values
   echo("line 128");
   if(isset($_GET["Pet_ID"]) && !empty(trim($_GET["Pet_ID"]))){
       $_SESSION["Pet_ID"] = $_GET["Pet_ID"];

       // Prepare a select statement
       $sql1 = "SELECT * FROM pet WHERE Pet_ID = ?";
 
       if($stmt1 = mysqli_prepare($link, $sql1)){
           // Bind variables to the prepared statement as parameters
           mysqli_stmt_bind_param($stmt1, "i", $param_pet_ID);      
           // Set parameters
           $param_pet_ID = trim($_GET["Pet_ID"]);
        

           // Attempt to execute the prepared statement
           if(mysqli_stmt_execute($stmt1)){
               $result1 = mysqli_stmt_get_result($stmt1);
               if(mysqli_num_rows($result1) == 1){

                   $row = mysqli_fetch_array($result1);

                   $Pet_name = $row['Pet_name'];
                   $Pet_type = $row['Pet_type'];
                   $Pet_breed = $row['Pet_breed'];
                   $Pet_age = $row['Pet_age'];
                   $Pet_time = $row['Pet_time'];
                   $Pet_status = $row['Pet_status'];
                   $Shelter_ID = $row['Shelter_ID'];
                   $Adopter_ID = $row['Adopter_ID'];
                   

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
                        <h3>Update Record for Pet_ID =  <?php echo $_GET["Pet_ID"]; ?> </h3>
                    </div>
                    <p>Please edit the input values and submit to update.
                    <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
						<div class="form-group <?php echo (!empty($pname_err)) ? 'has-error' : ''; ?>">
                            <label>Pet name</label>
                            <input type="text" name="Pet_name" class="form-control" value="<?php echo $Pet_name; ?>">
                            <span class="help-block"><?php echo $pname_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($pt_err)) ? 'has-error' : ''; ?>">
                            <label>Pet type</label>
                            <input type="text" name="Pet_type" class="form-control" value="<?php echo $Pet_type; ?>">
                            <span class="help-block"><?php echo $pt_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($pbreed_err)) ? 'has-error' : ''; ?>">
                            <label>Pet breed</label>
                            <input type="text" name="Pet_breed" class="form-control" value="<?php echo $Pet_breed; ?>">
                            <span class="help-block"><?php echo $pbreed_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($page_err)) ? 'has-error' : ''; ?>">
                            <label>Pet age</label>
                            <input type="text" name="Pet_age" class="form-control" value="<?php echo $Pet_age; ?>">
                            <span class="help-block"><?php echo $page_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($ptime_err)) ? 'has-error' : ''; ?>">
                            <label>Pet time</label>
                            <input type="time" min="1" max="20" name="Pet_time" class="form-control" value="<?php echo $Pet_status; ?>">
                            <span class="help-block"><?php echo $ptime_err;?></span>
                        </div>	
                        <div class="form-group <?php echo (!empty($pstat_err)) ? 'has-error' : ''; ?>">
                            <label>Pet status</label>
                            <input type="text" name="Pet_status" class="form-control" value="<?php echo $Pet_status; ?>">
                            <span class="help-block"><?php echo $pstat_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($shelter_err)) ? 'has-error' : ''; ?>">
                            <label>Pet shelter ID</label>
                            <input type="text"  name="Shelter_ID" class="form-control" value="<?php echo $Shelter_ID; ?>">
                            <span class="help-block"><?php echo $shelter_err;?></span>
                        </div>		
                        <div class="form-group <?php echo (!empty($adopt_err)) ? 'has-error' : ''; ?>">
                            <label>Pet adopter ID</label>
                            <input type="text"  name="Adopter_ID" class="form-control" value="<?php echo $Adopter_ID; ?>">
                            <span class="help-block"><?php echo $adopt_err;?></span>
                        </div>						
                        <input type="hidden" name="Pet_ID" value="<?php echo $Pet_ID; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>