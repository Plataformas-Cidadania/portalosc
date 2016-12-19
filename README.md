# portalosc
Portal das Organizações da Sociedade Civil

### Dependences
PHP 7.0 

Composer

Laravel/Lumen

Postgres & PostGIS

Redis

### Instalação
Após a instalação do PHP 7, PostgreSQL 9.4 e PostGIS 2.1, deve-se proceder com as seguintes instalações e configurações:

1. INSTALAÇÃO DE MÓDULOS DO APACHE

sudo apt-get install libapache2-mod-php7.0
sudo apt-get install php7.0-pgsql
sudo apt-get install php7.0-cli 
sudo apt-get install php7.0-cgi
sudo apt-get install php7.0-curl
sudo apt-get install php7.0-json
sudo apt-get install php7.0-mcrypt
sudo apt-get install php7.0-mbstring
sudo apt-get install curl
sudo apt-get install git

2. CONFIGURAÇÃO DO PHP

Adicionar as seguintes linhas no arquivo /etc/php/7.0/apache2/php.ini:

extension=php_mbstring.so
extension=php_openssl.so
extension=php_pdo_pgsql.so
