<?php
	require_once 'pessoa.php';
	$p = new Pessoa("crudpdo", "localhost", "root", "");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Cadastro Pessoa</title>
	<link rel="stylesheet" href="estilo.css">
</head>
<body>
	<?php
		if(isset($_POST['nome'])){

			if(isset($_GET['id_up']) && !empty($_GET['id_up'])){ 
			//-------------------- ATUALIZAR -----------------

				$id_upd = addslashes($_GET['id_up']);
				$nome = addslashes($_POST['nome']);
				$telefone = addslashes($_POST['telefone']);
				$email = addslashes($_POST['email']);
				
				if(!empty($nome) && !empty($telefone) && !empty($email)){
					//ATUALIZAR
					$p->atualizarDados($id_upd, $nome, $telefone, $email);
					header("location: index.php");
				}

			}else{ // ---------- CADASTRAR --------------------
				
				$nome = addslashes($_POST['nome']);
				$telefone = addslashes($_POST['telefone']);
				$email = addslashes($_POST['email']);
				
				if(!empty($nome) && !empty($telefone) && !empty($email)){
					//cadastrar
					if(!$p->cadastrarPessoa($nome, $telefone, $email)){
						echo "Email já cadastrado!";
					}
				}else{
					echo "Preencha todos os campos!";
				}
			}
		}
	?>
	<?php

		if(isset($_GET['id_up'])){
			$id_update = addslashes($_GET['id_up']);
			$resultado = $p->buscarDadosPessoa($id_update);
		}
	?>
	<section id="esquerda">
			<form method="POST">
				<h2>CADASTRAR PESSOA</h2>
				<label for="nome">Nome</label>
				<input type="text" name="nome" id="nome" value="<?php if(isset($resultado)){echo $resultado['nome'];}?>">
				<label for="telefone">Telefone</label>
				<input type="text" name="telefone" id="telefone" value="<?php if(isset($resultado)){echo $resultado['telefone'];}?>">
				<label for="email">Email</label>
				<input type="email" name="email" id="email" value="<?php if(isset($resultado)){echo $resultado['email'];}?>">
				<input type="submit" name="" value="<?php if(isset($resultado)){echo "Atualizar";}else{echo "Cadastrar";}?>">
			</form>
	</section>
	<section id="direita">
		<table>
			<tr id="titulo">
				<td>NOME</td>
				<td>TELEFONE</td>
				<td colspan="2">EMAIL</td>
			</tr>
		<?php
			$dados = $p->buscarDados();
			if(count($dados)>0){
				for($i=0; $i<count($dados); $i++){
					echo "<tr>";
					foreach ($dados[$i] as $key => $value) {
						if($key!= "id"){
							echo "<td>".$value."</td>";
						}
					}
				?>
					<td><a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
						<a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
					</td>
				<?php
					echo "</tr>";
				}
			}else{
				echo "AINDA NÃO HÁ PESSOAS CADASTRADAS.";
			}
			
		?>
		</table>
		
	</section>

</body>
</html>
<?php
	
	if(isset($_GET['id'])){
		$id_pessoa = addslashes($_GET['id']);
		$p->excluirPessoa($id_pessoa);
		header("location: index.php");
	}
?>