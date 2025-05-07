<?php 
namespace ExemploCrud\Services;

use Exception;
use PDO; // para usar apaga uma palavra do PDO e preenche novamente vai dar o use só selecionar
use Throwable;

use ExemploCrud\Database\ConexaoBD; //precisa se atentar com a pasta que esta o ConexaoBD

final class FabricanteServico{
  
  private PDO $conexao;

  public function __construct()
  {
    $this->conexao = ConexaoBD::getConexao(); //acessando um recurso da classe não é herança
  }

  public function listarTodos():array {
    $sql = "SELECT * FROM fabricantes ORDER BY nome";
    
    try {
      /* Preparando o comando SQL ANTES de executar no servidor e guardando em memória (variável consulta ou query) */
      $consulta = $this->conexao->prepare($sql);
  
      /* Executando o comando no banco de dados*/
  
      $consulta->execute();
  
      /* "fetch All", Busca/Retorna todos os dados provenientes da execução da consulta e os transforma em um array associativo */
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
  
    } catch (Throwable $erro) {
       throw new Exception("Erro ao carregar fabricantes: ".$erro-> getMessage());
    }
  }
  






  }


