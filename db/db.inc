<?php


function _connect() {
  // create mysqli object
  // open connection
  // set server access variables
  $host = "localhost";
  $user = "fanmap";
  $pass = "fanmap";
  $db = "fanmap";
  
  $mysqli = new mysqli($host, $user, $pass, $db);

  // check for connection errors
  if (mysqli_connect_errno()) {
      die("Unable to connect!");
  } else {
    return $mysqli;
  }
}

function _updateFan($id, $fanDetails) {
  // Connect to db
  $mysqli = _connect();

  foreach($fanDetails as $key => $value) {
    $values[] = $key . "=" . "\"$value\"";
  }

  // create query
  $query = "UPDATE Fan SET " . implode(',', $values) . " WHERE id = $id ;";

  // execute query
  $result = $mysqli->query($query);
  
  // look for errors and print
  if(!$result) {
    $error_number = $mysqli->errno;
    $error_msg = $mysqli->error;
    echo "MySQL error $error_number: $error_msg: $query";   
  } 

  // close connection
  $mysqli->close();
}

function queryDB($query) {
  // Connect to db
  $mysqli = _connect();

  // execute query
  $result = $mysqli->query($query);
  
  // look for errors and print
  if(!$result) {
    $error_number = $mysqli->errno;
    $error_msg = $mysqli->error;
    echo "MySQL error $error_number: $error_msg: $query";   
    return null;
  } 
  
  while($row = $result->fetch_assoc()) {
    $rows[] = $row;
  }
  
  // free result set memory
  $result->close();
  // close connection
  $mysqli->close();

  return $rows;
}

function _insertFan($fanDetails) {
  // Connect to db
  $mysqli = _connect();

  foreach($fanDetails as $key => $value) {
    $colValues[] = $key;
    $values[] = $value;
  }

  // create query
  $query = "INSERT INTO Fan (" . implode(',', $colValues) . ')';
  $valueString = ' VALUES ("' . implode('","', $values) . '");';

  // execute query
  $result = $mysqli->query($query . $valueString);
  
  // look for errors and print
  if(!$result) {
    $error_number = $mysqli->errno;
    $error_msg = $mysqli->error;
    echo "MySQL error $error_number: $error_msg: $query$valueString";   
    echo "MySQL error $error_number: $error_msg";   
  } 
 
  // close connection
  $mysqli->close();
}

function updateFan($fanDetails) {
  // create query
  $query = 'SELECT id FROM Fan where fb_page_id = "' . $fanDetails['fb_page_id'] . '" AND fb_user_id = "' . $fanDetails['fb_user_id'] . '"';
  $existing = queryDB($query);
  // print_r($existing);
  if($existing != null)
    _updateFan($existing[0]['id'], $fanDetails);
  else
    _insertFan($fanDetails);
}
?> 
