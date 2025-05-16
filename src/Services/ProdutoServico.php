<?php

namespace ExemploCrud\Services;

use Exception;
use ExemploCrud\Database\ConexaoBD;
use ExemploCrud\Models\Produto;
use PDO;
use Throwable;

final class ProdutoServico
{
  private PDO $conexao;

  public function __construct()
  {
    $this->conexao = ConexaoBD::getConexao(); //acessando um recurso da classe não é herança
  }

  public function listarTodos(): array
  {
    
  $sql = "SELECT 
            produtos.id, produtos.nome AS produto,
            produtos.preco, produtos.quantidade,
            fabricantes.nome AS fabricante
          FROM produtos INNER JOIN fabricantes
          ON produtos.fabricante_id = fabricantes.id
          ORDER BY produto";

    try {
      /* Preparando o comando SQL ANTES de executar no servidor e guardando em memória (variável consulta ou query) */
      $consulta = $this->conexao->prepare($sql);

      /* Executando o comando no banco de dados*/

      $consulta->execute();

      /* "fetch All", Busca/Retorna todos os dados provenientes da execução da consulta e os transforma em um array associativo */
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $erro) {
      throw new Exception("Erro ao carregar produtos: " . $erro->getMessage());
    }
  }
  

  public function inserir(Produto $produto): void
  {
     $sql = "INSERT INTO produtos(nome, preco, quantidade, fabricante_id, descricao) VALUES(:nome,:preco, :quantidade, :fabricante_id, :descricao)";
        


    try {
    $consulta = $this->conexao->prepare($sql);
    $consulta->bindValue(":nome", $produto->getNome(), PDO::PARAM_STR);
    $consulta->bindValue(":preco", $produto->getPreco(), PDO::PARAM_STR);
    $consulta->bindValue(":quantidade", $produto->getQuantidade(), PDO::PARAM_INT);
    $consulta->bindValue(":fabricante_id", $produto->getFabricanteId(), PDO::PARAM_INT);
    $consulta->bindValue(":descricao", $produto->getDescricao(), PDO::PARAM_STR);


    $consulta->execute();

  } catch (Throwable $erro) {
    throw new Exception("Erro ao inserir: " .$erro->getMessage());
  }
  }


  public function buscarPorId(int $id): ?array
  {
    $sql = "SELECT * FROM produtos WHERE id= :id";

    try {
      $consulta = $this->conexao->prepare($sql);
      $consulta->bindValue(":id", $id, PDO::PARAM_INT);
      $consulta->execute();
      //Usar somente Fetch para chamar um só linha de registro, não todos como estava antes fetchAll (chama todos os registros constam na tabela)
      //Usamos o fetch para garantir o retorno de um único array associativo com o resultado

      //Duas formas - refatora return
      // 1 Gruardamos o resultado da operação fetch em uma variável
      // 1 $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

      // 1 Se o resultado for verdadeiro, retornamos ele. Senão, retornamos null
      // 1 return $resultado ? $resultado : null;

      // 2Versão usando ternário simplificado usando 'elvis operator'
      return $consulta->fetch(PDO::FETCH_ASSOC) ?: null;
    } catch (Throwable $erro) {
      throw new Exception("Erro ao carregar fabricante: " . $erro->getMessage());
    }
  }






  public function atualizar(Produto $produto): void
  {

    $sql = "UPDATE produtos SET nome = :nome, preco = :preco, quantidade = :quantidade, descricao = :descricao, fabricante_id = :fabricante_id WHERE id = :id";

    try {

      $consulta = $this->conexao->prepare($sql);
      $consulta->bindValue(":nome", $produto->getNome(), PDO::PARAM_STR);
      $consulta->bindValue(":preco", $produto->getPreco(), PDO::PARAM_STR);
      $consulta->bindValue(":quantidade", $produto->getQuantidade(), PDO::PARAM_STR);
      $consulta->bindValue(":descricao", $produto->getDescricao(), PDO::PARAM_STR);
      $consulta->bindValue(":fabricante_id", $produto->getFabricanteId(), PDO::PARAM_INT );
      $consulta->bindValue(":id", $produto->getId(), PDO::PARAM_INT);
      $consulta->execute();
    } catch (Throwable $erro) {
      throw new Exception("Erro ao carregar fabricante: " . $erro->getMessage());
    }
  }
  
   public function excluir(int $id): void
    {
      $sql = "DELETE FROM produtos WHERE id = :id";

      try {
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":id", $id, PDO::PARAM_INT);
        $consulta->execute();
      } catch (Throwable $erro) {
        throw new Exception("Erro ao carregar fabricante: " . $erro->getMessage());
      }
    }


}
