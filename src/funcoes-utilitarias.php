<?php

 function formatarPreco(float $valor): string{
   $precoformatado = number_format($valor, 2,",",".");
   return "R$" .$precoformatado;
 }

 



