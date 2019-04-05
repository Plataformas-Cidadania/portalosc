<?php

namespace App\Email;

use App\Email\Email;

class ContatoEmail extends Email
{
	public function enviar($destinatario, $assunto, $mensagem, $nomeUsuario, $emailUsuario)
	{
		$conteudo = $this->obterConteudo($nomeUsuario, $emailUsuario, $mensagem);
		return $this->enviarEmail($destinatario, $assunto, $conteudo);
	}
	
    public function obterConteudo($nomeUsuario, $emailUsuario, $mensagem)
    {
        return
        '<html>
    	<head>
    	<title>E-mail de Contato</title>
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
    	<h1 style="padding: 0.5em;margin: 0;"><font size="6" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">E-mail de Contato</font></h1>
    	</td>
    	</tr>
    	<tr>
    	<td  colspan="3" bgcolor="#FFFFFF" style="padding:20px;">
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><b>Nome:</b> ' . $nomeUsuario . '</font> </p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><b>Email:</b> ' . $emailUsuario . '</font> </p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><b>Mensagem:</b> ' . $mensagem . '</font> </p>
    	<br/>
    	</td>
    	</tr>
    	<tr>
    	<td width="auto"></td>
    	<td valign="middle" align="right" style="padding:20px;">
    	<img src="https://github.com/Plataformas-Cidadania/mapaosc/blob/master/src/main/webapp/imagens/loading.png?raw=true" height="71" width="71" alt=""/>
    	</td>
    	<td width="420" bgcolor="#FFFFFF" valign="middle" style="padding: 20px 0;">
    	<p style="text-align: justify; margin: 0;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Equipe do Mapa das OSCs</font> </p>
    	<p style="text-align: justify; margin: 0;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">' . $this->capturarData() . '</font> </p>
    	</td>
    	</tr>
    	</tbody>
    	</table>
    	</body>
    	</html>';
    }
}
