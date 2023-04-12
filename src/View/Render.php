<?php

namespace CantinhoModa\View;

use Exception;

class Render
{   
    /**
     * Método que carrega uma página com a estrutura
     * do FrontEnd, recebe dois parâmetros:
     *
     * @param string $pagina Nome do arquivo a ser impresso
     * @param array $dados Dados a serem inseridos na página
     * @return void
     */
    static public function front(string $pagina, array $dados = [])
    {
        // Monta o caminho do local onde a página solicitada está
        $pathPagina = TFRONTEND . 'pages/' . $pagina . '.php';

        if ( !file_exists($pathPagina) ) {
            error_log('Página template não localizada em:' . $pathPagina);
            throw new Exception("A página solicitada '{$pagina}'não foi localizada");
        }

        if ( empty($dados['titulo']) ) {
            $dados['titulo'] = FRONTEND_TITLE;
        } else {
            $dados['titulo'] = $dados['titulo'] . ' - ' . FRONTEND_TITLE;
        }

        // Transforma os índices do vetor em variáveis
        extract($dados);
    
        require_once TFRONTEND . 'common/top.php';
        require_once $pathPagina;
        require_once TFRONTEND . 'common/bottom.php';
    }

    /**
     * Método que retorna o conteúdo de um bloco (arquivo.php)
     *
     * @param string $bloco Nome do bloco a ser renderizado e retornado
     * @param array $dados Dados a serem inseridos o bloco
     * @return void
     */
    static public function block(string $bloco, array $dados = [])
    {
        // Monta o caminho do local onde o bloco solicitada está
        $pathArquivo = TEMPLATES . 'blocks/' . $bloco . '.php';

        if ( !file_exists($pathArquivo) ) {
            error_log('Bloco não localizado em:' . $pathArquivo);
            throw new Exception("O bloco solicitado'{$bloco}'não foi localizado");
        }

        // Transforma os índices do vetor em variáveis
        extract($dados);
    
        // Inicia a captura do buffer para não printar ao
        // usuario o conteúdo do arquivo que será requerido
        ob_start();

        // Carrega o conteúdo do arquivo para o buffer (estamos em OB_START)
        require_once $pathArquivo;

        // Retorna o conteúdo em buffer e limpa a memória
        return ob_get_clean();
    }

/**
     * Método que carrega uma página com a estrutura
     * do BackEnd, recebe dois parâmetros:
     *
     * @param string $pagina Nome do arquivo a ser impresso
     * @param array $dados Dados a serem inseridos na página
     * @return void
     */
    static public function back(string $pagina, array $dados = [])
    {
        // Monta o caminho do local onde a página solicitada está
        $pathPagina = TBACKEND . 'pages/' . $pagina . '.php';

        if ( !file_exists($pathPagina) ) {
            error_log('Página template não localizada em:' . $pathPagina);
            throw new Exception("A página solicitada '{$pagina}'não foi localizada");
        }
        
        $dados['nomesite'] = BACKEND_TITLE;

        if ( empty($dados['titulo']) ) {
            $dados['titulo'] = BACKEND_TITLE;
        } else {
            $dados['tituloInterno'] = $dados['titulo'];
            $dados['titulo'] = $dados['titulo'] . ' - ' . BACKEND_TITLE;
        }

        // Transforma os índices do vetor em variáveis
        extract($dados);
    
        require_once TBACKEND . 'common/top.php';
        require_once $pathPagina;
        require_once TBACKEND . 'common/bottom.php';
    }
}