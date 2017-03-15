![alt tag](https://raw.githubusercontent.com/Plataformas-Cidadania/mapaosc/master/artefacts/design_grafico/Logotipo/PNG/Logotipo_portal.png)

API Portal OSC
=========
API de dados do Portal das Organizações da Sociedade Civil

Dependências
------------

### Desenvolvimento
- PHP >= 7.0
- Lumen >= 5.3
- Composer >= 1.0.0
- Postgres >= 9.4
- PostGIS >= 2.1
- Redis >= 3.2.6

### Produção
- Apache HTTP Server >= 2.0.0
- PHP >= 7.0
- Postgres >= 9.4
- PostGIS >= 2.1
- Redis >= 3.2.6

Instalação das Ferramentas
--------------------------

#### Apache HTTP Server

```sh
sudo apt-get install apache2
```

#### PHP 7.0

```sh
sudo apt-get install python-software- properties
sudo add-apt- repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install php7.0
```

#### PostgreSQL 9.6

```sh
sudo apt-get install postgresql-9.6 postgresql-contrib
```

#### PostGIS 9.1

```sh
sudo apt-get install postgis postgresql-9.3-postgis-2.1
```

Instalação do Sistema
---------------------

### Restauração do Backup do Banco de Dados

```sh
psql -U usuario banco < arquivo
```

### Instalação de Dependências

```sh
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
```

### Configuração do PHP

Adicionar as seguintes linhas no arquivo /etc/php/7.0/apache2/php.ini:

```
extension=php_mbstring.so
extension=php_openssl.so
extension=php_pdo_pgsql.so
```

### Configuração do Apache

Adicionar ao arquivo /etc/apache2/sites-available/000-default.conf as configurações necessárias para levantar os serviços nas portas desejadas, como no exemplo a seguir:

```
<VirtualHost *:80>
    ServerName projeto.com

    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/projeto/public/index.php

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
