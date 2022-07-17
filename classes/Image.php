<?php

    class Image{

        public function getReducedWidth($percent, $width){
            return $this->getPercentage($percent, $width);
        }
        
        public function getReducedHeight($percent, $height){
            return $this->getPercentage($percent, $height);
        }
        
        public function reduceSizeByHeight($height, $to){
            $d = ($to < $height) ? ceil(($to / $height) * 100) : ceil(($height / $to) * 100);
            return $d;
        }

        public function reduceSizeByWidth($width, $to){
            $d = ($to < $width) ? ceil(($to / $width) * 100) : ceil(($width / $to) * 100);
            return $d;
        }
        
        private function getPercentage($percentage, $number){
            return ceil(($percentage / 100) * $number);
        }

        private function resizeFn($rid, $w, $h, $resize_to, $dim){
            $get = (strtolower($dim) == "width") ? $this->reduceSizeByWidth($w, $resize_to) : $this->reduceSizeByHeight($h, $resize_to);
            $tw = $this->getReducedWidth($get, $w);
            $th = $this->getReducedHeight($get, $h);
            $tl = imagecreatetruecolor($tw, $th);
            imagecopyresampled($tl, $rid, 0, 0, 0, 0, $tw, $th, $w, $h);
            return $tl;
        }

        public function createInitialAvatar(
                string $initials,
                array $bgColor = [0,0,0],
                array $textColor = [255, 255, 255], 
                int $w = 150, 
                int $h = 150, 
                int $fontSize = 50,
                string $font = STATIC_FILES_DIR."/fonts/OpenSans-Bold.ttf"
            ){
            //path to store image
            $image_name  = $initials."_".time().".png";
            $path_to_img = AVATARS_DIR."/".$image_name;
            //create image
            $avatar   = @imagecreatetruecolor($w, $h) or die("cannot initialize image stream");
            //add background color
            imagecolorallocate($avatar, $bgColor[0], $bgColor[1], $bgColor[2]);
            //add text color
            $fontColor = imagecolorallocate($avatar, $textColor[0], $textColor[1], $textColor[2]);
            //add font
            $ttb       = imagettfbbox($fontSize, 0, $font, $initials);
            //get x and y dimensions
            $x = abs(ceil(($w - $ttb[2]) / 2));
            $y = abs(ceil(($h - $ttb[5]) / 2));
            //add text
            imagettftext($avatar, $fontSize, 0, $x, $y, $fontColor, $font, $initials);
            imagepng($avatar, $path_to_img);
            imagedestroy($avatar);
            return $image_name;
        }

        //resize image private function
        public function createImgThumbnail($img, $size, $side, $file_path){
            $img_tmp    = $img["tmp_name"];
            $prop       = getimagesize($img_tmp); 
            $img_ext    = pathinfo($img["name"], PATHINFO_EXTENSION);
            $nfn        = $this->rename_img($img["name"]."_thumb", $img_ext);
            $pni        = $file_path.$nfn;
            switch($prop[2]){
                case IMAGETYPE_GIF:
                    $img_rid = imagecreatefromgif($img_tmp);
                    $tl      = $this->resizeFn($img_rid, $prop[0], $prop[1], $size, $side);
                    imagegif($tl, $pni);
                    break;
                case IMAGETYPE_PNG:
                    $img_rid = imagecreatefrompng($img_tmp);
                    $tl      = $this->resizeFn($img_rid, $prop[0], $prop[1], $size, $side);
                    imagepng($tl, $pni);
                    break;
                case IMAGETYPE_JPEG:
                    $img_rid = imagecreatefromjpeg($img_tmp);
                    $tl      = $this->resizeFn($img_rid, $prop[0], $prop[1], $size, $side);
                    imagejpeg($tl, $pni);
                    break;
                default:
                    $this->createInitialAvatar("Failed");
                    break;
            }
        }

        public function rename_img($new_name, $ext){
            return $new_name.".".$ext;
        }


    }