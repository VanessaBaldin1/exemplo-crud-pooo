<?php
require_once "conecta.php";

function listarProdutos(PDO $conexao):array {
  //$sql = "SELECT * FROM produtos";

  //linha que seria incluida no SELECT abaixo para fazer o exercicio
  //(produtos.preco * produto.quantidade) As total,
  //a chamada na pagina visualizar.php fica =formatarPreco($produto["total"])


  $sql = "SELECT 
            produtos.id, produtos.nome AS produto,
            produtos.preco, produtos.quantidade,
            fabricantes.nome AS fabricante
          FROM produtos INNER JOIN fabricantes
          ON produtos.fabricante_id = fabricantes.id
          ORDER BY produto";

  

  try {
    $consulta = $conexao->prepare($sql);
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);


  } catch (Exception $erro) {
    die("Erro ao carregar produtos: ".$erro->getMessage());
  }

}



function inserirProduto(PDO $conexao, string $nome, float $preco,
        int $quantidade, int $idfabricante, string $descricao):void {
   $sql = "INSERT INTO produtos(nome, preco, quantidade, fabricante_id, descricao) VALUES(:nome,:preco, :quantidade, :id, :descricao)";
        

  try {
    $consulta = $conexao->prepare($sql);
    $consulta->bindValue(":nome", $nome, PDO::PARAM_STR);
    $consulta->bindValue(":preco", $preco, PDO::PARAM_STR);
    $consulta->bindValue(":quantidade", $quantidade, PDO::PARAM_INT);
    $consulta->bindValue(":id", $idfabricante, PDO::PARAM_INT);
    $consulta->bindValue(":descricao", $descricao, PDO::PARAM_STR);


    $consulta->execute();

  } catch (Exception $erro) {
    die("Erro ao inserir: " .$erro->getMessage());
  }


}

function listarUmProduto(PDO $conexao, int $idproduto):array {
  $sql = "SELECT * FROM produtos WHERE id= :id";

  try {
    $consulta = $conexao->prepare($sql);
    $consulta->bindValue(":id", $idproduto, PDO::PARAM_INT);
    $consulta->execute();
    //Usar somente Fetch para chamar um só linha de registro(chamar um vetor), não todos como estava antes fetchAll (chama todos os registros constam na tabela)
    //Usamos o fetch para garantir o retorno de um único array associativo com o resultado
    return $consulta->fetch(PDO::FETCH_ASSOC);
 } catch (Exception $erro) {
   die("Erro ao carregar de um produto: ".$erro->getMessage());
 }
}


// ATUALIZAR UM PRODUTO

function atualizarProduto(PDO $conexao,  string $nome, int $idproduto, float $preco, int $quantidade, string $descricao, int $fabricante_id): void {
  $sql = "UPDATE produtos SET nome = :nome, preco = :preco, quantidade = :quantidade, descricao = :descricao, fabricante_id = :fabricante_id WHERE id = :id";

  try {
    
    $consulta = $conexao->prepare($sql);
    $consulta->bindValue(":nome", $nome, PDO::PARAM_STR_CHAR);
    $consulta->bindValue(":id", $idproduto, PDO::PARAM_INT);
    $consulta->bindValue(":preco", $preco, PDO::PARAM_STR);
    $consulta->bindValue(":quantidade", $quantidade, PDO::PARAM_INT);
    $consulta->bindValue(":descricao", $descricao, PDO::PARAM_STR);
    $consulta->bindValue(":fabricante_id", $fabricante_id, PDO::PARAM_INT);
    $consulta->execute();


  } catch (Exception $erro) {
    die("Erro ao atualizar produto: ".$erro->getMessage());
  }

}

//Excluir produto

function excluirProduto(PDO $conexao, INT $idproduto):void {
  $sql ="DELETE FROM produtos WHERE id = :id";

  try {
    $consulta = $conexao->prepare($sql);
    $consulta->bindValue(":id", $idproduto, PDO::PARAM_INT);
    $consulta->execute();

    
  } catch (Exception $erro) {
    die("Erro ao detalar um produto: ".$erro->getMessage());
  }

}