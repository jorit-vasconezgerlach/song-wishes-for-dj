<?php

// json header
header('Content-Type: application/json');
header('Accept: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

// standard out
$out = array(
          'error' => true,
          'responseMsg' => 'Unknown error!',
          'responseCode' => null
);

function onPost($action) {
          if($_SERVER['REQUEST_METHOD'] == 'POST') {
                    echo json_encode($action(), JSON_PRETTY_PRINT);
          }
}

// accept json and form post
function getPostData() {
          if($_POST == []) {
                    return json_decode(file_get_contents('php://input'), true);
          } else {
                    return $_POST;
          }
}