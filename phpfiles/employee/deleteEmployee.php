<?php
// Process delete operation after confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Employee_ID"])) {
    // Include config file
    require_once "../config.php";
    
    $param_Employee_ID = intval(trim($_POST["Employee_ID"]));
    
    // Check if the employee is a manager
    $sql_check_manager = "SELECT COUNT(*) AS count FROM employee WHERE Manager_id = ?";
    $is_manager = 0;

    if ($stmt_check = mysqli_prepare($link, $sql_check_manager)) {
        mysqli_stmt_bind_param($stmt_check, "i", $param_Employee_ID);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_bind_result($stmt_check, $is_manager);
        mysqli_stmt_fetch($stmt_check);
        mysqli_stmt_close($stmt_check);
    }

    // If the employee is a manager, prevent deletion
    if ($is_manager > 0) {
        $error_message = "This employee is a manager. You cannot delete them unless you update or move other employees' Manager ID.";
    } else {
        // Proceed with deletion if not a manager
        $sql_delete = "DELETE FROM employee WHERE Employee_ID = ?";
        if ($stmt_delete = mysqli_prepare($link, $sql_delete)) {
            mysqli_stmt_bind_param($stmt_delete, "i", $param_Employee_ID);
            if (mysqli_stmt_execute($stmt_delete)) {
                header("location: ../index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt_delete);
        }
    }

    // Close connection
    mysqli_close($link);
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["Employee_ID"])) {
    $param_Employee_ID = intval(trim($_GET["Employee_ID"]));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Employee</title>
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
                    <h2 class="mt-5">Delete Employee</h2>
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger">
                            <p><?php echo $error_message; ?></p>
                            <div class="form-group">
                                <a href="../index.php" class="btn btn-secondary">Go Back</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger">
                            <p>Are you sure you want to delete this employee record?</p>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <input type="hidden" name="Employee_ID" value="<?php echo htmlspecialchars($param_Employee_ID); ?>">
                                <div class="form-group">
                                    <input type="submit" value="Yes" class="btn btn-danger">
                                    <a href="../index.php" class="btn btn-secondary">No</a>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
