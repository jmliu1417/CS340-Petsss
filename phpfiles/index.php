<?php
	// session_start();
	// //$currentpage="View Employees"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company DB</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
	<style type="text/css">
        .wrapper{
            width: 70%;
            margin:0 auto;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
		 $('.selectpicker').selectpicker();
    </script>
</head>
<body>
    <?php
        // Include config file
        //require_once "config.php";
//		include "header.php";
	?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
		    <div class="page-header clearfix">
		     <h2> Project CS 340 Final Project: Pet Adoption System </h2> 
                       <p> Authors: Bessie He, Carlana So, Jamie Liu </p>
                       <p>Project includes CRUD operations. In this website you can:
				<ol> 	
                    <li> CREATE new employees, volunteers, pets, and adopters profiles</li>
					<li> RETRIEVE all dependents and information on a specific profile</li>
                    <li> UPDATE profile records</li>
					<li> DELETE profile records </li>
				</ol>
		       <h2 class="pull-left">Employee Details</h2>
                        <a href="createEmployee.php" class="btn btn-success pull-right">Add New Employee</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select all employee query execution
					// *****
					// Insert your function for Salary Level
					/*
						$sql = "SELECT Ssn,Fname,Lname,Salary, Address, Bdate, PayLevel(Ssn) as Level, Super_ssn, Dno
							FROM EMPLOYEE";
					*/
                    $sql = "SELECT Employee_ID, Employee_fname, Employee_lname, Employee_pos, Employee_salary, Employee_Phone_number, Employee_age, Manager_id
							FROM employee";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th width=10%>Employee ID</th>";
                                        echo "<th width=10%>First Name</th>";
                                        echo "<th width=10%>Last Name</th>";
                                        echo "<th width=10%>Position </th>";
										echo "<th width=5%>Salary </th>";
										echo "<th width = 15%>Phone Number</th>";
                                        echo "<th width=5%> Age  </th>";
                                        echo "<th width =5%>Manager ID  </th>";
                                        echo "<th width =5%>Actions  </th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['Employee_ID'] . "</td>";
                                        echo "<td>" . $row['Employee_fname'] . "</td>";
                                        echo "<td>" . $row['Employee_lname'] . "</td>";
										echo "<td>" . $row['Employee_pos'] . "</td>";									
										echo "<td>" . $row['Employee_salary'] . "</td>";
                                        echo "<td>" . $row['Employee_Phone_number'] . "</td>";										
                                        echo "<td>" . $row['Employee_age'] . "</td>";
										echo "<td>" . $row['Manager_id'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='viewProjects.php?Ssn=". $row['Ssn']."&Lname=".$row['Lname']."' title='View Projects' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='updateEmployee.php?Ssn=". $row['Ssn'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='deleteEmployee.php?Ssn=". $row['Ssn'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
											echo "<a href='viewDependents.php?Ssn=". $row['Ssn']."&Lname=".$row['Lname']."' title='View Dependents' data-toggle='tooltip'><span class='glyphicon glyphicon-user'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. <br>" . mysqli_error($link);
                    }
					echo "<br> <h2> Department Stats </h2> <br>";
					
					
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>

</body>
</html>
