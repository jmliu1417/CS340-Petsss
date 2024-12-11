<?php

require_once "../config.php";

$Employee_ID = $Employee_fname = $Employee_lname = $Employee_pos = $Employee_salary = $Employee_Phone_number = $Employee_Age = $Manager_id = "";
$Employee_ID_err = $Employee_fname_err = $Employee_lname_err = $Employee_pos_err = $Employee_salary_err = $Employee_Phone_number_err = $Employee_Age_err = $Manager_id_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Employee ID Validation
    $Employee_ID = trim($_POST["Employee_ID"]);
    if (empty($Employee_ID)) {
        $Employee_ID_err = "Please enter an Employee ID.";
    } else {
        // Check if the ID already exists in the database
        $sql = "SELECT Employee_ID FROM employees WHERE Employee_ID = ?";
        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("s", $Employee_ID);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $Employee_ID_err = "This Employee ID is already occupied.";
                }
            }
            $stmt->close();
        }
    }

    // First Name Validation
    $Employee_fname = trim($_POST["First_Name"]);
    if (empty($Employee_fname)) {
        $Employee_fname_err = "Please enter a First Name.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $Employee_fname)) {
        $Employee_fname_err = "Please enter a valid First Name.";
    }

    // Last Name Validation
    $Employee_lname = trim($_POST["Last_Name"]);
    if (empty($Employee_lname)) {
        $Employee_lname_err = "Please enter a Last Name.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $Employee_lname)) {
        $Employee_lname_err = "Please enter a valid Last Name.";
    }

    // Position Validation
    $Employee_pos = trim($_POST["Position"]);
    if (empty($Employee_pos)) {
        $Employee_pos_err = "Please enter a Position.";
    }

    // Salary Validation
    $Employee_salary = trim($_POST["Salary"]);
    if (empty($Employee_salary)) {
        $Employee_salary_err = "Please enter a Salary.";
    } elseif (!is_numeric($Employee_salary) || $Employee_salary <= 0) {
        $Employee_salary_err = "Please enter a valid Salary.";
    }

    // Phone Number Validation
    $Employee_Phone_number = trim($_POST["Phone_Number"]);
    if (empty($Employee_Phone_number)) {
        $Employee_Phone_number_err = "Please enter a Phone Number.";
    } elseif (!preg_match("/^\d{10}$/", $Employee_Phone_number)) {
        $Employee_Phone_number_err = "Please enter a valid 10-digit Phone Number.";
    }

    // Age Validation
    $Employee_Age = trim($_POST["Age"]);
    if (empty($Employee_Age)) {
        $Employee_Age_err = "Please enter an Age.";
    } elseif (!is_numeric($Employee_Age) || $Employee_Age < 18 || $Employee_Age > 100) {
        $Employee_Age_err = "Please enter a valid Age (18-100).";
    }

    // Manager ID Validation
    $Manager_id = trim($_POST["Manager_ID"]);
    if (empty($Manager_id)) {
        $Manager_id_err = "Please enter the Manager ID.";
    }

    // Check for errors before inserting into the database
    if (empty($Employee_ID_err) && empty($Employee_fname_err) && empty($Employee_lname_err) &&
        empty($Employee_pos_err) && empty($Employee_salary_err) && empty($Employee_Phone_number_err) &&
        empty($Employee_Age_err) && empty($Manager_id_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO employees (Employee_ID, Employee_fname, Employee_lname, Employee_pos, Employee_salary, Employee_Phone_number, Employee_Age, Manager_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssssis", 
                $param_Employee_ID,
                $param_Employee_fname,
                $param_Employee_lname,
                $param_Employee_pos,
                $param_Employee_salary,
                $param_Employee_Phone_number,
                $param_Employee_Age,
                $param_Manager_id
            );

            // Set parameters
            $param_Employee_ID = $Employee_ID;
            $param_Employee_fname = $Employee_fname;
            $param_Employee_lname = $Employee_lname;
            $param_Employee_pos = $Employee_pos;
            $param_Employee_salary = $Employee_salary;
            $param_Employee_Phone_number = $Employee_Phone_number;
            $param_Employee_Age = $Employee_Age;
            $param_Manager_id = $Manager_id;

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                header("location:../index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again.";
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
    <title>Create Employee</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Create Employee</h2>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($Employee_ID_err)) ? 'has-error' : ''; ?>">
                        <label>Employee ID</label>
                        <input type="text" name="Employee_ID" class="form-control" value="<?php echo htmlspecialchars($Employee_ID); ?>">
                        <span class="help-block"><?php echo $Employee_ID_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($Employee_fname_err)) ? 'has-error' : ''; ?>">
                        <label>First Name</label>
                        <input type="text" name="First_Name" class="form-control" value="<?php echo $Employee_fname; ?>">
                        <span class="help-block"><?php echo $Employee_fname_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($Employee_lname_err)) ? 'has-error' : ''; ?>">
                        <label>Last Name</label>
                        <input type="text" name="Last_Name" class="form-control" value="<?php echo $Employee_lname; ?>">
                        <span class="help-block"><?php echo $Employee_lname_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($Employee_pos_err)) ? 'has-error' : ''; ?>">
                        <label>Position</label>
                        <input type="text" name="Position" class="form-control" value="<?php echo $Employee_pos; ?>">
                        <span class="help-block"><?php echo $Employee_pos_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($Employee_salary_err)) ? 'has-error' : ''; ?>">
                        <label>Salary</label>
                        <input type="text" name="Salary" class="form-control" value="<?php echo $Employee_salary; ?>">
                        <span class="help-block"><?php echo $Employee_salary_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($Employee_Phone_number_err)) ? 'has-error' : ''; ?>">
                        <label>Phone Number</label>
                        <input type="text" name="Phone_Number" class="form-control" value="<?php echo $Employee_Phone_number; ?>">
                        <span class="help-block"><?php echo $Employee_Phone_number_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($Employee_Age_err)) ? 'has-error' : ''; ?>">
                        <label>Age</label>
                        <input type="number" name="Age" class="form-control" value="<?php echo $Employee_Age; ?>">
                        <span class="help-block"><?php echo $Employee_Age_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($Manager_id_err)) ? 'has-error' : ''; ?>">
                        <label>Manager ID</label>
                        <input type="text" name="Manager_ID" class="form-control" value="<?php echo $Manager_id; ?>">
                        <span class="help-block"><?php echo $Manager_id_err; ?></span>
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
