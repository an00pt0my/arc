<?php

class Roles {
  
  // Properties
  public $id;
  public $movieId;
  public $actorId;
  public $roleName;

  // This is just a dummy database connection code to use in data fetching method.
  public $conn = new mysqli("localhost", "root", "", "arc");

  // Function to return all roles as JSON
  function getMovieRolesAsJson($movieId = 0) {

    if(!is_numeric($movieId)) $movieId = 0;

    // array to return the results
    $arrResult = array();
    
    // Get the values
    $sqlQry = "SELECT r.id as roleId, r.role_name as roleName FROM roles r WHERE r.movie_id = " . $movieId;
    $objResults = $this->conn->query($sqlQry);

    // If record exists, then insert into the array and convert into json format to return the results.
    if($objResults->num_rows > 0) {
      while($rowResult = $objResults->fetch_assoc()) {
        $arrResult[] = $rowResult;
      }
    }

    // Return the result as json.
    return json_encode($arrResult);
  }
}

$objRole = new Roles();

// Function call to get all movies in JSON format
$movieRoles = $objRole->getMovieRolesAsJson(1);