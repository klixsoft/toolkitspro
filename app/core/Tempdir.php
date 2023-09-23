<?php

namespace AST;

use Exception;

class Tempdir{

    public $tempDir;
    public $tempPDFDir;
    public $fileFolder;
    public $file;
    public $name;

    public function __construct( $name, $type="tools" ){
        $this->name = $name;
        $this->type = $type;
        $this->tempDir = TEMP_PATH . $type . "/" . $name . "/";  
    }

    public function setup(){
        if( ! file_exists( $this->tempDir ) ){
            mkdir($this->tempDir, 0777, true);
        }
        $this->generate_file_code();
        return $this;
    }

    public function get_site_name(){
        $settings = get_settings("basic");
        return @$settings->name;
    }

    private function generate_file_code(  ){
        $this->fileFolder = generate_string(30, true);
        $fileDir = $this->tempDir . $this->fileFolder . "/";
        if( file_exists( $fileDir ) ){
            $this->generate_file_code();
        }else{
            mkdir($fileDir, 0777, true);
            $this->tempPDFDir = $fileDir;
        }
    }

    public function upload_all( $files ){
        $files_urls = array();
        $file_names = $files["name"];
        for ($i = 0; $i < count($file_names); $i++) {
            $file_name = $file_names[$i];
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);;
            $original_file_name = pathinfo($file_name, PATHINFO_FILENAME);

            $this->file = $original_file_name . "-" . date("YmdHis") . "-$i." . $extension;
            $file_url = $this->tempPDFDir . $this->file;
            move_uploaded_file($files["tmp_name"][$i], $file_url);
        }
        
        return $this;
    }

    public function getFile(){
        return $this->tempPDFDir . $this->file;
    }

    public function jobID(){
        return $this->fileFolder;
    }

    public function getFileName( $ext="" ){
        $file = pathinfo($this->getFile(), PATHINFO_FILENAME);
        return empty($ext) ? $file : "$file.$ext";
    }

    public function getExt(){
        return pathinfo($this->tempPDFDir . $this->file, PATHINFO_EXTENSION);
    }

    public function getFileURL(){
        return get_site_url() . "app/temp/$this->type/$this->name/" . $this->fileFolder . "/";
    }

    public function upload($file){
        if( is_array( $file ) && isset( $file["name"] ) ){
            if( isset( $file['code'] ) ){
                $this->file = "qrcode-" . date("YmdHis") . "." . $file['ext'];
                $file_url = $this->tempPDFDir . $this->file;

                file_put_contents($file_url, base64_decode($file['code']));
                return $this;
            }else if(isset($file["name"])){
                $file_name = $file["name"];
                $extension = pathinfo($file_name, PATHINFO_EXTENSION);;
                $original_file_name = pathinfo($file_name, PATHINFO_FILENAME);

                $this->file = $original_file_name . "-" . date("YmdHis") . "." . $extension;
                $file_url = $this->tempPDFDir . $this->file;
                move_uploaded_file($file["tmp_name"], $file_url);
                return $this;
            }
        }else if( filter_var($file, FILTER_VALIDATE_URL) ){
            return $this->copyURL($file);
        }
    }

    public function copyURL($url){
        $extension = pathinfo($url, PATHINFO_EXTENSION);;
        $original_file_name = pathinfo($url, PATHINFO_FILENAME);

        $this->file = $original_file_name . "-" . date("YmdHis") . "." . $extension;
        $file_url = $this->tempPDFDir . $this->file;
        
        if( empty( $extension ) ){
            throw new Exception("We can't detect image Extension. Try Another url!!!");
        }

        FileSystem::download($url, $file_url);
        if( file_exists( $file_url ) ){
            return $this;
        }

        throw new Exception("Unable to download URL!!!");
    }
}