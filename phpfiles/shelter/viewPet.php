<?php
	session_start();
    // Include config file
    require_once "../config.php";
    if (isset($_GET['Shelter_ID'])) {
        $shelter_id = $_GET['Shelter_ID'];
    } else {
        die("Shelter ID not specified.");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Pets</title>
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
                        <h2 class="pull-left">Pet Records for Shelter <?php echo htmlspecialchars($shelter_id); ?></h2>
                    </div>
                    <?php
                    // Prepare a select statement 
                    $sql = "SELECT * FROM pet WHERE Shelter_ID = ?";
                    
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "i", $param_shelter_id);
                        $param_shelter_id = $shelter_id;

                        // EAttempt to execute the prepared statement
                        if (mysqli_stmt_execute($stmt)) {
                            $result = mysqli_stmt_get_result($stmt);
                            if (mysqli_num_rows($result) > 0) {
                                echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Pet_ID</th>";
                                echo "<th>Pet name</th>";
                                echo "<th>Pet type</th>";
                                echo "<th>Pet breed</th>";
                                echo "<th>Pet age</th>";
                                echo "<th>Pet time</th>";
                                echo "<th>Pet status</th>";
                                echo "<th>Shelter ID</th>";
                                echo "<th>Adopter ID</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['Pet_ID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Pet_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Pet_type']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Pet_breed']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Pet_age']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Pet_time']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Pet_status']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Shelter_ID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Adopter_ID']) . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "</table>";
                                mysqli_free_result($result);
                            } else {
                                echo "<p>No pets found for this shelter.</p>";
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
