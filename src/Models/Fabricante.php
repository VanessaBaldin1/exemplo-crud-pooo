<?php 
namespace ExemploCrud;

final class Fabricante{
  private ?int  $id; //null | int
  private string $nome;

  public function __construct(string $nome, ?int $id = null)  //todos os valores opcionais pro final "?int $id"
  {
     $this-> setNome($nome);
     $this-> setId($id);
     $this-> validar();
    
  }

}