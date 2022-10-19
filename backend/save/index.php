<?php

include '../index.php';

onPost(function() {

          $data = getPostData();

          $trackId = $data['trackId'];

          putStorage($trackId);

          $out['error'] = false;
          $out['out'] = getStorage();

          return $out;

});