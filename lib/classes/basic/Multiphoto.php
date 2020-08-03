<?php
    class Multiphoto {
        private $photoURLs;
        private $photos;
        public static $FOLDER = 'uploads/images';
        public static $RESOLUTIONS = array(
            NULL,
            array("name" => "thumb", "width" => 767, "height" => 1022)
        );
        public function __construct($photoURLs) {
            $this->photoURLs = $photoURLs;
            $temp = explode(";", $photoURLs);
            $this->photos = array();
            foreach($temp as $t) {
                if($t == "")
                    continue;
                list($URL, $title) = self::explode_($t);
                if($URL == "")
                    continue;
                $this->photos[$URL] = array("URL" => $URL, "title" => $title);
            }
        }
        public function get($var) {
            return $this->{$var};
        }
        public function output($gallery = false, $fullscreen = false) {
            $output = '<ul class="row" id="photos">';
            if(empty($this->photos))
                return $output.'</ul>';
            if($gallery) {
                foreach($this->photos as $photo)
                    $output.=self::gallery_layout($photo['title'], $photo['URL'], $photo['URL'], $fullscreen);
            } else {
                $counter = 0;
                foreach($this->photos as $photo) {
                    $output.=self::admin_layout($photo['title'], $photo['URL'], $photo['URL'], 'r_id'.($counter++), $fullscreen);
                }
            }
            return $output.'</ul>';
        }
        public static function admin_layout($title, $URL, $shortURL, $i = "{id}", $fullscreen = false) {
            return '<li class="ui-state-default col-xs-12'.($fullscreen ? '' : ' col-sm-6 col-md-4 col-lg-3').' form-group" id="'.$i.'">'.
                        '<div class="admin-gallery">'.
                            '<div class="slim slim-gallery" data-service="responses/slim.php" data-ratio="'.Format::ratio(self::$RESOLUTIONS[1]['width'], self::$RESOLUTIONS[1]['height']).'" data-min-size="10,10" data-force-size="'.self::$RESOLUTIONS[1]['width'].','.self::$RESOLUTIONS[1]['height'].'">'.
//                            '<div class="slim slim-gallery" data-service="responses/slim.php" data-ratio="'.Format::ratio(self::$RESOLUTIONS[1]['width'], self::$RESOLUTIONS[1]['height']).'" data-force-size="'.self::$RESOLUTIONS[1]['width'].','.self::$RESOLUTIONS[1]['height'].'">'.
//                            '<div class="slim slim-gallery" data-service="responses/slim.php" data-min-size="10,10">'.
                                '<input type="file" name="slim[]" class="form-control" />'.
                                '<img src="'.PUBLIC_URL.$URL.'" class="admin-gallery-image" alt="" data-file="'.$shortURL.'" />'.
                            '</div>'.
                            '<ul>'.
                                '<li data-attatched="0" data-func="del" id="'.$i.'_rm" data-ID="'.$i.'" data-URL="'.$URL.'" data-send="'.($i == '{id}' ? '1' : '0').'">'.
                                    '<i class="icon-remove"></i>'.
                                    '<span>Excluir</span>'.
                                '</li>'.
                            '</ul>'.
                            '<span>['.$i.']</span>'.
                        '</div>'.
                        '<input type="text" class="form-control admin-gallery-title" placeholder="Digite um título para esta foto" data-ID="'.$i.'" data-URL="'.$URL.'" value="'.$title.'" />'.
                    '</li>';
        }
        public static function gallery_layout($title, $URL, $shortURL, $fullscreen = false) {
            return '<li class="col-xs-12'.($fullscreen ? '' : ' col-sm-6 col-md-4 col-lg-3').' form-group">'.
                        '<a class="fancybox fancybox-img" href="'.PUBLIC_URL.'/'.$URL.'" title="'.$title.'" rel="gallery" data-fancybox-group="maingroup">'.
                            '<img src="'.PUBLIC_URL.'/'.$shortURL.'" class="img-responsive" />'.
                        '</a>'.
                    '</li>';
        }
        
        public static function getOutput($photoURLs, $gallery = false, $fullscreen = false) {
            $obj = new self($photoURLs);
            return $obj->output($gallery, $fullscreen);
        }
        
        # removeExif Font: https://stackoverflow.com/a/47152957/4265572
        public static function removeExif($input, $output) {
            $buffer_len = 4096;
            $fd_in = fopen($input, 'rb');
            $fd_out = fopen($output, 'wb');
            while (($buffer = fread($fd_in, $buffer_len)))
            {
                //  \xFF\xE1\xHH\xLLExif\x00\x00 - Exif 
                //  \xFF\xE1\xHH\xLLhttp://      - XMP
                //  \xFF\xE2\xHH\xLLICC_PROFILE  - ICC
                //  \xFF\xED\xHH\xLLPhotoshop    - PH
                while (preg_match('/\xFF[\xE1\xE2\xED\xEE](.)(.)(exif|photoshop|http:|icc_profile|adobe)/si', $buffer, $match, PREG_OFFSET_CAPTURE))
                {
                    $len = ord($match[1][0]) * 256 + ord($match[2][0]);
                    fwrite($fd_out, substr($buffer, 0, $match[0][1]));
                    $filepos = $match[0][1] + 2 + $len - strlen($buffer);
                    fseek($fd_in, $filepos, SEEK_CUR);
                    $buffer = fread($fd_in, $buffer_len);
                }
                fwrite($fd_out, $buffer, strlen($buffer));
            }
            fclose($fd_out);
            fclose($fd_in);
        }
        public static function upload($fullscreen = false) {
            if(!isset($_FILES, $_FILES['img'], $_FILES['img']['tmp_name']) || empty($_FILES['img']['tmp_name']))
                exit("Selecione uma imagem.");
            $title = isset($_POST, $_POST['title']) ? trim(strip_tags($_POST['title'])) : "";
            $path = 'uploads/multiplo/';
            $base = '';
            while(!file_exists($base."lib"))
                $base.="../";
            if(!is_dir($base.$path))
                mkdir($base.$path, 0775, $recursive = true);
            $split = explode(".", $_FILES['img']['name']);
            $last = $split[count($split)-1];
            unset($split[count($split)-1]);
            $filename = uniqid().'_'.Format::toURL(implode(".", $split)).".".strtolower($last);
            $URL = $path.$filename;
            if($URL == "")
                exit("Falha ao tentar enviar imagem.");
            self::removeExif($_FILES['img']['tmp_name'], $base.$path.$filename);
            $output = array("status" => 1, "HTML" => self::admin_layout($title, $URL, $URL, $i = "{id}", $fullscreen), "URL" => $URL, "title" => $title);
            exit(json_encode($output));
        }
        public static function update($oldURLs, $newURLs) {
            $old = new self($oldURLs);
            $new = new self($newURLs);
            $old = $old->get("photos");
            $new = $new->get("photos");
            $to_delete = array();
            foreach($old as $URL => $photo)
                if(!isset($new[$URL]))
                    $to_delete[] = $URL;
            if(empty($to_delete))
                return false;
            $base = "";
            while(!file_exists($base."lib"))
                $base.="../";
            foreach($to_delete as $URL)
                File::deleteImages($base, $URL, self::$RESOLUTIONS);
        }
        public static function delete() {
            if(!isset($_POST, $_POST['URL']))
                exit();
            $base = "";
            while(!file_exists($base."lib"))
                $base.="../";
            File::deleteImages($base, $_POST['URL'], self::$RESOLUTIONS);
        }
        public static function print_($photoURLs) {
            echo self::getOutput($photoURLs);
        }
        public static function _print($photoURLs) {
            self::print_($photoURLs);
        }
        public static function explode_($photoURL) {
            return explode(":", $photoURL);
        }
        public static function _explode($photoURL) {
            return self::explode_($photoURL);
        }
        public static function gallery($photoURLs) {
            echo self::getOutput($photoURLs, true);
        }
    }
?>