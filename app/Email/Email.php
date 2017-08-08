<?php

namespace App\Email;

use Mail;
use PEAR;

class Email
{
    public function enviarEmail($destinatario, $assunto, $conteudo)
    {
        $remetente  = env('MAIL_FROM');
        $host = env('MAIL_HOST');
        $port = env('MAIL_PORT');
        $baseurl = env('BASE_URL');
        $username = '';
        $password = '';
        
        //$username = env('MAIL_USERNAME'); // TESTE
        //$password = env('MAIL_PASSWORD'); // TESTE
        
        $cabecalho = array ('Content-type' => 'text/html; charset=UTF-8', 'From' => $remetente, 'To' => $destinatario, 'Subject' => $assunto);
        
        $smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => false, 'username' => $username, 'password' => $password));
        
        $mail = $smtp->send($destinatario, $cabecalho, $conteudo);
        
        $result = true;
        if(PEAR::isError($mail)){
            //print_r($mail->getMessage());
            $result = false;
        }
        
        return $result;
    }
    
    protected function capturarData()
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $date = utf8_encode(strftime('%d').' de '.ucwords(strftime('%B')).' de '.strftime('%Y'));
        
        return $date;
    }
}
