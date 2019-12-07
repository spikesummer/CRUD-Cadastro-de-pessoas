<?php
// ---- CONEXÃO COM BANCO DE DADOS ----
try{
	$pdo = new PDO("mysql:dbname=CRUDPDO; host=localhost", "root", "");
}catch(PDOException $e){
	echo "Erro com banco de dados: ".$e->getMessage();
}catch(Exception $e){
	echo "Erro generico: ".$e->getMessage();
}
//--------------------- INSERT -------------------
//1 - forma: 

//$res = $pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES (:n, :t, :e)");
//$res->bindValue(":n", "Carla");
//$res->bindValue(":t", "33539576");
//$res->bindValue(":e", "carla_fagundes@gmail.com");
//$res->execute();


//$res->bindparam(":n", "Adriano"); so aceita o segundo parametro com variavel.

//2 - forma:
//$pdo->query("INSERT INTO pessoa(nome, telefone, email) VALUES ('Adriano', '33533117', 'adriano_costa@gmail.com')");

//-------------------------- DELETE ---------------------------

//$res = $pdo->prepare("DELETE FROM pessoa WHERE id = :id");
//$id = 2;
//$res->bindValue(":id", $id);
//$res->execute();

//ou
//$res = $pdo->query("DELETE FROM pessoa WHERE id = '3'");

//-------------------------- UPDATE ---------------------------

//$res = $pdo->prepare("UPDATE pessoa SET nome = :n WHERE id = :id");
//$res->bindValue(":n", "Carla Fagundes");
//$res->bindValue(":id", 4);
//$res->execute();

//ou
//$res = $pdo->query("UPDATE pessoa SET nome = 'Alexandre' WHERE id = '2'");
//--------------------------------------------------------------

//-------------------------- SELECT ---------------------------

$res = $pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
$res->bindValue(":id", 4);
$res->execute();
$resultado = $res->fetch(PDO::FETCH_ASSOC);

foreach ($resultado as $key => $value) {
	echo $key.": ".$value."<br>";
}
//echo "<pre>";
//print_r($resultado);
//echo "</pre>";
//ou
//$res->fetchAll(); tras todos os dados em form de array
?>