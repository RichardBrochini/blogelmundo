<div id="formTexto">
	<center>
		<form action="?acao=cadastrar&tipo={tipo}" method="POST">
		 	<table>
		 		<tr>
		 			<td>Titulo:</td>
		 			<td><input type="text" name="titulo" value="" /></td>
		 		</tr>
		 		<tr>
		 			<td>URL:</td>
		 			<td><input type="text" name="video" value="" /><i>(url do <a href="http://www.youtube.com/?gl=BR&hl=pt" target="_blank">youtube</a>)</i></td>
		 		</tr>
		 		<tr>
		 			<td>Texto:</td>
		 			<td><textarea name="texto" rows="10" cols="50" wrap="off"></textarea></td>
		 		</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Cadastrar" /></td>
				</tr>				
		 	</table>
		</form>
	</center>
</div>