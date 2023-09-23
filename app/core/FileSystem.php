<?php

namespace AST;

use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class FileSystem
{

    public static function create($path, $isFolder=false){
        if( ! file_exists( $path ) ){
            if( $isFolder ){
                mkdir($path, 0777, true);
            }else{
                fclose(fopen($path, "w+"));
                chmod($path, 0777);
            }
        }
        return file_exists( $path );
    }

    public static function download($url, $saveFilePath) {
        $fileHandle = fopen($saveFilePath, 'w');
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_FILE => $fileHandle,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false
        ));
        
        curl_exec($curl);
    
        $error = "";
        if (curl_errno($curl)) {
            $error = curl_error($curl);
        }
        
        fclose($fileHandle);
        curl_close($curl);

        if( ! empty( $error ) ){
            @unlink($saveFilePath);
            return false;
        }

        return true;
    }    

    public static function write($file, $content){
        if( ! file_exists( $file ) ){
            self::create($file, false);
        }

        return file_put_contents($file, $content);
    }

    public static function extension($file){
        return pathinfo($file, PATHINFO_EXTENSION);
    }

    protected static function deleteFile($path){
        return unlink($path);
    }

    protected static function deleteFolder($path){
        if( is_dir( $path ) ){
            if (substr($path, strlen($path) - 1, 1) != '/') {
                $path .= '/';
            }

            $files = glob($path . '*', GLOB_MARK);
            foreach ($files as $file) {
                if (is_dir($file)) {
                    self::deleteFolder($file);
                } else {
                    self::deleteFile($file);
                }
            }
            rmdir($path);
        }
        return ! file_exists( $path );;
    }

    public static function delete($path, $isFolder = false){

        if( file_exists( $path ) ){
            if( $isFolder ){
                return self::deleteFolder($path);
            }else{
                return self::deleteFile($path);
            }
        }
        return true;
    }

    public static function copy_folder($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    self::copy_folder($src . '/' . $file,$dst . '/' . $file);
                }
                else { 
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }


    /**
     * Zip a folder (including itself).
     * 
     */
    public static function zipDir($sourcePath, $outZipPath, $allowed=false){
        $zip = new ZipArchive();
        if (file_exists($outZipPath)) {
            if ($zip->open($outZipPath, ZipArchive::OVERWRITE) == true) {
                self::dirToZip($sourcePath, $zip, $allowed);
            }
        }else{
            if ($zip->open($outZipPath, ZipArchive::CREATE) == true) {
                self::dirToZip($sourcePath, $zip, $allowed);
            }
        }
        $zip->close();
        return file_exists($outZipPath);
    }

    /**
     * Add files and sub-directories in a folder to zip file.
     * 
     */
    private static function dirToZip($folderPath, ZipArchive $zip, $allowed=false){

        $source = rtrim($folderPath, "/");
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($source) + 1);

                if( $allowed && is_array( $allowed ) ){
                    $fileExt = pathinfo($filePath, PATHINFO_EXTENSION);
                    if( in_array( $fileExt, $allowed ) ){
                        $zip->addFile($filePath, $relativePath);
                    }
                }else{
                    $zip->addFile($filePath, $relativePath);
                }
            }
        }
    }

    private static function addFilesToZip($files, $zip){
        foreach($files as $file){
            $zip->addFile($file, pathinfo($file, PATHINFO_BASENAME));
        }
    }

    /**
     * Convert all files to zip
     */
    public static function zipFiles($files, $outZipPath){
        $zip = new ZipArchive();
        if (file_exists($outZipPath)) {
            if ($zip->open($outZipPath, ZipArchive::OVERWRITE) == true) {
                self::addFilesToZip($files, $zip);
            }
        }else{
            if ($zip->open($outZipPath, ZipArchive::CREATE) == true) {
                self::addFilesToZip($files, $zip);
            }
        }
        $zip->close();
        return file_exists($outZipPath);
    }
}