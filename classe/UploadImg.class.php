<?php
class UploadImg {

	public  $altura;
	public  $largura;
	public  $hash;
	private $dir;
	public  $tipo;
	public  $uploaddir;
    public function UploadImg(){
    	$this->dir="";
    }

	public function upload($file){
	   	if(isset($file)){
			$this->dir = $this->criarDir($this->uploaddir);
			$this->uploaddir = Config::$dir.$this->dir;
			if(move_uploaded_file($file['tmp_name'],$this->uploaddir.$this->hash.".temp")){		        
		        $this->caminho = $this->uploaddir;
		        $this->gerarImg($this->altura,$this->largura,"p");
		        unlink($this->uploaddir.$this->hash.".temp");
		    	return $this->dir;
		    }else{
		    	return $this->dir;
		    }		
		}else{
			return $this->dir;
		}
   	}

	private function criarDir(){
			$hash = $this->hash;
			if(!is_dir(Config::$dir.$this->uploaddir.$hash{0})){
				mkdir(Config::$dir.$this->uploaddir.$hash{0},0775);
			}
			$this->uploaddir=$this->uploaddir.$hash{0};
			if(!is_dir(Config::$dir.$this->uploaddir."/".$hash{1})){
				mkdir(Config::$dir.$this->uploaddir."/".$hash{1},0775);
			}			
			$this->uploaddir=$this->uploaddir."/".$hash{1};
			if(!is_dir(Config::$dir.$this->uploaddir."/".$hash{2})){
				mkdir(Config::$dir.$this->uploaddir."/".$hash{2},0775);
			}			
			$this->uploaddir=$this->uploaddir."/".$hash{2}."/";
			return $this->uploaddir;		
	}
	
   	private function gerarImg($h,$w,$t){
		chmod($this->uploaddir.$this->hash.".temp",0777);
		$filename = $this->uploaddir.$this->hash.".temp";
		$width    = $w;
		$height   = $h;
		list($width_orig, $height_orig) = getimagesize($filename);
		if($width && ($width_orig < $height_orig)){
		    $width = ($height / $height_orig) * $width_orig;
		}else{
		    $height = ($width / $width_orig) * $height_orig;
		}		
		$image_p = imagecreatetruecolor($width, $height);
		$this->tipo = str_replace(".","",trim($this->tipo));
		if($this->tipo=="x-png" || $this->tipo=="png"){
			$this->tipo = "png";
			$image = imagecreatefrompng($filename);	
			imagealphablending($image_p, false);                                                                                
			$color = imagecolorallocatealpha($image_p, 0, 0, 0, 127);
			imagefill($image_p, 0, 0, $color);
			imagesavealpha($image_p, true);			
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		    $foto  = $this->hash.".".$this->tipo;
	        imagepng($image_p,$this->uploaddir.$foto);
		}else if($this->tipo=="pjpeg" || $this->tipo=="pjpg" || $this->tipo=="jpeg" || $this->tipo=="jpg"){
			$this->tipo = "jpeg";
			$image = imagecreatefromjpeg($filename);			
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		    $foto = $this->hash.".".$this->tipo;
	        ImageJPEG ($image_p,$this->uploaddir.$foto,75);
		}else if($this->tipo=="gif"){
			$this->tipo = "gif";
			$image = imagecreatefromgif($filename);			
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		    $foto = $this->hash.".".$this->tipo;
	        imagegif($image_p,$this->uploaddir.$foto);			
		}
		chmod($this->uploaddir.$foto,0777);
   	}		
}
?>