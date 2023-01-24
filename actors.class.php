<?php

class Actors {
  
  // Properties
  public $id;
  public $actorName;
  public $actorDob;

  // This is just a dummy database connection code to use in data fetching method.
  public $conn = new mysqli("localhost", "root", "", "arc");

  // Function to return all actors as JSON
  function getAllActorsAsJson() {

    // array to return the results
    $arrResult = array();
    
    // Get the values
    $sqlQry = "SELECT a.id as actorId, a.actor_name as actorName, a.actor_dob as actorDob FROM actors a";
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

  // Function to return details of a single actor
  function getActorDetails($actorId = 0) {

    if(!is_numeric($actorId)) $actorId = 0;
    
    // Get the values
    $sqlQry = "SELECT a.actor_name as actorName, a.actor_dob as actorDob FROM actors a WHERE a.id = " . $actorId;
    $objResults = $this->conn->query($sqlQry);

    // Return the result as an array.
    return $objResults->fetch_array();
  }
}

$objActor = new Actors();

// Function call to get all actors in JSON format
$allActors = $objActor->getAllActorsAsJson();

// Function call to get a single actor details
$arrActorDetails = $objActor->getActorDetails(1);