<?php
class Foto {
	private $arquivo;
	private $fotos;
	private $contador;
	public $login;  
    public function Foto(){
		$this->arquivo = new Arquivo();
    	$this->contador = 0;
    }
    public function dados(){
    	return 	$this->fotos;
    }
    public function pegarId(){
    	return $this->contador;
    }
	public function carregar(){
		if(file_exists(Config::$dir.strtolower(trim($this->login))."/foto.xml")){
			$xml = simplexml_load_file(Config::$dir.strtolower(trim($this->login))."/foto.xml");
			foreach ($xml->foto as $foto) {
				if(isset($foto->titulo) && isset($foto->texto)){
				   $this->fotos[$this->contador] = array(
				   		'id'=>$foto->id,
				   		'data'=>$foto->data,
				   		'url'=>$foto->url,
						'titulo'=>$foto->titulo,
				   		'texto'=>$foto->texto
				   );
				   $this->contador++;						
				}
			}			
		}else{
			$this->fotos=null;
		}	
	}
	public function adicionarElemento($vetor){
	   if(is_array($vetor)){
		   $this->fotos[$this->contador] = array(
		   		'id'=>$vetor['id'],
		   		'data'=>$vetor['data'],
		   		'titulo'=>$vetor['titulo'],
		   		'texto'=>$vetor['texto'],
		   		'url'=>$vetor['url']
		   );
		   $this->contador++;									   	
	   }
	}
	public function excluir($id){
		$this->carregar();
		$tempVetor = null;
		$j=0;
		$x=0;
		while($this->fotos[$x]){
			if($id!=$this->fotos[$x]['id']){
				$tempVetor[$j]['id']     = $j;
				$tempVetor[$j]['titulo'] = $this->fotos[$x]['titulo'];
				$tempVetor[$j]['data']   = $this->fotos[$x]['data'];
				$tempVetor[$j]['texto']  = $this->fotos[$x]['texto'];
				$tempVetor[$j]['url']    = $this->fotos[$x]['url'];
				$j++;	
			}else{
				unlink(Config::$dir.$this->login."/".$this->fotos[$x]['url']);				
			}
			$x++;	
		}
		$this->fotos = $tempVetor;
		$this->contador = $j;
		$this->gerarXml();    	
    }
	public function gerarXml(){
		if($this->fotos==null){
			$xml = '<?xml version="1.0" encoding="UTF-8"?>' .
				'<corpo>' .
					'<foto></foto>'.
				'</corpo>';
		}elseif(is_array($this->fotos)){
			$x=0;
			$xml = '<?xml version="1.0" encoding="UTF-8"?><corpo>';
			while($this->fotos[$x]){
				$xml=$xml.'<foto>' .
							'<id>'.$this->fotos[$x]['id'].'</id>'.
							'<data><![CDATA['.$this->fotos[$x]['data'].']]></data>'.
							'<titulo><![CDATA['.$this->fotos[$x]['titulo'].']]></titulo>'.
							'<texto><![CDATA['.$this->fotos[$x]['texto'].']]></texto>'.							
							'<url><![CDATA['.$this->fotos[$x]['url'].']]></url>'.							
						'</foto>';
				$x++;
			}
			$xml=$xml.'</corpo>';			
		}
		$this->arquivo->nome      = "foto.xml";
		$this->arquivo->diretorio = Config::$dir.strtolower(trim($this->login))."/";
		$this->arquivo->conteudo  = $xml;
		$this->arquivo->gerar();
		$this->gerarPagina();
	}
	private function gerarPagina(){
		$html  = new GerarHtml();
		if(file_exists(Config::$dir.strtolower(trim($this->login))."/info.xml")){
			$xml = simplexml_load_file(Config::$dir.strtolower(trim($this->login))."/info.xml");
			$html->dados['titulo'] = $xml->titulo;
		}else{
			$html->dados['titulo'] = "";
		}
		$texto = "";
		$x=0;
		while($this->fotos[$x]){
			$html->dados['foto'] = $this->fotos[$x]['url'];
			$texto = $texto."<div>".$this->fotos[$x]['titulo']."<br/>" .
								$html->embedfoto().
								"<br/>".$this->fotos[$x]['texto']."<br/>
								<br/>
								<i>postado dia:</i>".$this->fotos[$x]['data']."
							</div>";
			$x++;
		}
		$html->dados['conteudo']  = $texto;
		$html->dados['site']      = Config::$url;
		$this->arquivo->nome      = "foto.html";
		$this->arquivo->diretorio = Config::$dir.strtolower(trim($this->login))."/";
		$this->arquivo->conteudo  = $html->index();
		$this->arquivo->gerar();		
	}
}
?>