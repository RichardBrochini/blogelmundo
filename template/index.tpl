<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
	<head>
		<title>{titulo}</title>
		<link rel="stylesheet" type="text/css" href="css/template.css" />
		<script type="text/javascript" src="../js/Ajax.class.js"></script>
		<script type="text/javascript" src="../js/indicar.js"></script>
	</head>
	<body>
		<div id="conteudo">
			<div id="menu">
					<h1>{titulo}</h1>
					<h2>
						<a href="index.html">Home</a>
						<a href="foto.html">Fotos</a>
						<a href="video.html">Videos</a>
						<a href="texto.html">Textos</a>
					</h2>
			</div>
			<div id="posts">
				{conteudo}
			</div>
			<div id="extra">
				<table>
					<tr>
						<td>
							<h4>Indique Meu Blog</h4>
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" value="" name="email" id="email" />	
						</td>
					</tr>
					<tr>
						<td>
							<input type="button" value="Enviar Indica&ccedil;&atilde;o" onclick="javaScript:indicar();"/>	
						</td>
					</tr>
					<tr>
						<td class="rss">
							<br/><br/>
							<a href="rss.xml"><img src="{site}img/rss.gif" alt="rss" /></a>
						</td>
					</tr>
				</table>
			</div>
			  <p>
			    <a href="http://validator.w3.org/check?uri=referer">
			    	<img src="http://www.w3.org/Icons/valid-xhtml10-blue" alt="Valid XHTML 1.0 Strict" height="31" width="88" />
			    </a>
			  </p>
		</div>
		<script type="text/javascript">
			url = "{site}";
		</script>		
	</body>
</html>