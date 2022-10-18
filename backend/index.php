<?php

// Using the (very good) Deezer API
// https://api.deezer.com/

header('Content-Type: application/json');
header('Accept: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
          
          // accept json and form post
          if($_POST == []) {
                    $data = json_decode(file_get_contents('php://input'), true);
          } else {
                    $data = $_POST;
          }

          // standard out
          $out = array(
                    'error' => true,
                    'responseMsg' => 'Unknown error!',
                    'responseCode' => null
          );

          // search result
          $searchURL = "https://api.deezer.com/search/?q=".$data['search'];
          $searchResult = file_get_contents($searchURL);

          // validate JSON
          $validJSON = json_decode($searchResult);
          if (json_last_error() === 0) {
                    // valid JSON
                    $out['error'] = false;
                    $out['responseMsg'] = 'Music Searched';
                    $out['responseCode'] = 200;
                    $out['out'] = file_get_contents($searchURL);
          } else {
                    // invalid JSON
                    $out['responseMsg'] = 'Invalid Deezer data';
                    $out['responseCode'] = 500;
          }

          echo json_encode($out, JSON_PRETTY_PRINT);

}