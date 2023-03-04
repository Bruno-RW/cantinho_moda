<?php

/**
 * DEFINIÇÕES GLOBAIS DO PROJETO
 */
define('FRONTEND_TITLE', 'Cantinho da Moda');
define('BACKEND_TITLE', 'Cantinho da Moda');
define('TIMEZONE', 'America/Sao_Paulo');
define('DISPLAY_ERRORS', 1);
define('PATH_PROJETO', __DIR__ . '/../');
define('SALT_SENHA', '123ABC');

/**
 * DEFINIÇÕES DE PATH DE ARQUIVOS
 */
define('URL', 'http://localhost');
define('TEMPLATES', PATH_PROJETO . 'templates/');
define('TBACKEND',  TEMPLATES .    'backend/');
define('TFRONTEND', TEMPLATES .    'frontend/');

/**
 * DEFINIÇÕES DO BANCO DE DADOS
 */
define('DB_HOST',     'localhost');
define('DB_SCHEMA',   'cantinho_moda');
define('DB_USER',     'root');
define('DB_PASSWORD', '');

/**
 * DEFINIÇÕES DE ENVIO DE E-MAIL
 */
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);

define('MAIL_NAME', 'Bicho Novo Pet Shop');
define('MAIL_USER', 'bw004862@cfjl.com.br');
define('MAIL_PASS', '');

define('MAIL_CONTACTNAME', 'Atendente Bruno');
define('MAIL_CONTACTMAIL', 'bruno_wunsch@hotmail.com');