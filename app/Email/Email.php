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
    	
        $remetente  = env('MAIL_FROM');
        $host = env('MAIL_HOST');
        $port = env('MAIL_PORT');
        $username = '';
        $password = '';
        
        //$username = env('MAIL_USERNAME'); // TESTE
        //$password = env('MAIL_PASSWORD'); // TESTE
        
        /*
         * ------------------------------ mailtrap.io ------------------------------
         */
        $destinatario = 'vagnerpraia@gmail.com';
        //$remetente = 'vagnerpraia@gmail.com';
        $host = 'smtp.mailtrap.io';
        $port = '2525';
        $username = '24e7aa1b704a27';
        $password = '90ad8dba7c43a1';
        /*
         * -------------------------------------------------------------------------
         */
        
        $remetente_ajustado = $remetente;
        $destinatario_ajustado = $destinatario;
        
        if(strpos($remetente_ajustado, '<') !== false){
            $remetente_ajustado = substr($remetente_ajustado, strpos($remetente_ajustado, '<'));
        }
        
        $remetente_ajustado = str_replace(['<', '>'], '', $remetente_ajustado);
        $destinatario_ajustado = str_replace(['<', '>'], '', $destinatario_ajustado);
        
        $date = date(DateTime::RFC2822);
        $message_id = '<' . time() . '@ipea.gov.br>';
        $received = 'from mapaosc.ipea.gov.br with SMTP ('. $remetente_ajustado . ') id ipea.gov.br for ' . $destinatario_ajustado . '; ' . $date;
        
        $cabecalho = array(
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html; charset=UTF-8',
            'Date' => $date,
            'Message-Id' => $message_id,
            'Received' => $received,
            'From' => $remetente,
            'To' => $destinatario,
            'Subject' => $assunto
        );
        
        //$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => false, 'username' => $username, 'password' => $password));
        $smtp = Mail::factory('smtp', array (
            'host' => $host, 
            'port' => $port, 
            'auth' => true, 
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
