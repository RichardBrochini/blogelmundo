<?php

class Texto {
	private $arquivo;
	private $textos;
	private $contador;
	public $login;  
    public function Texto(){
		$this->arquivo = new Arquivo();
    	$this->contador = 0;
    }
    public function dados(){
    	return 	$this->textos;
    }
    public function pegarId(){
    	return $this->contador;
    }
	public function carregar(){
		if(file_exists(Config::$dir.strtolower(trim($this->login))."/texto.xml")){
			$xml = simplexml_load_file(Config::$dir.strtolower(trim($this->login))."/texto.xml");
			foreach ($xml->texto as $texto) {
				if(isset($texto->titulo) && isset($texto->texto)){
				   $this->textos[$this->contador] = array(
				   		'id'=>$texto->id,
				   		'data'=>$texto->data,
				   		'titulo'=>$texto->titulo,
				   		'texto'=>$texto->texto
				   );
				   $this->contador++;						
				}
			}			
		}else{
			$this->textos=null;
		}	
	}
	public function adicionarElemento($vetor){
	   if(is_array($vetor)){
		   $this->textos[$this->contador] = array(
		   		'id'=>$vetor['id'],
		   		'data'=>$vetor['data'],
		   		'titulo'=>$vetor['titulo'],
		   		'texto'=>$vetor['texto']
		   );
		   $this->contador++;									   	
	   }
	}
	public function excluir($id){
		$this->carregar();
		$tempVetor = null;
		$j=0;
		$x=0;
		while($this->textos[$x]){
			if($id!=$this->textos[$x]['id']){
				$tempVetor[$j]['id']     = $j;
				$tempVetor[$j]['titulo'] = $this->textos[$x]['titulo'];
				$tempVetor[$j]['data']   = $this->textos[$x]['data'];
				$tempVetor[$j]['texto']  = $this->textos[$x]['texto'];
				$j++;	
			}
			$x++;	
		}
		$this->textos = $tempVetor;
		$this->contador = $j;
		$this->gerarXml();    	
    }
	public function gerarXml(){
		if($this->textos==null){
			$xml = '<?xml version="1.0" encoding="UTF-8"?>' .
				'<corpo>' .
					'<texto></texto>'.
				'</corpo>';
		}elseif(is_array($this->textos)){
			$x=0;
			$xml = '<?xml version="1.0" encoding="UTF-8"?><corpo>';
			while($this->textos[$x]){
				$xml=$xml.'<texto>' .
							'<id>'.$this->textos[$x]['id'].'</id>'.
							'<data><![CDATA['.$this->textos[$x]['data'].']]></data>'.
							'<titulo><![CDATA['.$this->textos[$x]['titulo'].']]></titulo>'.
							'<texto><![CDATA['.$this->textos[$x]['texto'].']]></texto>'.							
						'</texto>';
				$x++;
			}
			$xml=$xml.'</corpo>';			
		}
		$this->arquivo->nome      = "texto.xml";
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
		while($this->textos[$x]){
			$texto = $texto."<div>".$this->textos[$x]['titulo']."<br/>
								".$this->textos[$x]['texto']."<br/>
								<br/>
								<i>postado dia:</i>".$this->textos[$x]['data']."
							</div>";
			$x++;
		}
		$html->dados['conteudo']  = $texto;
		$html->dados['site']      = Config::$url;
		$this->arquivo->nome      = "texto.html";
		$this->arquivo->diretorio = Config::$dir.strtolower(trim($this->login))."/";
		$this->arquivo->conteudo  = $html->index();
		$this->arquivo->gerar();		
	}
}
?>