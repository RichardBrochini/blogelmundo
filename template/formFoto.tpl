<div id="formFoto">
	<center>
		<form action="?acao=cadastrar&tipo={tipo}" method="POST" enctype="multipart/form-data" >
		 	<table>
		 		<tr>
		 			<td>Titulo:</td>
		 			<td><input type="text" name="titulo" value="" /></td>
		 		</tr>
		 		<tr>
		 			<td>Foto:</td>
		 			<td><input type="file" name="foto" value=""/></td>
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