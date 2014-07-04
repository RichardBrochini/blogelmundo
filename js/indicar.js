function indicar(){
	var email = document.getElementById("email").value;
	var a     = new Ajax();				
	a.funcao = function(){
		alert("E-mail Enviado");
	}
	a.setConteudo("acao=indicar&email="+email);
	a.setXml(url+"ajax.controller.php?");
	a.envia();
}