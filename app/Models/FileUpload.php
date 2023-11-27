<?php

namespace App\Models;

class FileUpload{
    var $name;
    var $extension;
    var $RealPath;
    var $size;
      var $MimeType;

    function __construct($name = "default",$extension = "default",$RealPath = "default",$size = 0,$MimeType = "default") {
        $this->name = $name;
        $this->extension = $extension;
        $this->RealPath = $RealPath;
        $this->size = $size;
        $this->MimeType = $MimeType;
      }
}

?>