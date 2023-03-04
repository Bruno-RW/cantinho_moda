<?php

date_default_timezone_set(TIMEZONE);

/**
 * CONTROLE DO FLUXO DE LOG
 */
error_reporting(E_ALL); // Que tipo de erro deve ser exibido
ini_set('display_errors', DISPLAY_ERRORS); // O usuário vê os erros?
ini_set('log_erros', 1); // Devo logar os erros?

// Definir o arquivo que armazenará os erros de log
ini_set('error_log', PATH_PROJETO . 'log/error-'.date('Y').'-'.date('m').'txt');