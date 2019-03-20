<?php

namespace App\Email;

use App\Email\Email;

class AtivacaoRepresentanteGovernoEmail extends Email{
	public function enviar($destinatario, $assunto, $nome, $cpf, $email, $telefone1, $telefone2, $orgao, $dadoInstitucional, $tipoLocalidade, $localidade, $token){
		$conteudo = $this->obterConteudo($nome, $cpf, $email, $telefone1, $telefone2, $orgao, $dadoInstitucional, $tipoLocalidade, $localidade, $token);
		return $this->enviarEmail($destinatario, $assunto, $conteudo);
	}
	
    public function obterConteudo($nome, $cpf, $email, $telefone1, $telefone2, $orgao, $dadoInstitucional, $tipoLocalidade, $localidade, $token){
        $baseurl = env('BASE_URL');
        
        return
        '<html>
    	<head>
    	<title>E-mail Confirmação de Cadastro de Representante de Estado ou Município</title>
    	</head>
    	<body bgcolor="#FFFFFF" style="margin: 0 auto; font-size: 16px;">
    	<table id="Table_01" border="0" align="center" cellpadding="0" cellspacing="0" style="border: 2px solid #f4f4f4; min-width:300px; width:100%; max-width:700px; margin:20px auto;">
    	<tbody>
    	<tr>
    	<td colspan="3" style="padding:20px;">
    	<img src="https://github.com/Plataformas-Cidadania/mapa-osc-client/blob/master/img/logo.png?raw=true" height="97" alt=""/>
    	</td>
    	</tr>
    	<tr>
    	<td height="27" colspan="3" bgcolor="#F4F4F4" style="padding:10px 20px;">
    	<h1 style="padding: 0.5em;margin: 0;"><font size="6" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Confirmação de Cadastro</font></h1>
    	</td>
    	</tr>
    	<tr>
    	<td  colspan="3" bgcolor="#FFFFFF" style="padding:20px;">
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Clique no link abaixo para ativar o cadastro de ' . $nome . ' como representante de governo do ' . $tipoLocalidade . ' de ' . $localidade . '.</font> </p>
		<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><a href="' . $baseurl . '/solicitacaovalidacao.html?token=' . $token . '">' . $baseurl . '/validacao.html?token=' . $token . '</a> </font> </p>
		<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Abaixo seguem os dados do cadastro.</font> </p>
		<br/>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><strong>Dados do representante de governo:</strong></font></p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Nome: ' . $nome . ' </font></p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">CPF: ' . $cpf . ' </font></p>
		<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Telefone 1: ' . $telefone1 . ' </font></p>
		<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Telefone 2: ' . $telefone2 . ' </font></p>
		<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Órgão: ' . $orgao . ' </font></p>
		<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Dado institucional: ' . $dadoInstitucional . ' </font></p>
    	</td>
    	</tr>
    	<tr>
    	<td width="auto"></td>
    	<td valign="middle" align="right" style="padding:20px;">
    	<img src="https://github.com/Plataformas-Cidadania/mapaosc/blob/master/src/main/webapp/imagens/loading.png?raw=true" height="71" width="71" alt=""/>
    	</td>
    	<td width="420" bgcolor="#FFFFFF" valign="middle" style="padding: 20px 0;">
    	<p style="text-align: justify; margin: 0;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Agradecemos pelo contato,</font> </p>
    	<p style="text-align: justify; margin: 0;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Equipe do Mapa das OSCs</font> </p>
    	<p style="text-align: justify; margin: 0;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><a href="https://mapaosc.ipea.gov.br">Mapa das OSCs</a> - ' . $this->capturarData() . '.</font> </p>
    	</td>
    	</tr>
    	</tbody>
    	</table>
    	</body>
    	</html>';
    }
}