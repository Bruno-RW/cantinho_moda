<?php

namespace CantinhoModa\Core;

class DB 
{
    /**
     * Variável estática que armazenará a conexão
     * ao banco de dados num ojeto PDO
     *
     * @var \PDO
     */
    private static $db;

    /**
     * Retorna uma instância de conexão ao banco de dados
     * reusa se já houver uma estabelecida
     *
     * @return \PDO
     */
    public static function getInstance() : \PDO
    {
        if ( is_null(self::$db) ) {
            try {
                $options = [
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                ];

                $dsn = sprintf('mysql:dbname=%s;host=%s', DB_SCHEMA, DB_HOST);
                self::$db = new \PDO($dsn, DB_USER, DB_PASSWORD);
            } catch (\PDOException $e) {
                error_log( $e->getMessage() );
                throw new Exception('Falha ao realizar a conexão com o servidor, por favor, tente mais tarde');
            }
        }
        return self::$db;
    }

    /**
     * Método estático que retorna o resultado de uma consulta SQL
     * preparada ou não. Retorna um vetor de dados (PDO::FETCH_ASSOC)
     *
     * @param string $sql Consulta preparada com ou sem parâmetros
     * @param array $params Parâmetros opcionais
     * @return array
     */
    public static function select(string $sql, array $params=[]) : array
    {
        $st = self::query($sql, $params);
        return $st->fetchAll();
    }

    /**
     * Método estático que retorna um Statement
     * de uma execução SQL no banco de dados
     *
     * @param string $sql Comando SQL (insert/update/delete) preparado
     * @param array $params Parâmetros/valores referentes à consulta
     * @return \PDOStatement
     */
    public static function query(string $sql, array $params=[]) : \PDOStatement
    {
        try {
            $st = self::getInstance()->prepare($sql);
            if (!$st) {
                error_log("Erro ao preparar a consulta:\n{$sql}");
                throw new Exception('Falha ao preparar comando SQL');
            }

            $params = array_values($params);
            if ( !$st->execute($params) ) {
                error_log( "Erro ao executar comando SQL:\n{$sql}\nParâmetros:\n" . var_export($params, true) );
                throw new Exception('Falha ao executar comando SQL');
            }
            return $st;
        } catch (\PDOException $e) {
            $msgErroLog = sprintf("ERRO PDO: %s, na LINHA: %s\n%s\nParâmetros:\n%s",
                $e->getMessage(),
                $e->getLine(),
                $sql,
                var_export($params, true) 
            );
            error_log($msgErroLog);
            throw new Exception('Falha ao executar comando no banco de dados');
        }
    }
}