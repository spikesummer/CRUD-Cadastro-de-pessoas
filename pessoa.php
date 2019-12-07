<?php

Class Pessoa{

	private $pdo;
	//CONEXÃO COM OS BANCOS DE DADOS
	public function __construct($dbname, $host, $user, $senha){

		try{
			$this->pdo = new PDO("mysql:dbname=".$dbname."; host=".$host,$user,$senha);
		}catch(PDOException $e){
			echo "Erro com banco de dados: ".$e->getMessage();
		}catch(Exception $e){
			echo "Erro generico: ".$e->getMessage();
		}
	}
	//FUNÇÃO PARA BUSCAR DADOS E COLOCAR NA TELA DIREITA
	public function buscarDados(){
		
		$resultado = array();

		$res = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
		$resultado = $res->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//FUNÇÃO PARA CADASTRAR PESSOAS
	public function cadastrarPessoa($nome, $telefone, $email){

		//ANTES DE CADASTRAR VERIFICAR SE O EMAIL JÁ ESTÁ CADASTRADO.
		$res = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
		$res->bindValue(":e", $email);
		$res->execute();
		if($res->rowCount() > 0){ //SE MAIOR QUE ZERO EMAIL JÁ CADASTRADO.
			return false;
		}else{
			$res = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES (:n, :t, :e)");
			$res->bindValue(":n", $nome);
			$res->bindValue(":t", $telefone);
			$res->bindValue(":e", $email);
			$res->execute();
			return true;
		}
	}

	//FUNÇÃO PARA EXCLUIR CADASTRO.
	public function excluirPessoa($id){
		$res = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
		$res->bindValue(":id", $id);
		$res->execute();
	}

	//FUNÇÃO PARA BUSCA DE DADOS DE UMA PESSOA
	public function buscarDadosPessoa($id){
		
		$resultado = array();

		$res = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
		$res->bindValue(":id", $id);
		$res->execute();
		$resultado = $res->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//FUNÇÃO PARA ATUALIZAR DADOS DE UMA PESSOA
	public function atualizarDados($id, $nome, $telefone, $email){

		$res = $this->pdo->prepare("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id");
		$res->bindValue(":n", $nome);
		$res->bindValue(":t", $telefone);
		$res->bindValue(":e", $email);
		$res->bindValue(":id", $id);
		$res->execute();
	}
}
?>