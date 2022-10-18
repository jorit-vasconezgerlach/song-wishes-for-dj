<?php

include '../index.php';

// Using the (very good) Deezer API
// https://api.deezer.com/

onPost(function() {

          $data = getPostData();
          
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

          return $out;

});