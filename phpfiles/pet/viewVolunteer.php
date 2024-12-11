<?php
	session_start();
    // Include config file
    require_once "../config.php";
    if (isset($_GET['Pet_ID'])) {
        $Pet_ID = $_GET['Pet_ID'];
    } else {
        die("Pet_ID not specified.");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Volunteers</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
	   <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Volunteer Records<?php echo htmlspecialchars($shelter_id); ?></h2>
                    </div>
                    <?php
                    // Prepare a select statement 
                    $sql = "SELECT * FROM volunteer";
                    
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        // Bind variables to the prepared statement as parameters
                        // mysqli_stmt_bind_param($stmt, "i", $param_pet_id);
                        // $param_pet_id = $Pet_ID;

                        // EAttempt to execute the prepared statement
                        if (mysqli_stmt_execute($stmt)) {
                            $result = mysqli_stmt_get_result($stmt);
                            if (mysqli_num_rows($result) > 0) {
                                echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Volunteer ID</th>";
                                echo "<th>First name</th>";
                                echo "<th>Last name</th>";
                                echo "<th>Phone number</th>";
                               
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['Volunteer_ID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Volunteer_fname']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Volunteer_lname']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Volunteer_phone_number']) . "</td>";
                                }
                                echo "</tbody>";
                                echo "</table>";
                                mysqli_free_result($result);
                            } else {
                                echo "<p>No volunteers found for this shelter.</p>";
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
