<?php

namespace App\Email;

class Email
{
    public function enviarEmail($to, $from, $body)
    {
        $host = env('MAIL_HOST');
        $port = env('MAIL_PORT');
        $from = env('MAIL_FROM');
        $baseurl = env('BASE_URL');
        $username = '';
        $password = '';
        
        //$username = env('MAIL_USERNAME'); // TESTE
        //$password = env('MAIL_PASSWORD'); // TESTE
        
        $headers = array ('Content-type' => 'text/html; charset=UTF-8', 'From' => $from, 'To' => $to, 'Subject' => $subject);
        
        $smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => false, 'username' => $username, 'password' => $password));
        //$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password)); // TESTE
        
        $mail = $smtp->send($to, $headers, $body);
        
        $result = true;
        if(PEAR::isError($mail)){
            //echo("<p>" . $error->getMessage() . "</p>");
            $result = false;
        }
        
        return $result;
    }
    
    public function capturarData()
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $date = utf8_encode(strftime('%d').' de '.ucwords(strftime('%B')).' de '.strftime('%Y'));
        
        return $date;
    }
}
