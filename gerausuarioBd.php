<?php 
$cont = 2;
//copiar e colar o resuldado dentro da Query no BD para gerar usuarios e testar paginacao 
while($cont < 1000){
	echo "INSERT INTO usuarios (nome, email, usuario, senha) VALUES
	('Jose$cont', 'jose$cont@teste.com','jose$cont','jo12$cont'),
	('Jessica$cont', 'jessica$cont@teste.com','jessia$cont','je12$cont' ),
	('Amanda$cont', 'amanda$cont@teste.com.br','amanda$cont','am12$cont'); <br>";

	$cont = $cont + 1;
}