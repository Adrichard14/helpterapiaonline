<?php
	class File {
		private $folder;
		private $name;
		private $format;
		
		public function __construct($folder, $name = NULL, $format = NULL) {
			if($name == NULL) {
				$filepath = explode("/", $folder);
				$last = sizeof($filepath)-1;
				$folder = "";
				for($i=0; $i<$last; $i++) {
					$folder.=$filepath[$i]."/";
				}
				$name = $filepath[$last];
			}
			$this->folder = $folder;
			if($format == NULL) {
				$filename = explode(".", $name);
				$last = sizeof($filename)-1;
				$name = "";
				for($i=0; $i<$last; $i++) $name.=$filename[$i].".";
				$name = substr($name, 0, strlen($name)-1);
				$format = ".".$filename[$last];
				if($name == "") {
					$name = $filename[0];
					$format = "";
				}
			}
			$this->name = $name;
			$this->format = strpos($format, ".") !== false ? strtolower($format) : ($format != "" ? ".".strtolower($format) : "");
		}
		
		public function get($var) { return $this->{$var}; }
		public function set($var, $value) { $this->{$var} = $value; }
		public function fullpath() { return $this->folder.$this->name.$this->format; }
		public function filename($prefix = "", $sufix = "") { return $prefix.$this->name.$sufix.$this->format; }
		public function isFile() { return is_file($this->fullpath()); }
		public function isFolder() { return is_dir($this->fullpath()); }
		
		public function delete() { //just an shortcut to File::deleteFolder on File objects
			return File::deleteFolder($this->fullpath());
		}
		
		public static function createFolder($folderpath) {
			return file_exists(dirname($folderpath)) ? !file_exists($folderpath) && mkdir($folderpath, 0775) : File::createFolder(dirname($folderpath)) && mkdir($folderpath, 0775);
		}
		
		public static function deleteFolder($folderpath) { //also delete files, just in case
			if(file_exists($folderpath)) {
				if(is_file($folderpath)) return unlink($folderpath);
				if(substr($folderpath, -1) !== "/") $folderpath.="/";
				$subfiles = glob($folderpath."*");
				$deleted = true;
				if($subfiles != NULL && !empty($subfiles)) {
					foreach($subfiles as $folder)
						$deleted = $deleted && deleteFolder($folder);
				}
				return $deleted && rmdir($folderpath);
			}
			return false;
		}
		
		public function download() {
			if(ini_get('zlib.output_compression')) ini_set('zlib.output_compression', 'Off');
			$fsize = filesize($this->fullpath());
			$path_parts = pathinfo($this->fullpath());
			$ext = strtolower($path_parts["extension"]);
			switch ($this->format) {
				case ".pdf": $ctype="application/pdf"; break;
				case ".exe": $ctype="application/octet-stream"; break;
				case ".zip": $ctype="application/zip"; break;
				case ".doc": $ctype="application/msword"; break;
				case ".xls": $ctype="application/vnd.ms-excel"; break;
				case ".ppt": $ctype="application/vnd.ms-powerpoint"; break;
				case ".gif": $ctype="image/gif"; break;
				case ".png": $ctype="image/png"; break;
				case ".jpeg":
				case ".jpg": $ctype="image/jpg"; break;
				default: $ctype="application/force-download";
			}
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private", false);
			header("Content-Type: " . $ctype); 
			header("Content-Disposition: attachment; filename=\"" . $this->filename()."\";"); 
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: " . $fsize);
			$file_transfer = fopen($this->fullpath(), "r");
			fpassthru($file_transfer);
			fclose($file_transfer);
		}
		
		public static function upload($FILES, $topfolder, $getlist = false, $adddate = true) {
			if(!empty($FILES)) {
				$uploads = $FILES['file'];
				$filecount = is_array($uploads["name"]) ? count($uploads['name']) : 0;
				$base = "";
				while(!file_exists($base."lib")) $base.="../";
				$folder = $base.$topfolder;
				if(!file_exists($folder) && !File::createFolder($folder)) {
					exit('Erro ao criar pasta '.$folder);
					return false;
				}
				$folder.="/";
                $topfolder.="/";
				$uploaded = array();
				if($filecount > 0)
					for($file=0; $file < $filecount; $file++) {
						$filename = new File($uploads['name'][$file]);
                        $filename = Format::toURL($filename->get("name").($adddate ? date("Y-m-d").rand() : "")).strtolower($filename->get("format"));
						if(!file_exists($folder.$filename)) {
							move_uploaded_file($uploads['tmp_name'][$file], $folder.$filename);
							touch($folder.$filename);
							$uploaded[] = $topfolder.$filename;
						} else $errors[] = $uploads['name'][$file];
					}
				else {
					$filename = new File($uploads['name']);
					$filename = Format::toURL($filename->get("name").($adddate ? date("Y-m-d").rand() : "")).strtolower($filename->get("format"));
					if(!file_exists($folder.$filename)) {
						move_uploaded_file($uploads['tmp_name'], $folder.$filename);
						touch($folder.$filename);
						$uploaded[] = $topfolder.$filename;
					} else $errors[] = $uploads['name'];
				}
				if(isset($errors)) {
					$count = sizeof($errors);
					$err = "";
					for($i = 0; $i < $count; $i++) {
						if($i < $count-2) {
							$and = ", ";
						} elseif($i < $count-1) {
							$and = " e ";
						} else $and = ".";
						$err.=$errors[$i].$and;
					}
					exit("Já existe(m) arquivo(s) com esse(s) nome(s): ".$err);
				} else if($getlist) return $uploaded;
				else exit("Todos os arquivos foram enviados com sucesso!");
			} else exit("Selecione um arquivo primeiro!");
		}
		
		/////////////////////////////////////////////////////////////////////////////////////////// IMAGE QUERIES
		
		public static function imageProcessing($basefolder, $FILES, $resolutions, $old = "", $crop = false) {
			if(is_array($FILES) && !empty($FILES)) {
				$base = ""; while(!file_exists($base."lib")) $base.="../";
				$folder = $base.$basefolder;
				if(!file_exists($folder)) File::createFolder($folder);
                $bfolder = $basefolder;
				if(substr($basefolder, -1) !== "/") $basefolder.="/";
				if(substr($folder, -1) !== "/") $folder.="/";
				$image = new File($folder, $FILES['name']);
                $image->set("format", strtolower($image->get("format")));
				$image->set("name", md5(date('Ymd').time().rand()));
				$img = $image->uploadImage($FILES['tmp_name'], $resolutions, $crop, $bfolder) ? $basefolder.$image->filename() : $old;
				if($img != $old && $old != "" && file_exists($base.$old)) File::deleteImages($base, $old, $resolutions);
			}
			return isset($img) ? $img : $old;
		}
		
		public static function deleteImages($base, $URL, $resolutions) {
			if($resolutions !== NULL && is_array($resolutions) && !empty($resolutions)) {
				foreach($resolutions as $re) {
					if($re === NULL) {
						if(file_exists($base.$URL)) unlink($base.$URL);
					} else {
						$file = new File($base.$URL);
						if(file_exists($file->get("folder").$file->filename("", "_".$re["name"]))) {
							unlink($file->get("folder").$file->filename("", "_".$re["name"]));
						}
					}
				}
			} else {
				 if(file_exists($base.$URL)) unlink($base.$URL);
			}
		}
		
        public static function animated_gif($filename) {
            if(!($fh = @fopen($filename, 'rb')))
                return false;
            $count = 0;
            //an animated gif contains multiple "frames", with each frame having a 
            //header made up of:
            // * a static 4-byte sequence (\x00\x21\xF9\x04)
            // * 4 variable bytes
            // * a static 2-byte sequence (\x00\x2C) (some variants may use \x00\x21 ?)

            // We read through the file til we reach the end of the file, or we've found 
            // at least 2 frame headers
            while(!feof($fh) && $count < 2) {
                $chunk = fread($fh, 1024 * 100); //read 100kb at a time
                $count += preg_match_all('#\x00\x21\xF9\x04.{4}\x00(\x2C|\x21)#s', $chunk, $matches);
           }

            fclose($fh);
            return $count > 1;
        }
		public function uploadImage($tmp, $resolutions = NULL, $crop = false, $gifemergencyfolder = "") {
			switch(strtolower($this->format)) {
				case '.jpg' : $img = imagecreatefromjpeg($tmp); break;
				case '.png' : $img = imagecreatefrompng($tmp); break;
				case '.gif' :
                    if(self::animated_gif($tmp)) {
                        $uploaded = self::upload(array("file" => array("tmp_name" => $tmp, "name" => $this->filename())), $gifemergencyfolder, true, false);
                        return !empty($uploaded);
                    } else
                        $img = imagecreatefromgif($tmp);
                    break;
				default: $img = -1; break;
			}
			if($img != -1) {
				$x = imagesx($img); $y = imagesy($img);
				if($resolutions == NULL || !is_array($resolutions) || empty($resolutions)) { //original size
					$cropped = imagecreatetruecolor($x, $y);
					imagealphablending($cropped,false);
					imagesavealpha($cropped,true);
					imagecopyresampled($cropped , $img, 0, 0, 0, 0, $x, $y, $x, $y);
					switch($this->format){
						case '.jpg' :  imagejpeg($cropped, $this->fullpath(),100); break;
						case '.png' :  imagepng($cropped, $this->fullpath()); break;
						case '.gif' :  imagegif($cropped, $this->fullpath()); break;
					}
					imagedestroy($cropped);
				} else { //list of resolutions
					foreach($resolutions as $re) {
						if($re == NULL) { //original size
							$name = $this->filename();
							$w = $x;
							$h = $y;
						} else {
							$name = $this->filename("", "_".$re["name"]);
							$w = $re['width'];
							$h = $re['height'];
						}
						
						$dest_x = isset($re["x0"]) ? $re["x0"] : ($crop && $x > $w ? intval(($x-$w)/2) : 0);
						$dest_y = isset($re["y0"]) ? $re["y0"] : ($crop && $y > $h ? intval(($y-$h)/2) : 0);
						$out_x = isset($re["crop_w"]) ? $re["crop_w"] : $x-$dest_x;
						$out_y = isset($re["crop_h"]) ? $re["crop_h"] : $y-$dest_y;
						$cropped = imagecreatetruecolor($w, $h);
						imagealphablending($cropped,false);
						imagesavealpha($cropped,true);
						imagecopyresampled($cropped , $img, 0, 0, $dest_x, $dest_y, $w, $h, $out_x, $out_y);
						switch(strtolower($this->format)){
							case '.jpg' :  imagejpeg($cropped, $this->folder."/".$name,100); break;
							case '.png' :  imagepng($cropped, $this->folder."/".$name); break;
							case '.gif' :  imagegif($cropped, $this->folder."/".$name); break;
						}
						imagedestroy($cropped);
					}
				}
				imagedestroy($img);
				return true;
			}
			return false;
		}
        
        /**
         * Explode an complete path to a directory or a file, separating the path into an String-indexed Array.
         * @params String $fullpath the complete path to a directory or a file.
         * @returns false if file/directory doesn't exists or doesn't has an valid MimeType attatched to extension or an String-indexed Array (indexes: "folderpath", "filename", "extension" and "mimetype")
        */
        public static function explode_path($fullpath, $ext = NULL) {
            if(!file_exists($fullpath)) return false;
            if(!is_dir($fullpath)) {
                $folderpath = '';
                $parts = explode("\\", $fullpath);
                $last = sizeof($parts)-1;
                for($i=0;$i<$last-1;$i++) if($parts[$i] != "")
                    $folderpath.=($i>0?"\\":'').$parts[$i];
                $parts = explode(".", $parts[$last]);
                $len = sizeof($parts);
                if($len > 1) {
                    $filename = '';
                    $extension = '.'.$parts[$len-1];
                    if($extension == ".tmp")
                        $extension = $ext;
                    for($i=0;$i<$len-1;$i++)
                        $filename.=($i>0?".":"").$parts[$i];
                    $mimetype = isset(self::$MIMETYPES[$extension]) ? self::$MIMETYPES[$extension] : "";
                } else {
                    $filename = $parts[0];
                    $extension = $ext != NULL ? $ext : "";
                    $mimetype = isset(self::$MIMETYPES[$extension]) ? self::$MIMETYPES[$extension] : "";
                }
            } else {
                $folderpath = '';
                $parts = explode("\\", $fullpath);
                for($i=0;$i<sizeof($parts)-1;$i++) if($parts[$i] != "")
                    $folderpath.=($i>0?"\\":'').$parts[$i];
                $filename = '';
                $extension = '';
                $mimetype = 'text/directory';
            }
            return array(
                "folderpath" => $folderpath,
                "filename" => $filename,
                "extension" => $extension,
                "mimetype" => $mimetype
            );
            
        }
        
        /**
         * Checks if a extension and Mime-Type can be relationed.
         * @params String $extension the extension to check.
         * @params String $mimetype the Mime-Type to check.
         * @returns true if passed on the test, false if not.
        */
        public static function isValidMime($extension, $mimetype) {
            if($extension == ".tmp")
                return true;
            foreach(self::$MIMETYPES as $mime)
                if($mimetype === $mime)
                    return true;
            return false;
        }
        public static $MIMETYPES = array(
            /* Image */
            ".png"      => "image/png",
            ".jpg"      => "image/jpeg",
            ".jpeg"     => "image/jpeg",
            ".gif"      => "image/gif",
            /* Others */
            ".swf"      => "application/x-shockwave-flash",
            ".htm"      => "text/html",
            ".html"     => "text/html"
        );
	}
?>