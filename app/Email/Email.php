<?php

namespace App\Email;

use Mail;
use PEAR;
use Datetime;

class Email
{
	protected function enviarEmail($destinatario, $assunto, $conteudo)
	{
		$resultado = true;
		
		$from = env('MAIL_FROM');
		$host = env('MAIL_HOST');
		$port = env('MAIL_PORT');
		$username = env('MAIL_USERNAME');
		$password = env('MAIL_PASSWORD');
		$auth = false;
		
		$mime_version = '1.0';
		$content_type = 'text/html; charset=UTF-8';
		$date = date(DateTime::RFC2822);
		$message_id = '<' . time() . '@ipea.gov.br>';
		$received = 'from mapaosc.ipea.gov.br with SMTP ('. $from . ') id ipea.gov.br for ' . $destinatario . '; ' . $date;
		
		$cabecalho = array(
				'MIME-Version' => $mime_version,
				'Content-type' => $content_type,
				'Date' => $date,
				'Message-Id' => $message_id,
				'Received' => $received,
				'From' => $from,
				'To' => $destinatario,
				'Subject' => $assunto
		);
		
		$smtp = Mail::factory('smtp', array(
				'host' => $host,
				'port' => $port,
				'auth' => $auth,
				'username' => $username,
				'password' => $password
		));
		
		$mail = $smtp->send($destinatario, $cabecalho, $conteudo);
		if(PEAR::isError($mail)){
			$resultado = false;
		}
		
		return $resultado;
	}
	
	protected function capturarData()
	{
		setlocale(LC_ALL, "pt_BR.utf8", "pt_br", "pt_BR", "ptb", "ptb_ptb", "brazilian", "brazil", "portuguese");
		date_default_timezone_set('America/Sao_Paulo');
		
		$mounth = intval(strftime('%m'));
		if($mounth == 1) $mounth = 'Janeiro';
		else if($mounth == 2) $mounth = 'Fevereiro';
		else if($mounth == 3) $mounth = 'Março';
		else if($mounth == 4) $mounth = 'Abril';
		else if($mounth == 5) $mounth = 'Maio';
		else if($mounth == 6) $mounth = 'Junho';
		else if($mounth == 7) $mounth = 'Julho';
		else if($mounth == 8) $mounth = 'Agosto';
		else if($mounth == 9) $mounth = 'Setembro';
		else if($mounth == 10) $mounth = 'Outubro';
		else if($mounth == 11) $mounth = 'Novembro';
		else if($mounth == 12) $mounth = 'Dezembro';
		
		$date = strftime('%d') . ' de ' . $mounth . ' de '. strftime('%Y');
		
		return $date;
	}
}