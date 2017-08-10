<?php

namespace App\Enums;

use App\Enums\Enum;

abstract class NomenclaturaAtributoEnum extends Enum
{
    const ID_USUARIO = ['id', 'id_usuario'];
    const EMAIL = ['email', 'emailUsuario', 'email_usuario', 'tx_email_usuario'];
    const SENHA = ['senha', 'senhaUsuario', 'senha_usuario', 'tx_senha_usuario'];
    const NOME_USUARIO = ['nome', 'tx_nome_usuario'];
    const CPF = ['cpf', 'nr_cpf_usuario'];
    const LISTA_EMAIL = ['listaEmail', 'lista_email', 'bo_lista_email'];
    const TIPO_USUARIO = ['tipoUsuario', 'cd_tipo_usuario'];
    const USUARIO_ATIVO = ['ativo', 'bo_ativo'];
    const REPRESENTACAO = ['representacao', 'cd_oscs_representante'];
    const LOCALIDADE = ['localidade', 'cd_localidade'];
    const CODIGO_MUNICIPIO = ['localidade', 'cd_localidade', 'municipio', 'cd_municipio', 'edmu_cd_municipio'];
    const CODIGO_ESTADO = ['localidade', 'cd_localidade', 'uf', 'cd_uf', 'eduf_cd_uf', 'estado', 'cd_estado'];
    const TOKEN = ['token', 'tx_token'];
    const ARQUIVO = ['arquivo', 'fi_arquivo'];
    const TIPO_ARQUIVO = ['tipoArquivo', 'tipo_arquivo', 'tx_tipo_arquivo'];
    const ORGAO = ['orgao', 'tx_orgao'];
    const PROGRAMA = ['programa', 'tx_programa'];
    const AREA_INTERESSE = ['areaInteresse', 'area_interesse', 'tx_area_interesse'];
    const DATA_VENCIMENTO = ['dataVencimento', 'data_vencimento', 'dt_data_vencimento'];
    const LINK = ['link', 'tx_link'];
    const NUMERO_CHAMADA = ['numeroChamada', 'numero_chamada', 'tx_numero_chamada'];
}
