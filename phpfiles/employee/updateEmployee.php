<?php
session_start();

if (!isset($_SESSION["Employee_ID"])) {
    echo "Employee_ID is not set in session.";
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../config.php";

$Employee_fname = $Employee_lname = $Employee_pos = $Employee_salary = $Employee_Phone_number = $Employee_Age = $Manager_id = $Shelter_ID = " ";
$fname_err = $lname_err = $pos_err = $salary_err = $phone_err = $age_arr = $manager_err = $shelter_err = "";

if(isset($_GET["Employee_ID"]) && !empty(trim($_GET["Employee_ID"]))){
    // Get hidden input value

    $_SESSION["Employee_ID"] = $_GET["Employee_ID"];

    //prep select statement?
    $sql1 = "SELECT * FROM employee WHERE Employee_ID = ?";

    if($stmt1 = mysqli_prepare($link, $sql1)){
        //bind variables to prepared statement?
        mysqli_stmt_bind_param($stmt1, "s", $param_Employee_ID);      
        // Set parameters
       $param_Employee_ID = trim($_GET["Employee_ID"]);

        if(mysqli_stmt_execute($stmt1)) {
            $result1 = mysqli_stmt_get_result($stmt1);
            if(mysqli_num_rows($result1) > 0){

                $row = mysqli_fetch_array($result1);

                $Employee_fname = $row['Employee_fname'];
				$Employee_lname = $row['Employee_lname'];
				$Employee_pos = $row['Employee_pos'];
				$Employee_salary = $row['Employee_salary'];
				$Employee_Phone_number = $row['Employee_Phone_number'];
				$Employee_Age = $row['Employee_Age'];
                $Manager_id = $row['Manager_id'];
				$Shelter_ID = $row['Shelter_ID'];
            }
        }
    }
}

//Data form proccessing

if($_SERVER["REQUEST_METHOD"] == "POST"){

    //hidden ID
    $Employee_ID= $_SESSION["Employee_ID"];

    //start validating stuff! first with name

    $Employee_fname = trim($_POST["Employee_fname"]);
    if(empty($Employee_fname)){
        $fname_err = "Please enter a first name.";
    }elseif(!filter_var($Employee_fname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
        $fname_err = "Please enter a valid first name.";
    }

    $Employee_lname = trim($_POST["Employee_lname"]);
    if(empty($Employee_lname)){
        $lname_err = "Please enter a last name.";
    } elseif(!filter_var($Employee_lname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $lname_err = "Please enter a valid last name.";
    }  

    $Employee_pos = trim($_POST["Employee_pos"]);
    if(empty($Employee_pos)){
        $pos_err = "Please enter the position.";     
    }

    $Employee_salary = trim($_POST["Employee_salary"]);
    if(empty($Employee_salary)){
        $salary_err = "Please enter the salary.";     
    }
	
    $Employee_Phone_number = trim($_POST["Employee_Phone_number"]);
    if(empty($Employee_Phone_number)){
        $phone_err = "Please enter the phone number.";     
    }

    $Employee_Age = trim($_POST["Employee_Age"]);
    if(empty($Employee_Age)){
        $age_arr = "Please enter the age.";     
    }
 
    //zip
    $Manager_id = trim($_POST["Manager_id"]);
    if(empty($Manager_id)){
        $manager_err = "Please enter the manager id.";     
    }

    $Shelter_ID = trim($_POST["Shelter_ID"]);
    if(empty($Shelter_ID)){
        $shelter_err = "Please enter the shelter id.";     
    }
    
    // Check input errors before inserting into database
    if(empty($fname_err) && empty($lname_err) && empty($pos_err) && empty($salary_err) && empty($phone_err) && empty($age_arr) && empty($manager_err) && empty($shelter_err)){
        // Prepare an update statement, why is state green?
        
        $sql = "UPDATE employee SET Employee_fname=?, Employee_lname=?, Employee_pos=?, Employee_salary = ?, Employee_Phone_number = ?, Employee_Age = ?, Manager_id = ? , Shelter_ID = ? WHERE Employee_ID=?";
    echo($sql);
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssiiiiii", $param_fname, $param_lname,$param_pos, $param_salary,$param_phone, $param_age, $param_manager, $param_shelter, $param_Employee_ID);
            // Set parameters
            $param_fname = $Employee_fname;
			$param_lname = $Employee_lname;            
			$param_pos = $Employee_pos;
            $param_salary = $Employee_salary;
            $param_phone = $Employee_Phone_number;
            $param_age = $Employee_Age;
            $param_manager = $Manager_id;
            $param_shelter = $Shelter_ID;
            $param_Employee_ID = $Employee_ID;
            
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
	if(isset($_GET["Employee_ID"]) && !empty(trim($_GET["Employee_ID"]))){
		$_SESSION["Employee_ID"] = $_GET["Employee_ID"];

		// Prepare a select statement
		$sql1 = "SELECT * FROM employee WHERE Employee_ID = ?";
  
		if($stmt1 = mysqli_prepare($link, $sql1)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt1, "s", $param_Employee_ID);      
			// Set parameters
			$param_Employee_ID = trim($_GET["Employee_ID"]);

			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt1)){
				$result1 = mysqli_stmt_get_result($stmt1);
				if(mysqli_num_rows($result1) == 1){

					$row = mysqli_fetch_array($result1);

					$Employee_fname = $row['Employee_fname'];
					$Employee_lname = $row['Employee_lname'];
                    $Employee_pos = $row['Employee_pos'];
					$Employee_salary = $row['Employee_salary'];
					$Employee_Phone_number = $row['Employee_Phone_number'];
					$Employee_Age = $row['Employee_Age'];
					$Manager_id = $row['Manager_id'];
					$Shelter_ID = $row['Shelter_ID'];
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
    <title>Update Employee</title>
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
                        <h3>Update Record for Employee <?php echo $_GET["Employee_ID"]; ?> </h3>
                    </div>
                    <p>Please edit the input values and submit to update.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($fname_err)) ? 'has-error' : ''; ?>">
                            <label>First Name</label>
                            <input type="text" name="Employee_fname" class="form-control" value="<?php echo $Employee_fname; ?>">
                            <span class="help-block"><?php echo $fname_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($lname_err)) ? 'has-error' : ''; ?>">
                            <label>Last Name</label>
                            <input type="text" name="Employee_lname" class="form-control" value="<?php echo $Employee_lname; ?>">
                            <span class="help-block"><?php echo $lname_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($pos_err)) ? 'has-error' : ''; ?>">
                            <label>Position</label>
                            <input type="text" name="Employee_pos" class="form-control" value="<?php echo $Employee_pos; ?>">
                            <span class="help-block"><?php echo $pos_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="Employee_salary" class="form-control" value="<?php echo $Employee_salary; ?>">
                            <span class="help-block"><?php echo $salary_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                            <label>Phone Number</label>
                            <input type="text" name="Employee_Phone_number" class="form-control" value="<?php echo $Employee_Phone_number; ?>">
                            <span class="help-block"><?php echo $phone_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($age_arr)) ? 'has-error' : ''; ?>">
                            <label>Age</label>
                            <input type="text" name="Employee_Age" class="form-control" value="<?php echo $Employee_Age; ?>">
                            <span class="help-block"><?php echo $age_arr; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($manager_err)) ? 'has-error' : ''; ?>">
                            <label>Manager ID</label>
                            <input type="text" name="Manager_id" class="form-control" value="<?php echo $Manager_id; ?>">
                            <span class="help-block"><?php echo $manager_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($shelter_err)) ? 'has-error' : ''; ?>">
                            <label>Shelter ID</label>
                            <input type="text" name="Shelter_ID" class="form-control" value="<?php echo $Shelter_ID; ?>">
                            <span class="help-block"><?php echo $shelter_err; ?></span>
                        </div>
                        <input type="hidden" name="Employee_ID" value="<?php echo $_SESSION["Employee_ID"]; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
