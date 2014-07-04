var nome = "";
var url  = "";
function mostrarPaleta(nome){
	var paleta     = new Cor();
	paleta.div     = "paletaCores";
	paleta.chamada = "salvarCor";
	paleta.cubo();
	campo          = nome;
}

function salvarCor(hex){
	if(campo!=""){
		var hex = "#"+hex;
		var antiCache = Math.round(9999*Math.random());
		var a  = new Ajax();				
		a.funcao = function(){
			document.styleSheets[0].href=document.styleSheets[0].href+"?&"+antiCache;
			alert("Cor Alterada");
		}
		a.setConteudo("acao=salvar.cor&nome="+campo+"&valor="+hex);
		a.setXml(url+"ajax.controller.php?"+antiCache);
		a.envia();
		var divObj = document.getElementById("tabelaCores");
		divObj.style.display = 'none';		
	}
}

function Cor(){
	this.hex     = new Array(6);
	this.hex[0]  = "FF";
	this.hex[1]  = "CC";
	this.hex[2]  = "99";
	this.hex[3]  = "66";
	this.hex[4]  = "33";
	this.hex[5]  = "00";
	this.div     = "";
	this.html    = "";
	this.chamada = "";
	
	this.cubo = function(){
		var divObj = document.getElementById("tabelaCores");
		if(divObj==null){
			var divNova = document.createElement("div"); 
			divNova.id  = "tabelaCores"; 
			this.html   = "";
			this.html   = '<TABLE CELLPADDING=5 CELLSPACING=0 BORDER=1><TR>';
			for (var i  = 0; i < 6; ++i) {
				this.html = this.html+'<TD BGCOLOR="#FFFFFF">';
				this.drawTable(this.hex[i])
				this.html = this.html+'</TD>';
			}
			this.html = this.html+'</TR></TABLE>';
			var div = document.getElementById(this.div);
			div.appendChild(divNova);
			divNova.innerHTML = this.html;			
		}else{
			var div = document.getElementById(this.div);
			divObj.style.display = 'block';
		}
	}
	
	this.drawCell = function(red, green, blue){
		this.html = this.html+'<TD BGCOLOR="#' + red + green + blue + '">';
		this.html = this.html+'<A HREF="javascript:'+this.chamada+'(\'' + (red + green + blue) + '\')">';
		this.html = this.html+'--';
		this.html = this.html+'</A>';
		this.html = this.html+'</TD>';
	}
	this.drawRow = function(red, blue) {
		this.html = this.html+'<TR>';
		for (var i = 0; i < 6; ++i) {
			this.drawCell(red, this.hex[i], blue)
		}
		this.html = this.html+'</TR>';
	}
	 
	this.drawTable = function(blue) {
		this.html = this.html+'<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0>';
		for (var i = 0; i < 6; ++i) {
			this.drawRow(this.hex[i], blue)
		}
		this.html = this.html+'</TABLE>';	
	}
}
this.display = function(triplet) {
	var divObj = document.getElementById("tabelaCores");
	divObj.style.display = 'none';
}