<?php
require_once "conecta.php";

/* Lógica/funções para o CRUD de Fabricantes*/

//listarFabricantes: usada pela página fabricantes/visualizar.php

function listarFabricantes(PDO $conexao): array
{
  $sql = "SELECT * FROM fabricantes ORDER BY nome";

  try {
    /* Preparando o comando SQL ANTES de executar no servidor e guardando em memória (variável consulta ou query) */
    $consulta = $conexao->prepare($sql);

    /* Executando o comando no banco de dados*/

    $consulta->execute();

    /* "fetch All", Busca/Retorna todos os dados provenientes da execução da consulta e os transforma em um array associativo */
    return $consulta->fetchAll(PDO::FETCH_ASSOC);

  } catch (Exception $erro) {
     die("Erro: ".$erro-> getMessage());
  }
}

// inserirFabricante: usada pela página fabricante/inserir.php
function inserirFabricante(PDO $conexao, string $nomeDoFabricante):void{ //void indica que não tem retorno da função

  /*: named parameter (parâmetro nomeado) 
  Usamos este recurso do PDO para 'reservar' um espaço seguro em memória para colocação do dado. Nunca passe de forma direta valores para comandos SQL*/  
  $sql = "INSERT INTO fabricantes(nome) VALUES(:nome)";

  try {
    $consulta = $conexao->prepare($sql);

    /* bindValue() -> permite vincular o valor
    do parâmetro à consulta que será executada.É necessário indicar qual é o (:nome), de onde vem o valor ($nomeDoFabricante) e de que tipo ele é (PDO:PARAM_STR)*/ 
    $consulta->bindValue(":nome", $nomeDoFabricante, PDO::PARAM_STR);


    $consulta->execute();
  } catch (Exception $erro) {
    die("Erro ao inserir: " .$erro->getMessage());
  }
}

// listarUmfabricante: usada pela página fabricante/atualizar.php
function listarUmFabricante(PDO $conexao, int $idFabricante): array{
  $sql = "SELECT * FROM fabricantes WHERE id= :id";

  try {
     $consulta = $conexao->prepare($sql);
     $consulta->bindValue(":id", $idFabricante, PDO::PARAM_INT);
     $consulta->execute();
     //Usar somente Fetch para chamar um só linha de registro, não todos como estava antes fetchAll (chama todos os registros constam na tabela)
     //Usamos o fetch para garantir o retorno de um único array associativo com o resultado
     return $consulta->fetch(PDO::FETCH_ASSOC);
  } catch (Exception $erro) {
    die("Erro ao carregar fabricante: ".$erro->getMessage());
  }
}

// Exercício

function atualizarFabricante (PDO $conexao, int $idFabricante, string $nome): void{
    $sql = "UPDATE fabricantes SET nome = :nome WHERE id = :id";

    try {
    
      $consulta = $conexao->prepare($sql);
      $consulta->bindValue(":id", $idFabricante, PDO::PARAM_INT);
      $consulta->bindValue(":nome", $nome, PDO::PARAM_STR);
      $consulta->execute();


    } catch (Exception $erro) {
      die("Erro ao carregar fabricante: ".$erro->getMessage());
    }



}

//excluirFabricante: usada em fabricantes/excluir.php
function excluirFabricante(PDO $conexao, INT $idFabricante):void {
  $sql ="DELETE FROM fabricantes WHERE id = :id";

  try {
    $consulta = $conexao->prepare($sql);
    $consulta->bindValue(":id", $idFabricante, PDO::PARAM_INT);
    $consulta->execute();

    
  } catch (Exception $erro) {
    die("Erro ao carregar fabricante: ".$erro->getMessage());
  }




}