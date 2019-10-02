<?php

trait HasLoginTests
{
    public function getLoginCredentials()
    {
        return [
            'tx_email_usuario' => env('TEST_LOGIN'),
            'tx_senha_usuario' => env('TEST_PASSWORD')
        ];
    }
}