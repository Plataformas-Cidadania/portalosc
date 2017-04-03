# API Mapa OSC

API de dados do Mapa das Organizações da Sociedade Civil

![alt tag](https://raw.githubusercontent.com/Plataformas-Cidadania/mapaosc/master/artefacts/design_grafico/Logotipo/PNG/Logotipo_portal.png)

* [Mapa das Organizações da Sociedade Civil](https://www.mapaosc.ipea.gov.br/)
* [Instituto de Pesquisa Econômica Aplicada - Ipea](http://www.ipea.gov.br/)

## Descrição do projeto

O [Mapa das Organizações da Sociedade Civil](https://www.mapaosc.ipea.gov.br/) é um portal de dados desenvolvido pelo [Instituto de Pesquisa Econômica Aplicada - Ipea](http://www.ipea.gov.br/) sobre as organizações da sociedade civil (OSCs) e seus principais objetivos são:
* dar transparência à atuação das OSCs, principalmente ações executadas em parceria com a administração pública;
* informar mais e melhor sobre a importância e diversidade de projetos e atividades conduzidas por essas organizações;
* disponibilizar dados e fomentar pesquisas sobre OSCs;
* apoiar os gestores públicos a tomarem decisões sobre políticas públicas que já têm ou possam ter interface com OSCs.

O portal também é parte do processo de implementação e consolidação da Lei 13.019/2014, conhecida como Marco Regulatório das OSCs, e está previsto no artigo 81 do [Decreto 8.726/2016](http://www.planalto.gov.br/ccivil_03/_ato2015-2018/2016/Decreto/D8726.htm), que regulamenta aquela lei.

Para alcançar seus objetivos, o Portal integra um amplo e crescente volume de bases de dados provenientes de fontes públicas e privadas e é uma plataforma colaborativa, pois pode receber e integrar continuamente informações enviadas pelas OSCs e por entes federados.
As OSCs podem inserir as informações em páginas individuais e manter um perfil completo e atualizado, para a visualização dos interessados.

Os governos poderão aumentar a transparência de suas práticas e, seguindo as orientações deste [arquivo](https://www.mapaosc.ipea.gov.br/pdf/tutorial_para_formatacao_dados.pdf), encaminhar dados sobre as parcerias celebradas com OSCs.
Quanto mais informações forem inseridas, mais transparentes serão as práticas do Estado e das OSCs e mais a sociedade conhecerá as diferentes ações de interesse público.

## Dependências

### Desenvolvimento
* [PHP](http://php.net/) >= 7.0
* [Lumen](https://lumen.laravel.com/) >= 5.3
* [Composer](https://getcomposer.org/) >= 1.0.0
* [Postgres](https://www.postgresql.org/) >= 9.4
* [PostGIS](http://postgis.net/) >= 2.1
* [Redis](https://redis.io/) >= 3.2.6

### Produção
* [Apache HTTP Server](https://httpd.apache.org/) >= 2.0.0
* [PHP](http://php.net/) >= 7.0
* [Postgres](https://www.postgresql.org/) >= 9.4
* [PostGIS](http://postgis.net/) >= 2.1
* [Redis](https://redis.io/) >= 3.2.6

## Instalação das Ferramentas

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

#### PostGIS 2.1

```sh
sudo apt-get install postgis postgresql-9.3-postgis-2.1
```

## Instalação do Sistema

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

Adicionar ao diretório /etc/apache2/sites-available um arquivo .conf, ou adicionar em um arquivo já existente, as configurações necessárias para levantar os serviços nas portas desejadas. É necessário alterar os arquivos de ErrorLog e CustomLog de cada porta configurada, para que cada serviço tenha seus próprios arquivos de log.  No exemplo a seguir mostra a configuração de uma porta:

```
<VirtualHost *:80>
    ServerName projeto.com

    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/projeto/public/index.php

    ErrorLog ${APACHE_LOG_DIR}/error_80.log
    CustomLog ${APACHE_LOG_DIR}/access_80.log combined
</VirtualHost>
```

Para serviços executados com SSL, adicionar ao diretório /etc/apache2/sites-available um arquivo .conf, ou adicionar em um arquivo já existente, as seguintes configurações:

```
<VirtualHost *:443>
    ServerName projeto.com

    DocumentRoot /var/www/projeto/public/index.php

    <Directory "/var/www/projeto/public/index.php">
        Options Indexes FollowSymLinks MultiViews
        AllowOverride None
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error_443_ssl.log
    ServerSignature Off
    CustomLog ${APACHE_LOG_DIR}/access_443_ssl.log combined 

    SSLEngine on
    SSLCertificateFile /etc/ssl/certs/projeto.pem
    SSLCertificateKeyFile /etc/ssl/private/projeto.key
</VirtualHost>
```

Habilitar no arquivo /etc/apache2/ports.conf, configure as portas onde serão executados os serviços configurados acima. A seguir um exemplo desta habilitação:

```
Listen 80
```

Para habilitar portas com SSL, configure da seguinte forma:

```
<IfModule ssl_module>
    Listen 443
</IfModule>
```

## Autores

* André Vieira
* Denise Silva
* Eric Ferreira
* Felix Lopez
* Fernando Ferreira
* Heraldo Borges
* Kleyton Pontes Cotta
* Rafael Lage
* Raphael Moraes
* Raul Sena Ferreira
* Tiago Nascimento
* Vagner Praia

## Licença

Este projeto está licenciado sob a GNU General Public License v3.0 - veja o arquivo [LICENSE](LICENSE) para mais detalhes.
