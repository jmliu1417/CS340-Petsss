<?php
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Shelter_ID"])) {
    $param_Shelter_ID = intval(trim($_POST["Shelter_ID"]));

    // Check if the shelter contains managers
    $sql_check_manager = "SELECT COUNT(*) AS manager_count FROM employee WHERE Shelter_ID = ? AND Employee_ID IN (SELECT Manager_id FROM employee)";
    $manager_count = 0;

    if ($stmt_check = mysqli_prepare($link, $sql_check_manager)) {
        mysqli_stmt_bind_param($stmt_check, "i", $param_Shelter_ID);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_bind_result($stmt_check, $manager_count);
        mysqli_stmt_fetch($stmt_check);
        mysqli_stmt_close($stmt_check);
    }

    // If the shelter has a manager, prevent deletion
    if ($manager_count > 0) {
        $error_message = "This shelter contains one or more managers. You cannot delete the shelter unless you update or remove other employees' Manager ID.";
    } else {
        // Proceed with deletion if no managers exist
        // Delete pets associated with the shelter
        $sql_delete_pets = "DELETE FROM pet WHERE Shelter_ID = ?";
        if ($stmt_pets = mysqli_prepare($link, $sql_delete_pets)) {
            mysqli_stmt_bind_param($stmt_pets, "i", $param_Shelter_ID);
            mysqli_stmt_execute($stmt_pets);
            mysqli_stmt_close($stmt_pets);
        }

        // Delete employees associated with the shelter
        $sql_delete_employees = "DELETE FROM employee WHERE Shelter_ID = ?";
        if ($stmt_employees = mysqli_prepare($link, $sql_delete_employees)) {
            mysqli_stmt_bind_param($stmt_employees, "i", $param_Shelter_ID);
            mysqli_stmt_execute($stmt_employees);
            mysqli_stmt_close($stmt_employees);
        }

        // Finally, delete the shelter
        $sql_delete_shelter = "DELETE FROM shelter WHERE Shelter_ID = ?";
        if ($stmt_shelter = mysqli_prepare($link, $sql_delete_shelter)) {
            mysqli_stmt_bind_param($stmt_shelter, "i", $param_Shelter_ID);
            if (mysqli_stmt_execute($stmt_shelter)) {
                header("location: ../index.php");
                exit();
            } else {
                echo "Error deleting shelter: " . mysqli_error($link);
            }
            mysqli_stmt_close($stmt_shelter);
        }

        mysqli_close($link);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["Shelter_ID"])) {
    $param_Shelter_ID = intval(trim($_GET["Shelter_ID"]));

    // Check if there are associated pets and employees
    $pets_count = 0;
    $employees_count = 0;

    // Count pets
    $sql_check_pets = "SELECT COUNT(*) AS count FROM pet WHERE Shelter_ID = ?";
    if ($stmt_pets = mysqli_prepare($link, $sql_check_pets)) {
        mysqli_stmt_bind_param($stmt_pets, "i", $param_Shelter_ID);
        mysqli_stmt_execute($stmt_pets);
        mysqli_stmt_bind_result($stmt_pets, $pets_count);
        mysqli_stmt_fetch($stmt_pets);
        mysqli_stmt_close($stmt_pets);
    }

    // Count employees
    $sql_check_employees = "SELECT COUNT(*) AS count FROM employee WHERE Shelter_ID = ?";
    if ($stmt_employees = mysqli_prepare($link, $sql_check_employees)) {
        mysqli_stmt_bind_param($stmt_employees, "i", $param_Shelter_ID);
        mysqli_stmt_execute($stmt_employees);
        mysqli_stmt_bind_result($stmt_employees, $employees_count);
        mysqli_stmt_fetch($stmt_employees);
        mysqli_stmt_close($stmt_employees);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Shelter</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Delete Shelter</h2>
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger">
                            <p><?php echo $error_message; ?></p>
                            <div class="form-group">
                            <a href="../index.php" class="btn btn-secondary">Go Back</a>
                        
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger">
                            <?php if ($pets_count > 0 || $employees_count > 0): ?>
                                <p>Deleting this shelter will also delete:</p>
                                <ul>
                                    <?php if ($pets_count > 0): ?>
                                        <li><?php echo htmlspecialchars($pets_count); ?> associated pet(s)</li>
                                    <?php endif; ?>
                                    <?php if ($employees_count > 0): ?>
                                        <li><?php echo htmlspecialchars($employees_count); ?> associated employee(s)</li>
                                    <?php endif; ?>
                                </ul>
                                <p>Are you sure you want to proceed?</p>
                            <?php else: ?>
                                <p>Are you sure you want to delete this shelter record?</p>
                            <?php endif; ?>
                        </div>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="hidden" name="Shelter_ID" value="<?php echo htmlspecialchars($param_Shelter_ID); ?>">
                            <input type="hidden" name="confirm" value="yes">
                            <div class="form-group">
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="../index.php" class="btn btn-secondary">No</a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
