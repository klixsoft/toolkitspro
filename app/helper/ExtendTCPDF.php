<?php

namespace AST\Helper;

include MODULE_PATH . "tcpdf/tcpdf.php";

class ExtendTCPDF extends \TCPDF {

    /**
     * Display an image
     * 
     * @param string $file path to image file
     * @param float $x abscissa of the image (in user units)
     * @param float $y ordinate of the image (in user units)
     * @param float $w width of the image (in user units)
     * @param float $h height of the image (in user units)
     * @param string $type image format
     * @param string $link URL or identifier returned by AddLink()
     * @param bool $align (optional) if true align on the center, if false align on the top-left (default true)
     * @param bool $resize (optional) if true resizes the image proportionally (default false)
     * @param int $dpi (optional) image resolution in DPI (default 96)
     * @param string $palign (optional) image alignment within cell (L, C, R, T, M, B)
     * @param bool $ismask (optional) whether this image is a mask (default false)
     * @param int $imgmask (optional) image mask identifier
     * @param mixed $border (optional) image border size (array with one to four integers, default 0)
     * @param mixed $fitbox (optional) how to fit the image inside the box (fit, fitbox, true, false)
     * @param string $alttext (optional) text to display as an alternative to the image
     * 
     * @return bool true on success, false otherwise
     */
    public function Image($file, $x=null, $y=null, $w=0, $h=0, $type='', $link='', $align=true, $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=null, $border=0, $fitbox=false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = []) {
        if ($type == 'webp') {
            // Load the WebP image using GD library
            $image = imagecreatefromwebp($file);
            
            // Get the image dimensions
            $width = imagesx($image);
            $height = imagesy($image);
            
            // Calculate the target dimensions if necessary
            if ($w == 0 && $h == 0) {
                $w = $width / ($dpi / 72);
                $h = $height / ($dpi / 72);
            } else if ($w == 0) {
                $w = $h * $width / $height;
            } else if ($h == 0) {
                $h = $w * $height / $width;
            }
        
            // Add the image to the PDF document
            $this->Image(
                $image,
                $x,
                $y,
                $w,
                $h,
                '',
                $link,
                $align,
                $resize,
                $dpi,
                $palign,
                $ismask,
                $imgmask,
                $border,
                $fitbox,
                $alttext
            );
            
            return true;
        } 
        
        // Call the parent method for other image formats
        return parent::Image($file, $x, $y, $w, $h, $type, $link, $align, $resize, $dpi, $palign, $ismask, $imgmask, $border, $fitbox, $hidden, $fitonpage, $alt, $altimgs);
    }

}