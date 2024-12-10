<?php
    session_start();
    // Include config file
    require_once "../config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Adopters</title>
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
                        <h2 class="pull-left">Adopter Records</h2>
                    </div>
                    <?php
                    // Prepare a select statement
                    $sql = "SELECT * FROM adopter";

                    if ($result = mysqli_query($link, $sql)) {
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
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['Adopter_ID'] . "</td>";
                                echo "<td>" . $row['Adopter_fname'] . "</td>";
                                echo "<td>" . $row['Adopter_lname'] . "</td>";
                                echo "<td>" . $row['Adopter_dob'] . "</td>";
                                echo "<td>" . $row['Street'] . "</td>";
                                echo "<td>" . $row['City'] . "</td>";
                                echo "<td>" . $row['State'] . "</td>";
                                echo "<td>" . $row['Zip'] . "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            mysqli_free_result($result);
                        } else {
                            echo "<p>No records were found.</p>";
                        }
                    } else {
                        echo "ERROR: Could not execute $sql. " . mysqli_error($link);
                    }

                    // Close connection
                    mysqli_close($link);
                    ?>
                    <p><a href="../index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
