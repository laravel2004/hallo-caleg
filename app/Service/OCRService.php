<?php
namespace App\Service;
use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Models\FileUpload;
use Illuminate\Http\Request;
class OCRService extends FileUpload {

    public static function readImage($file){
        $readFile = new FileUpload();
        $file = $file->file('file');
        $readFile->name = $file->getClientOriginalName();
        $readFile->extension = $file->getClientOriginalExtension();
        $readFile->RealPath = $file->getRealPath();
        $readFile->size = $file->getSize();
        $readFile->MimeType = $file->getMimeType();
        $PATH = '../TempFiles/';
        $fileName = $readFile->name;
		if($file->move($PATH,$fileName)){
        return (new TesseractOCR($PATH.$fileName))->run();
        }else{
            throw new Exception("Error : File Failed to Upload!");
        }
    }
}

?>