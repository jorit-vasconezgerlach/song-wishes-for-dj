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

$storageRoot = '../storage/all.json';
function getStorage() {
          global $storageRoot;
          return json_decode(file_get_contents($storageRoot), true);
}
function putStorage($push) {
          global $storageRoot;
          $storage = getStorage();
          array_push($storage, $push);
          $storage = json_encode($storage, JSON_PRETTY_PRINT);
          file_put_contents($storageRoot, $storage);
}
function inStorage($needle) {
          return in_array($needle, getStorage());
}
function clearStorage() {
          global $storageRoot;
          file_put_contents($storageRoot, '');
}

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