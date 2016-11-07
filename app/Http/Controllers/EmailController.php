<?php

namespace App\Http\Controllers;

use Mail;
use PEAR;

class EmailController extends Controller {

    public function send($email, $text_subject, $message)
    {
    	$host = env('MAIL_HOST');
		$port = env('MAIL_PORT');
		$from = env('MAIL_FROM');
		$username = '';
		$password = '';
// 		$username = env('MAIL_USERNAME'); // TESTE
// 		$password = env('MAIL_PASSWORD'); // TESTE

		$to = $email;
		$subject = $text_subject ;
		$body = $message;

		$headers = array ('Content-type' => 'text/html; charset=UTF-8', 'From' => $from, 'To' => $to, 'Subject' => $subject);

		$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => false, 'username' => $username, 'password' => $password));
// 		$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => false, 'username' => $username, 'password' => $password)); // TESTE

		$mail = $smtp->send($to, $headers, $body);

		if (PEAR::isError($mail)) {
			echo("<p>" . $mail->getMessage() . "</p>");
		} else {
			echo("<p>Email enviado com sucesso!</p>");
		}
    }

    public function date()
    {
    	setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
    	$date = utf8_encode(strftime('%d').' de '.ucwords(strftime('%B')).' de '.strftime('%Y'));

    	return $date;
    }

    public function welcome($name)
    {
    	return
    	'<html>
		<head>
		<title>E-mail Boas Vindas</title>
		</head>
		<body bgcolor="#FFFFFF" style="margin: 0 auto; font-size: 16px;">
		<table id="Table_01" border="0" align="center" cellpadding="0" cellspacing="0" style="border: 2px solid #f4f4f4; min-width:300px; width:100%; max-width:700px; margin:20px auto;">
		<tbody>
		<tr>
		<td colspan="3" style="padding:20px;">
		<img src="https://github.com/Plataformas-Cidadania/mapaosc/blob/master/src/main/webapp/imagens/logo.png?raw=true" height="97" alt=""/>
		</td>
		</tr>
		<tr>
		<td height="27" colspan="3" bgcolor="#F4F4F4" style="padding:10px 20px;">
		<h1 style="padding: 0.5em;margin: 0;"><font size="6" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Obrigado por se cadastrar!</font></h1>
		</td>
		</tr>
		<tr>
		<td  colspan="3" bgcolor="#FFFFFF" style="padding:20px;">
		<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Olá, '.$name.'!</font> </p>
		<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Obrigado por se cadastrar no Mapa das Organizações da Sociedade Civil.</font> </p>
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
		<p style="text-align: justify; margin: 0;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><a href="https://mapaosc.ipea.gov.br">Mapa das OSCs</a> - '.$this->date().'.</font> </p>
		</td>
		</tr>
		</tbody>
		</table>
		</body>
		</html>';
    }

    public function confirmation($name, $token)
    {
    	return
    	'<html>
    	<head>
    	<title>E-mail Confirmacao Cadastro</title>
    	</head>
    	<body bgcolor="#FFFFFF" style="margin: 0 auto; font-size: 16px;">
    	<table id="Table_01" border="0" align="center" cellpadding="0" cellspacing="0" style="border: 2px solid #f4f4f4; min-width:300px; width:100%; max-width:700px; margin:20px auto;">
    	<tbody>
    	<tr>
    	<td colspan="3" style="padding:20px;">
    	<img src="https://github.com/Plataformas-Cidadania/mapaosc/blob/master/src/main/webapp/imagens/logo.png?raw=true" height="97" alt=""/>
    	</td>
    	</tr>
    	<tr>
    	<td height="27" colspan="3" bgcolor="#F4F4F4" style="padding:10px 20px;">
    	<h1 style="padding: 0.5em;margin: 0;"><font size="6" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Confirmação de Cadastro</font></h1>
    	</td>
    	</tr>
    	<tr>
    	<td  colspan="3" bgcolor="#FFFFFF" style="padding:20px;">
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Olá, '.$name.'!</font> </p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Estamos prontos para ativar sua conta. Clique no link abaixo para ativar seu cadastro.</font> </p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><a href="https://mapaosc.ipea.gov.br/Map.html#T'.$token.'">https://mapaosc.ipea.gov.br/Map.html#T'.$token.'</a> </font> </p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Se você não criou uma conta do Mapa das OSC, desconsidere este email.</font> </p>
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
    	<p style="text-align: justify; margin: 0;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><a href="https://mapaosc.ipea.gov.br">Mapa das OSCs</a> - '.$this->date().'.</font> </p>
    	</td>
    	</tr>
    	</tbody>
    	</table>
    	</body>
    	</html>';
    }

    public function changePassword($name, $token)
    {
    	return
    	'<html>
    	<head>
    	<title>Criar Nova Senha</title>
    	</head>
    	<body bgcolor="#FFFFFF" style="margin: 0 auto; font-size: 16px;">
    	<table id="Table_01" border="0" align="center" cellpadding="0" cellspacing="0" style="border: 2px solid #f4f4f4; min-width:300px; width:100%; max-width:700px; margin:20px auto;">
    	<tbody>
    	<tr>
    	<td colspan="3" style="padding:20px;">
    	<img src="https://github.com/Plataformas-Cidadania/mapaosc/blob/master/src/main/webapp/imagens/logo.png?raw=true" height="97" alt=""/>
    	</td>
    	</tr>
    	<tr>
    	<td height="27" colspan="3" bgcolor="#F4F4F4" style="padding:10px 20px;">
    	<h1 style="padding: 0.5em;margin: 0;"><font size="6" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Criar Nova Senha</font></h1>
    	</td>
    	</tr>
    	<tr>
    	<td  colspan="3" bgcolor="#FFFFFF" style="padding:20px;">
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Olá, '.$name.'!</font> </p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Para cadastrar sua nova senha, clique no link* abaixo:</font> </p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><a href="https://mapaosc.ipea.gov.br/Map.html#C'.$token.'">https://mapaosc.ipea.gov.br/Map.html#C'.$token.'</a></font> </p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Se você não solicitou alteração de senha, desconsidere esta mensagem e continue utilizando a senha atual.</font> </p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="2" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">*Este link expira em 24 horas.</font> </p>
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
    	<p style="text-align: justify; margin: 0;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><a href="https://mapaosc.ipea.gov.br">Mapa das OSCs</a> - '.$this->date().'.</font> </p>
    	</td>
    	</tr>
    	</tbody>
    	</table>
    	</body>
    	</html>';
    }

    public function informationOSC($user, $nameOSC)
    {
    	$name = $user->nome;
    	$email = $user->email;
    	$cpf = $user->cpf;

    	return
    	'<html>
    	<head>
    	<title>E-mail Informativo a OSC</title>
    	</head>
    	<body bgcolor="#FFFFFF" style="margin: 0 auto; font-size: 16px;">
    	<table id="Table_01" border="0" align="center" cellpadding="0" cellspacing="0" style="border: 2px solid #f4f4f4; min-width:300px; width:100%; max-width:700px; margin:20px auto;">
    	<tbody>
    	<tr>
    	<td colspan="3" style="padding:20px;">
    	<img src="https://github.com/Plataformas-Cidadania/mapaosc/blob/master/src/main/webapp/imagens/logo.png?raw=true" height="97" alt=""/>
    	</td>
    	</tr>
    	<tr>
    	<td height="27" colspan="3" bgcolor="#F4F4F4" style="padding:10px 20px;">
    	<h1 style="padding: 0.5em;margin: 0;"><font size="6" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">E-mail Informativo a OSC</font></h1>
    	</td>
    	</tr>
    	<tr>
    	<td  colspan="3" bgcolor="#FFFFFF" style="padding:20px;">
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Um representante da  <b> '.$nameOSC.'</b> se cadastrou no Mapa das OSCs. Ele está habilitado a inserir dados na página individual da organização.</font> </p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Abaixo seguem os dados do cadastro. Caso não esteja de acordo que este nome seja o representante da OSC, por favor, nos comunique pelo seguinte e-mail:<b>mapaosc@ipea.gov.br</b>.</font> </p>
    	<br/>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><strong>Dados do Representante:</strong></font></p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Nome: '.$name.' </font></p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">CPF: '.$cpf.' </font></p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">E-mail: '.$email.' </font></p>
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
    	<p style="text-align: justify; margin: 0;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><a href="https://mapaosc.ipea.gov.br">Mapa das OSCs</a> - '.$this->date().'.</font> </p>
    	</td>
    	</tr>
    	</tbody>
    	</table>
    	</body>
    	</html>';
    }

    public function informationIpea($user, $osc)
    {
    	$nameOSC = $osc->nomeOsc;
    	$emailOSC = $osc->emailOsc;
    	$name = $user->nome;
    	$email = $user->email;
    	$cpf = $user->cpf;

    	return
    	'<html>
    	<head>
    	<title>E-mail Informativo ao Ipea</title>
    	</head>
    	<body bgcolor="#FFFFFF" style="margin: 0 auto; font-size: 16px;">
    	<table id="Table_01" border="0" align="center" cellpadding="0" cellspacing="0" style="border: 2px solid #f4f4f4; min-width:300px; width:100%; max-width:700px; margin:20px auto;">
    	<tbody>
    	<tr>
    	<td colspan="3" style="padding:20px;">
    	<img src="https://github.com/Plataformas-Cidadania/mapaosc/blob/master/src/main/webapp/imagens/logo.png?raw=true" height="97" alt=""/>
    	</td>
    	</tr>
    	<tr>
    	<td height="27" colspan="3" bgcolor="#F4F4F4" style="padding:10px 20px;">
    	<h1 style="padding: 0.5em;margin: 0;"><font size="6" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">E-mail Informativo ao Ipea</font></h1>
    	</td>
    	</tr>
    	<tr>
    	<td  colspan="3" bgcolor="#FFFFFF" style="padding:20px;">
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Um representante da  <b> '.$nameOSC.'</b> se cadastrou no Mapa das OSCs.</font> </p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Abaixo seguem os dados do cadastro. Um email com as seguintes informações foi enviado para:<b>'.$emailOSC.'</b>.</font> </p>
    	<br/>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><strong>Dados do Representante:</strong></font></p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Nome: '.$name.' </font></p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">CPF: '.$cpf.' </font></p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">E-mail: '.$email.' </font></p>
    	</td>
    	</tr>
    	<tr>
    	<td width="auto"></td>
    	<td valign="middle" align="right" style="padding:20px;">
    	<img src="https://github.com/Plataformas-Cidadania/mapaosc/blob/master/src/main/webapp/imagens/loading.png?raw=true" height="71" width="71" alt=""/>
    	</td>
    	<td width="420" bgcolor="#FFFFFF" valign="middle" style="padding: 20px 0;">
    	<p style="text-align: justify; margin: 0;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">Equipe do Mapa das OSCs</font> </p>
    	<p style="text-align: justify; margin: 0;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><a href="https://mapaosc.ipea.gov.br">Mapa das OSCs</a> - '.$this->date().'.</font> </p>
    	</td>
    	</tr>
    	</tbody>
    	</table>
    	</body>
    	</html>';
    }

    public function contato($name, $text)
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
    	<img src="https://github.com/Plataformas-Cidadania/mapaosc/blob/master/src/main/webapp/imagens/logo.png?raw=true" height="97" alt=""/>
    	</td>
    	</tr>
    	<tr>
    	<td height="27" colspan="3" bgcolor="#F4F4F4" style="padding:10px 20px;">
    	<h1 style="padding: 0.5em;margin: 0;"><font size="6" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">E-mail de Contato</font></h1>
    	</td>
    	</tr>
    	<tr>
    	<td  colspan="3" bgcolor="#FFFFFF" style="padding:20px;">
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><b>Nome:</b> '.$name.'</font> </p>
    	<p style="text-indent: 2.5em;text-align: justify;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif"><b>Mensagem:</b> '.$text.'</font> </p>
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
    	<p style="text-align: justify; margin: 0;"> <font size="4" face="Roboto, arial narrow, helvetica condensed, helvetica, arial, sans-serif">'.$this->date().'</font> </p>
    	</td>
    	</tr>
    	</tbody>
    	</table>
    	</body>
    	</html>';
    }
}
