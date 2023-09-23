<?php

namespace AST\Helper;

use Imagick;
use AST\Tempdir;
use AST\FileSystem;
use AST\Download;

class convertImage extends Tempdir{

    private $fromExport = "png";
    private $toExport = "png";
    private $outputPath;
    private $outputURL;
    private $error;

    private function convert( ){
        $source = $this->getFile();
        $this->outputPath = $this->tempPDFDir . $this->getFileName($this->toExport);

        $image = new Imagick($source);

        /** Set background color to white (for JPG format) */
        if ($this->toExport === 'jpg' || $this->toExport === 'avif') {
            $image->setImageBackgroundColor('white');
            $image = $image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
        }
        
        $image->setImageCompressionQuality(100);
        // $image->setImageFormat($this->toExport);
        $image->writeImage($this->outputPath);
        $image->destroy();

        return $this;
    }

    public function setExt($from, $to){
        $this->fromExport = $from;
        $this->toExport = $to;
        return $this;
    }

    public function gifConvert(){
        $source = $this->getFile();
        $this->outputPath = $this->tempPDFDir . $this->getFileName($this->toExport);

        $image = new Imagick($source);
        $image = $image->coalesceImages();
        $image->setImageFormat($this->toExport);
        $image->setImageBackgroundColor('white');
        $image->setImageCompressionQuality(100);

        $destination = $this->outputPath;
        $image->writeImages($destination, true);
        $image->clear();
        $image->destroy();

        $zipFile = $this->tempPDFDir . $this->getFileName("zip");
        if( FileSystem::zipDir($this->tempPDFDir, $zipFile, array($this->toExport)) ){
            $this->outputPath = $zipFile;
        }else{
            $this->error = "Unable to archive all GIF frames.";
            // $this->outputPath = str_replace(".$this->toExport", "-0.$this->toExport", $this->outputPath);
        }

        return $this;
    }

    public function generate( $ext ){
        $this->toExport = $ext;
        $this->fromExport = $this->getExt();

        /** Generate Favicon.ico */
        if( $this->fromExport == 'gif' ){
            $this->gifConvert();
        }else{
            $this->convert();
        }
         
        if( file_exists( $this->outputPath ) ){
            $this->outputURL = get_temp_url( "tools/$this->name/$this->fileFolder/" . pathinfo($this->outputPath, PATHINFO_BASENAME) );
        }

        return $this;
    }

    public function archiveAll($jobs, $ext){
        if( $this->fromExport == 'gif' ){
            $ext = "zip";
        }

        foreach($jobs as $job){
            $jobPath = get_temp_path( "tools/$this->name/$job/" );
            $filePath = get_first_filename($jobPath, $ext);
            if( $filePath ){
                $files[] = $filePath;   
            }

            if( ! empty( $files ) ){
                $zipFile = $this->tempPDFDir . "archived.zip";
                $zipFileURL = get_temp_url("tools/$this->name/" . $this->jobID() . "/archived.zip");

                if( \AST\FileSystem::zipFiles($files, $zipFile) ){
                    $this->outputPath = $zipFile;
                    $this->outputURL = $zipFileURL;
                }else{
                    $this->error = "Unable to archive all files. Please try again!!!";
                }
            }else{
                $this->error = "All Job Ids are invalid. Please try again!!!";
            }
        }

        return $this;
    }

    public function download($title){
        if( 
            empty( $this->outputURL ) 
            || !file_exists( $this->outputPath ) 
            || !empty( $this->error 
        ) ){
            $error = sprintf("Unable to convert %s to %s. Please try again!!!", strtoupper($this->fromExport), strtoupper($this->toExport));
            return array(
                "success" => false,
                "message" => !empty($this->error) ? $this->error : $error
            );
        }        

        $ext = pathinfo($this->outputPath, PATHINFO_EXTENSION);
        $fileSize = get_file_size($this->outputURL);
        $downloadLink = \AST\Download::set_data(array(
            "url" => $this->outputURL,
            "atts" => array(
                "Source" => $this->get_site_name(),
                "Title" => $title,
                "File Size" => format_size($fileSize),
                "Format" => $ext
            ),
            "extension" => $ext,
            "size" => $fileSize,
            "source" => "tkp",
            "name" => $this->getFileName()
        ));

        return array(
            "success" => true,
            "message" => $downloadLink,
            "job" => $this->jobID()
        );
    }

}