<?php

include '../index.php';

onPost(function() {

          $data = getPostData();

          $trackId = $data['trackId'];

          putStorage($trackId);

          $out['out'] = getStorage();

          return $out;

});