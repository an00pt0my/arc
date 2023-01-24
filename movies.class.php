<?php

class Movies {
  
  // Properties
  public $id;
  public $movieTitle;
  public $movieLength;
  public $movieReleaseDate;

  // This is just a dummy database connection code to use in data fetching method.
  public $conn = new mysqli("localhost", "root", "", "arc");

  // Function to return all movies as JSON
  function getAllMoviesAsJson() {

    // array to return the results
    $arrResult = array();
    
    // Get the values
    $sqlQry = "SELECT m.id as movieId, m.movie_title as movieTitle, m.movie_length as movieLength, m.movie_date as movieReleaseDate FROM movies m";
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

  // Function to return details of a single movie
  function getMovieDetails($movieId = 0) {

    if(!is_numeric($movieId)) $movieId = 0;
    
    // Get the values
    $sqlQry = "SELECT m.movie_title as movieTitle, m.movie_length as movieLength, m.movie_date as movieReleaseDate FROM movies m WHERE m.id = " . $movieId;
    $objResults = $this->conn->query($sqlQry);

    // Return the result as an array.
    return $objResults->fetch_array();
  }

  // Function to return all actors in a movie
  function getActorsInMovie($movieId = 0) {

    if(!is_numeric($movieId)) $movieId = 0;

    // array to return the results
    $arrResult = array();
    
    // Get the values
    $sqlQry = "SELECT a.id as actorId, a.actor_name as actorName, a.actor_dob as actorDob, r.role_name as actorRole FROM actors a, roles r WHERE r.actor_id = a.id AND r.movie_id = " . $movieId . " ORDER BY a.actor_dob ASC";
    $objResults = $this->conn->query($sqlQry);

    // If record exists, then insert into the result array and return the results.
    if($objResults->num_rows > 0) {
      while($rowResult = $objResults->fetch_assoc()) {
        $arrResult[] = $rowResult;
      }
    }

    // Return the result.
    return $arrResult;
  }
}

$objMovie = new Movies();

// Function call to get all movies in JSON format
$allMovies = $objMovie->getAllMoviesAsJson();

// Function call to get a single movie details
$arrMovieDetails = $objMovie->getMovieDetails(1);

// Function call to get the actors of a movie 
$arrMovieActors = $objMovie->getActorsInMovie(1);