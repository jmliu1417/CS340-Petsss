<?php
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get Adopter_ID from POST request
    $param_Adopter_ID = intval(trim($_POST["Adopter_ID"]));

    // If user confirms deletion
    if (isset($_POST["confirm"]) && $_POST["confirm"] === "yes") {
        // Delete pets associated with this adopter
        $sql_pet = "DELETE FROM pet WHERE Adopter_ID = ?";
        if ($stmt_pet = mysqli_prepare($link, $sql_pet)) {
            mysqli_stmt_bind_param($stmt_pet, "i", $param_Adopter_ID);
            if (!mysqli_stmt_execute($stmt_pet)) {
                die("Error deleting associated pets: " . mysqli_stmt_error($stmt_pet));
            }
            mysqli_stmt_close($stmt_pet);
        }

        // Delete the adopter
        $sql_adopter = "DELETE FROM adopter WHERE Adopter_ID = ?";
        if ($stmt_adopter = mysqli_prepare($link, $sql_adopter)) {
            mysqli_stmt_bind_param($stmt_adopter, "i", $param_Adopter_ID);
            if (mysqli_stmt_execute($stmt_adopter)) {
                header("location: ../index.php");
                exit();
            } else {
                die("Error deleting adopter: " . mysqli_stmt_error($stmt_adopter));
            }
            mysqli_stmt_close($stmt_adopter);
        }
    } else {
        header("location: ../index.php");
        exit();
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["Adopter_ID"])) {
    if (empty(trim($_GET["Adopter_ID"]))) {
        // URL doesn't contain Adopter_ID parameter. Redirect to error page
        header("location: ../error.php");
        exit();
    }
    $param_Adopter_ID = intval(trim($_GET["Adopter_ID"]));

    // Check if there are associated pets
    $sql_check = "SELECT Pet_ID, Pet_Name FROM pet WHERE Adopter_ID = ?";
    $associated_pets = [];
    if ($stmt_check = mysqli_prepare($link, $sql_check)) {
        mysqli_stmt_bind_param($stmt_check, "i", $param_Adopter_ID);
        mysqli_stmt_execute($stmt_check);
        $result = mysqli_stmt_get_result($stmt_check);

        while ($row = mysqli_fetch_assoc($result)) {
            $associated_pets[] = $row; // Store associated pets
        }
        mysqli_stmt_close($stmt_check);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Adopter</title>
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
                    <h2 class="mt-5">Delete Adopter</h2>
                    <div class="alert alert-danger">
                        <?php if (!empty($associated_pets)): ?>
                            <p>Deleting this adopter will also delete the following associated pets:</p>
                            <ul>
                                <?php foreach ($associated_pets as $pet): ?>
                                    <li><?php echo htmlspecialchars($pet["Pet_Name"]) . " (Pet ID: " . htmlspecialchars($pet["Pet_ID"]) . ")"; ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <p>Are you sure you want to proceed?</p>
                        <?php else: ?>
                            <p>Are you sure you want to delete this adopter record?</p>
                        <?php endif; ?>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="Adopter_ID" value="<?php echo htmlspecialchars($param_Adopter_ID); ?>">
                        <div class="form-group">
                            <input type="submit" name="confirm" value="yes" class="btn btn-danger">
                            <a href="../index.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

