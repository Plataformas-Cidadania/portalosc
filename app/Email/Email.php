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
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $date = utf8_encode(strftime('%d').' de '.ucwords(strftime('%B')).' de '.strftime('%Y'));
        
        return $date;
    }
}
