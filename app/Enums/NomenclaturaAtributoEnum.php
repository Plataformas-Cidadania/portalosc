<?php

namespace App\Enums;

use App\Enums\Enum;

abstract class NomenclaturaAtributoEnum extends Enum
{
    const ID_USUARIO = ['idUsuario', 'id_usuario'];
    const LOGIN = ['login', 'tx_login', 'email', 'emailUsuario', 'email_usuario', 'tx_email_usuario', 'localidade', 'cd_localidade'];
    const EMAIL = ['email', 'emailUsuario', 'email_usuario', 'tx_email_usuario'];
    const EMAIL_CONFIRMACAO = ['emailConfirmacao', 'email_confirmacao', 'tx_email_confirmacao'];
    const SENHA = ['senha', 'senhaUsuario', 'senha_usuario', 'tx_senha_usuario'];
    const NOME_USUARIO = ['nome', 'tx_nome_usuario'];
    const CPF = ['cpf', 'nr_cpf_usuario'];
    const ORGAO_USUARIO = ['orgaoUsuario', 'orgao_usuario', 'tx_orgao_usuario'];
    const TELEFONE_USUARIO_1 = ['telefone1', 'tx_telefone_1'];
    const TELEFONE_USUARIO_2 = ['telefone2', 'tx_telefone_2'];
    const DADO_INSTITUCIONAL = ['dadoInstitucional', 'dado_institucional', 'tx_dado_institucional'];
    const LISTA_EMAIL = ['listaEmail', 'lista_email', 'bo_lista_email'];
    const LISTA_ATUALIZACAO_ANUAL = ['listaAtualizacaoAnual', 'lista_atualizacao_anual', 'bo_lista_atualizacao_anual'];
    const LISTA_ATUALIZACAO_TRIMESTRAL = ['listaAtualizacaoTrimestral', 'lista_atualizacao_trimestral', 'bo_lista_atualizacao_trimestral'];
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
    const ID_OSC = ['idOsc', 'id_osc'];
    const ID_REGIAO = ['idRegiao', 'id_regiao'];
    const TIPO_REGIAO = ['tipoRegiao', 'tipo_regiao'];
    const NAO_POSSUI = ['naoPossui', 'nao_possui', 'bo_nao_possui'];
    const CD_FONTE_RECURSOS_OSC = ['cdFonteRecursosOsc', 'cd_fonte_recursos_osc'];
    const ANO_RECURSOS_OSC = ['anoRecursosOsc', 'ano_recursos_osc', 'dt_ano_recursos_osc'];
    const VALOR_RECURSOS_OSC = ['valorRecursosOsc', 'valor_recursos_osc', 'nr_valor_recursos_osc'];
    const LATITUDE = ['latitude', 'nr_latitude'];
    const LONGITUDE = ['longitude', 'nr_longitude'];
    const DICIONARIO = ['dicionario', 'dict'];
}
