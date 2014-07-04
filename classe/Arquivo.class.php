<?php

class Arquivo {
	public $nome;
	public $conteudo;
	public $diretorio; 

	public function gerar(){
		$handle = fopen($this->diretorio.$this->nome, 'wr+');
		fwrite($handle, $this->conteudo);
		fclose($handle); 	
	}
	public function ler(){
		$conteudo = "";
		$arquivo  = $this->diretorio.$this->nome;
		$handle   = fopen($arquivo, "r");
		do {
		    $data=fread($handle, 8192);
		    if (strlen($data) == 0) {
		        break;
		    }
		    $conteudo .= $data;
		} while(true);
		fclose ($handle);				
		return $conteudo;
	}
}
?>