<?php

namespace App\Models;

use App\Models\Model;
use App\Enums\NomenclaturaAtributoEnum;

class RepresentanteOscModel extends Model
{
	private $email = array(
			'apelidos'		=> NomenclaturaAtributoEnum::EMAIL,
			'obrigatorio'	=> true,
			'tipo'			=> 'email'
	);
	
	private $senha = array(
			'apelidos'		=> NomenclaturaAtributoEnum::SENHA,
			'obrigatorio'	=> true,
			'tipo'			=> 'senha'
	);
	
	private $nome = array(
			'apelidos'		=> NomenclaturaAtributoEnum::NOME_USUARIO,
			'obrigatorio'	=> true,
			'tipo'			=> 'string'
	);
	
	private $cpf = array(
			'apelidos'		=> NomenclaturaAtributoEnum::CPF,
			'obrigatorio'	=> true,
			'tipo'			=> 'cpf'
	);
	
	private $listaEmail = array(
			'apelidos'		=> NomenclaturaAtributoEnum::LISTA_EMAIL,
			'obrigatorio'	=> true,
			'tipo'			=> 'boolean'
	);
	
	private $representacao = array(
			'apelidos'		=> NomenclaturaAtributoEnum::REPRESENTACAO,
			'obrigatorio'	=> true,
			//'tipo'		=> 'arrayInteger'
			'tipo'			=> 'integer'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->setEstrutura($estrutura);
    	$this->setRequisicao($requisicao);
    	$this->prepararModel();
    }
}
