<?php
session_start();
// Include config file
require_once "../config.php";

// Check if Pet_ID is passed
if (isset($_GET['Pet_ID'])) {
    $pet_id = $_GET['Pet_ID'];
} else {
    die("Pet ID not specified.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Adopter</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper {
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2 {
            margin-top: 0;
        }
        table tr td:last-child a {
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Adopter for Pet <?php echo htmlspecialchars($pet_id); ?></h2>
                    </div>
                    <?php
                    // Prepare a select statement to fetch adopter associated with the selected Pet_ID
                    $sql = "SELECT adopter.Adopter_ID, Adopter_fname, Adopter_lname, Adopter_dob, Street, City, State, Zip 
                            FROM adopter 
                            JOIN pet ON adopter.Adopter_ID = pet.Adopter_ID
                            WHERE pet.Pet_ID = ?";

                    if ($stmt = mysqli_prepare($link, $sql)) {
                        // Bind Pet_ID parameter
                        mysqli_stmt_bind_param($stmt, "i", $param_pet_id);
                        $param_pet_id = $pet_id;

                        // Execute the statement
                        if (mysqli_stmt_execute($stmt)) {
                            $result = mysqli_stmt_get_result($stmt);
                            if (mysqli_num_rows($result) > 0) {
                                echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Adopter ID</th>";
                                echo "<th>First Name</th>";
                                echo "<th>Last Name</th>";
                                echo "<th>Date of Birth</th>";
                                echo "<th>Street</th>";
                                echo "<th>City</th>";
                                echo "<th>State</th>";
                                echo "<th>Zip</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['Adopter_ID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Adopter_fname']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Adopter_lname']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Adopter_dob']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Street']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['City']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['State']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Zip']) . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "</table>";
                                mysqli_free_result($result);
                            } else {
                                echo "<p>No adopter found for this pet.</p>";
                            }
                        } else {
                            echo "ERROR: Could not execute query: $sql. " . mysqli_error($link);
                        }
                    }

                    // Close statement and connection
                    mysqli_stmt_close($stmt);
                    mysqli_close($link);
                    ?>
                    <p><a href="../index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
