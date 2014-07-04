function Ajax(){   
	this.xml           = null;
	this.linkXml       = null;
	this.xmlHttp       = null;
	this.conteudo      = null;
	this.funcao        = function(){}
	
	this.setXmlHttp = function(){
		try{
	       		 this.xmlHttp = xmlhttp = new XMLHttpRequest();
		}catch(ee){
		        try{
		                this.xmlHttp = xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		        }catch(e){
		                try{
		                        this.xmlHttp = xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		                }catch(E){
		                        this.xmlHttp = xmlhttp = false;
		                }
		        }
		}
  		return this.xmlHttp;
	} 
	
	this.setConteudo = function(tmp){
		this.conteudo=tmp;	
	}
	
	this.setXml = function(tmp){
		this.linkXml=tmp;	
	}

		
	this.envia = function(){
	 	window.status = "enviando";
		this.setXmlHttp();
		var enviar = {
			xmlHttp : this.xmlHttp,
			xml     : null,
			func    : this.funcao
		};
		enviar.xmlHttp.open("POST",this.linkXml,true);
		enviar.xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		enviar.xmlHttp.setRequestHeader('Content-length',this.conteudo.length );
		enviar.xmlHttp.onreadystatechange = function(){
			if (enviar.xmlHttp.readyState == '4'&& enviar.xmlHttp.status == 200){
				enviar.func();
	 			window.status = "";
			}	
		}
		enviar.xmlHttp.send(this.conteudo);	
	}
}