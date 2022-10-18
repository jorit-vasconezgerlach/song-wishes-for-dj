<?php

include '../index.php';

onPost(function() {

          $data = getPostData();

          $trackId = $data['trackId'];

          $out['error'] = false;
          $out['out'] = inStorage($trackId);

          return $out;

});