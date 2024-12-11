<?php
	session_start();
	// //$currentpage="View Employees"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pet Adoption System DB</title>
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
                    <li> CREATE new shelter, employees, volunteers, pets, and adopters profiles</li>
					<li> RETRIEVE all information on a specific profile</li>
                    <li> UPDATE profile records</li>
					<li> DELETE profile records </li>
				</ol>
                    <?php
                    // Include config file
                    require_once "config.php";
                    ?>

		            <h2 class="pull-left">Shelter Details</h2>
                        <a href="shelter/createShelter.php" class="btn btn-success pull-right">Add New Shelter</a>
                    </div>
                    <?php
                    //Shelter Table
                    $sql = "SELECT Shelter_ID, Shelter_name, phone_number, Street, City, State, Zip
							FROM shelter";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>"; 
                                        //creating tables
                                        echo "<th width=10%>Shelter ID</th>";
                                        echo "<th width=15%>Name</th>";
                                        echo "<th width=10%>Phone Number</th>";
                                        echo "<th width=10%>Street </th>";
										echo "<th width=5%>City </th>";
										echo "<th width =5%>State</th>";
                                        echo "<th width=5%>Zip </th>";
                                        echo "<th width =5%>Actions  </th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";   
                                        //matching table from database
                                        echo "<td>" . $row['Shelter_ID'] . "</td>";
                                        echo "<td>" . $row['Shelter_name'] . "</td>";
                                        echo "<td>" . $row['phone_number'] . "</td>";
										echo "<td>" . $row['Street'] . "</td>";									
										echo "<td>" . $row['City'] . "</td>";
                                        echo "<td>" . $row['State'] . "</td>";										
                                        echo "<td>" . $row['Zip'] . "</td>";
                                        echo "<td>";
                                            //we can view employees from shelter, volunteers from shelter, pets from shelter
                                            echo "<a href='shelter/viewEmployee.php?Shelter_ID=". $row['Shelter_ID'] ."' title='View Employee' data-toggle='tooltip'><span class='glyphicon glyphicon-briefcase'></span></a>";
                                            echo "<a href='shelter/viewVolunteer.php?Shelter_ID=". $row['Shelter_ID'] ."' title='View Volunteer' data-toggle='tooltip'><span class='glyphicon glyphicon-list-alt'></span></a>";
                                            echo "<a href='shelter/viewPet.php?Shelter_ID=". $row['Shelter_ID'] . "' title='View Pet' data-toggle='tooltip'><span class='glyphicon glyphicon-heart'></span></a>";
                                            echo "<a href='shelter/viewAdopter.php?Adopter_ID=". $row['Adopter_ID'] ."' title='View Adopter' data-toggle='tooltip'><span class='glyphicon glyphicon-user'></span></a>";

                                            echo "<a href='shelter/updateShelter.php?Shelter_ID=". $row['Shelter_ID'] ."' title='Update Shelter Info' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='shelter/deleteShelter.php?Shelter_ID=". $row['Shelter_ID'] ."' title='Delete Shelter Info' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
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
                    ?>

                    <!------------------------------------------------------------------
                    --------------------------------------------------------------------------------- -->

                    <h2 class="pull-left">Employee Details</h2>
                    <a href="employee/createEmployee.php" class="btn btn-success pull-right">Add New Employee</a>
                    <?php
                    //Employee Table
                    $sql2 = "SELECT Employee_ID, Employee_fname, Employee_lname, Employee_pos, Employee_salary, Employee_Phone_number, Employee_age, Manager_id, Shelter_ID
							FROM employee";
                    if($result2 = mysqli_query($link, $sql2)){
                        if(mysqli_num_rows($result2) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>"; 
                                        //creating tables
                                        echo "<th width=10%>Employee ID</th>";
                                        echo "<th width=10%>First Name</th>";
                                        echo "<th width=10%>Last Name</th>";
                                        echo "<th width=10%>Position </th>";
										echo "<th width=5%>Salary </th>";
										echo "<th width = 15%>Phone Number</th>";
                                        echo "<th width=5%> Age  </th>";
                                        echo "<th width =5%>Manager ID  </th>";
                                        echo "<th width =5%>Shelter ID  </th>";
                                        echo "<th width =5%>Actions  </th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result2)){
                                    echo "<tr>";   
                                        //matching table from database
                                        echo "<td>" . $row['Employee_ID'] . "</td>";
                                        echo "<td>" . $row['Employee_fname'] . "</td>";
                                        echo "<td>" . $row['Employee_lname'] . "</td>";
										echo "<td>" . $row['Employee_pos'] . "</td>";									
										echo "<td>" . $row['Employee_salary'] . "</td>";
                                        echo "<td>" . $row['Employee_Phone_number'] . "</td>";										
                                        echo "<td>" . $row['Employee_age'] . "</td>";
										echo "<td>" . $row['Manager_id'] . "</td>";
                                        echo "<td>" . $row['Shelter_ID'] . "</td>";
                                        echo "<td>";
                                            //we can view employee's job location, edit record, and delete record
                                            echo "<a href='employee/updateEmployee.php?Employee_ID=". $row['Employee_ID']  ."' title='Update Employee' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='employee/deleteEmployee.php?Employee_ID=". $row['Employee_ID']  ."' title='Delete Employee' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result2);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql2. <br>" . mysqli_error($link);
                    }
                    ?>

                    <!------------------------------------------------------------------
                    --------------------------------------------------------------------------------- -->

                    <h2 class="pull-left">Pet Details</h2>
                    <a href="pet/createPet.php" class="btn btn-success pull-right">Add New Pet</a>
                    <?php
                    //Pet Table
                    $sql3 = "SELECT Pet_ID, Pet_name, Pet_type, Pet_breed, Pet_age, Pet_time, Pet_status, Shelter_ID, Adopter_ID
							FROM pet";
                    if($result3 = mysqli_query($link, $sql3)){
                        if(mysqli_num_rows($result3) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>"; 
                                        //creating tables
                                        echo "<th width=8%>Pet ID</th>";
                                        echo "<th width=10%>Pet Name</th>";
                                        echo "<th width=10%>Animal Type</th>";
                                        echo "<th width=8%>Breed </th>";
										echo "<th width=5%>Age </th>";
										echo "<th width = 15%>Arrival Date</th>";
                                        echo "<th width=8%>Status</th>";
                                        echo "<th width =5%>Assoicated Shelter ID </th>";
                                        echo "<th width =5%>Adopter ID</th>";
                                        echo "<th width =10%>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result3)){
                                    echo "<tr>";   
                                        //matching table from database
                                        echo "<td>" . $row['Pet_ID'] . "</td>";
                                        echo "<td>" . $row['Pet_name'] . "</td>";
                                        echo "<td>" . $row['Pet_type'] . "</td>";
										echo "<td>" . $row['Pet_breed'] . "</td>";									
										echo "<td>" . $row['Pet_age'] . "</td>";
                                        echo "<td>" . $row['Pet_time'] . "</td>";										
                                        echo "<td>" . $row['Pet_status'] . "</td>";
										echo "<td>" . $row['Shelter_ID'] . "</td>";
                                        echo "<td>" . $row['Adopter_ID'] . "</td>";
                                        echo "<td>";
                                            //we can view pet's adopter and volunteer
                                            echo "<a href='pet/viewPetAdopter.php?Pet_ID=". $row['Pet_ID'] ."' title='View Adopter' data-toggle='tooltip'><span class='glyphicon glyphicon-user'></span></a>";
                                            echo "<a href='pet/viewVolunteer.php?Pet_ID=". $row['Pet_ID'] ."' title='View Volunteer' data-toggle='tooltip'><span class='glyphicon glyphicon-list-alt'></span></a>";
                                            echo "<a href='pet/updatePet.php?Pet_ID=". $row['Pet_ID']  ."' title='Update Pet' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='pet/deletePet.php?Pet_ID=". $row['Pet_ID']  ."' title='Delete Pet' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result3);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql3. <br>" . mysqli_error($link);
                    }
                    ?>
                    
                    <!------------------------------------------------------------------
                    --------------------------------------------------------------------------------- -->
                    
                    <h2 class="pull-left">Adopter Details</h2>
                    <a href="adopter/createAdopter.php" class="btn btn-success pull-right">Add New Adopter</a>
                    <?php
                    //Adopter Table
                    $sql3 = "SELECT Adopter_ID, Adopter_fname, Adopter_lname, Adopter_dob, Street, City, State, Zip
							FROM adopter";
                    if($result3 = mysqli_query($link, $sql3)){
                        if(mysqli_num_rows($result3) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>"; 
                                        //creating tables
                                        echo "<th width=8%>Adopter ID</th>";
                                        echo "<th width=10%>First Name</th>";
                                        echo "<th width=10%>Last Name</th>";
                                        echo "<th width=8%>Date of Birth </th>";
										echo "<th width=8%>Street</th>";
										echo "<th width =5%>City</th>";
                                        echo "<th width=5%>State</th>";
                                        echo "<th width =5%>Zip</th>";
                                        echo "<th width =8%>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result3)){
                                    echo "<tr>";   
                                        //matching table from database
                                        echo "<td>" . $row['Adopter_ID'] . "</td>";
                                        echo "<td>" . $row['Adopter_fname'] . "</td>";
                                        echo "<td>" . $row['Adopter_lname'] . "</td>";
										echo "<td>" . $row['Adopter_dob'] . "</td>";									
										echo "<td>" . $row['Street'] . "</td>";
                                        echo "<td>" . $row['City'] . "</td>";										
                                        echo "<td>" . $row['State'] . "</td>";
										echo "<td>" . $row['Zip'] . "</td>";
                                        echo "<td>";
                                            //we can view adopter's pet
                                            echo "<a href='adopter/viewPet.php?Adopter_ID=". $row['Adopter_ID'] ."' title='View Pet' data-toggle='tooltip'><span class='glyphicon glyphicon-heart'></span></a>";
                                            echo "<a href='adopter/updateAdopter.php?Adopter_ID=". $row['Adopter_ID']  ."' title='Update Adopter' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='adopter/deleteAdopter.php?Adopter_ID=". $row['Adopter_ID']  ."' title='Delete Adopter' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result3);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql3. <br>" . mysqli_error($link);
                    }
                    ?>

                                        <!------------------------------------------------------------------
                    --------------------------------------------------------------------------------- -->
                    
                    <h2 class="pull-left">Volunteer Details</h2>
                    <a href="volunteer/createVolunteer.php" class="btn btn-success pull-right">Add New Volunteer</a>
                    <?php
                    //volunteer Table
                    $sql3 = "SELECT Volunteer_ID, Volunteer_fname, Volunteer_lname, Volunteer_phone_number
							FROM volunteer";
                    if($result3 = mysqli_query($link, $sql3)){
                        if(mysqli_num_rows($result3) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>"; 
                                        //creating tables
                                        echo "<th width=8%>Volunteer ID</th>";
                                        echo "<th width=10%>First Name</th>";
                                        echo "<th width=10%>Last Name</th>";
                                        echo "<th width=8%>Phone Number </th>";
                                        echo "<th width =8%>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result3)){
                                    echo "<tr>";   
                                        //matching table from database
                                        echo "<td>" . $row['Volunteer_ID'] . "</td>";
                                        echo "<td>" . $row['Volunteer_fname'] . "</td>";
                                        echo "<td>" . $row['Volunteer_lname'] . "</td>";
										echo "<td>" . $row['Volunteer_phone_number'] . "</td>";									
                                        echo "<td>";
                                            //we can view volunteer's tasks (taking care of which pet)
                                            //echo "<a href='shelter/viewPet.php?Ssn=". $row['Ssn']."&Lname=".$row['Lname']."' title='View Task' data-toggle='tooltip'><span class='glyphicon glyphicon-list-alt'></span></a>";
                                            echo "<a href='volunteer/updateVolunteer.php?Volunteer_ID=". $row['Volunteer_ID']  ."' title='Update Volunteer' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='volunteer/deleteVolunteer.php?Volunteer_ID=". $row['Volunteer_ID']  ."' title='Delete Volunteer' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result3);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql3. <br>" . mysqli_error($link);
                    }
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>

</body>
</html>
