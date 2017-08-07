<?php

namespace App\Email;

use App\Email\Email;

class InformeCadastroRepresentanteGovernoEmail extends Email
{
    public function obterConteudo($nomeUsuario)
    {
        return
        '<html>
		<head>
		<title>E-mail informativo de representante governamentais</title>
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
		<h1 style="padding: 0.5em;margin: 0;"><font size="6" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Obrigado por se cadastrar!</font></h1>
		</td>
		</tr>
		<tr>
		<td  colspan="3" bgcolor="#FFFFFF" style="padding:20px;">
		<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Olá, ' . $nomeUsuario . '!</font> </p>
		<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Obrigado por se cadastrar no Mapa das Organizações da Sociedade Civil. O seu cadastro será avaliado para verificar a validade dos dados informados. Em breve outro e-mail será enviado informando o resultado desta avaliação.</font> </p>
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
