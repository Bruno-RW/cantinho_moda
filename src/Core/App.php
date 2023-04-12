<?php

namespace CantinhoModa\Core;

use Bramus\Router\Router;
use CantinhoModa\Controller\ErrorController;

class App
{
    /**
     * Variável estática que conterá o objeto Router
     * responsável pelo tratamento das rotas
     *
     * @var Router
     */
    private static $router;

    /**
     * Método que será carregado quando alguma página do site
     * for invocada. Decide qual rota deve ser excecutada
     * a partir da URL informada pelo usuário
     *
     * @return void
     */
    public static function start()
    {
        // Carrega uma sessão ou inicia uma nova em caso de novo acesso
        self::carregaSessao();

        // Associa um objeto Bramus\Router à variável $router
        self::$router = new Router();
        
        // Registra as rotas possíveis
        self::registraRotasDoFrontend();
        // self::registraRotasDoBackend();
        // self::registra404Generico();
        
        // Analisa a requisição e escolhe a rota compatível
        self::$router->run();
    }

    /**
     * Registra as rotas possíveis que estarão
     * associadas aos controllers para o FRONTEND
     *
     * @return void
     */
    private static function registraRotasDoFrontend()
    {
        self::$router->get('/','\CantinhoModa\Controller\HomeController@index');

        // self::$router->post('/ajax','\CantinhoModa\Controller\AjaxController@loader');

        // self::$router->get('/busca','\CantinhoModa\Controller\BuscaController@buscar');

        // self::$router->get('/login','\CantinhoModa\Controller\LoginController@login');
        // self::$router->get('/logout','\CantinhoModa\Controller\LoginController@logout');
        // self::$router->post('/login','\CantinhoModa\Controller\LoginController@postLogin');

        // self::$router->get('/cadastro','\CantinhoModa\Controller\CadastroController@cadastro');
        // self::$router->post('/cadastro','\CantinhoModa\Controller\CadastroController@postCadastro');

        // self::$router->get('/fale-conosco','\CantinhoModa\Controller\FaleConoscoController@faleConosco');
        // self::$router->post('/fale-conosco','\CantinhoModa\Controller\FaleConoscoController@postFaleConosco');

        // self::$router->get('/meus-dados','\CantinhoModa\Controller\MeusDadosController@meusDados');
        // self::$router->get('/produtos/{id}','\CantinhoModa\Controller\ProdutoController@listar');
        // self::$router->get('/sobre-nos','\CantinhoModa\Controller\SobreNosController@listar');
        // self::$router->get('/favoritos','\CantinhoModa\Controller\FavoritosController@listar');
    }

    /**
     * Registra as rotas possíveis que estarão
     * associadas aos controllers para o BACKEND
     *
     * @return void
     */
    // private static function registraRotasDoBackend()
    // {
    //     self::$router->before('GET|POST', '/admin/.*', function (){
    //         if ( empty($_SESSION['usuario']) ) {
    //             redireciona('/admin', 'danger', 'Faça seu logon para continuar');
    //         }
    //     });

    //     self::$router->mount('/admin', function() {
    //         self::$router->get ('/','\CantinhoModa\Controller\AdminLoginController@login');
    //         self::$router->post('/','\CantinhoModa\Controller\AdminLoginController@postLogin');

    //         self::$router->get('/dashboard','\CantinhoModa\Controller\AdminDashboardController@index');

    //         self::$router->get('/remover/(\w+)/(\d+)','\CantinhoModa\Controller\AdminRemoveController@acao');

    //         self::$router->get ('/clientes',        '\CantinhoModa\Controller\AdminClienteController@listar');
    //         self::$router->get ('/clientes/{valor}','\CantinhoModa\Controller\AdminClienteController@form');
    //         self::$router->post('/clientes/{valor}','\CantinhoModa\Controller\AdminClienteController@postForm');

    //         self::$router->get ('/usuarios',        '\CantinhoModa\Controller\AdminUsuarioController@listar');
    //         self::$router->get ('/usuarios/{valor}','\CantinhoModa\Controller\AdminUsuarioController@form');
    //         self::$router->post('/usuarios/{valor}','\CantinhoModa\Controller\AdminUsuarioController@postForm');

    //         self::$router->get ('/categorias',        '\CantinhoModa\Controller\AdminCategoriaController@listar');
    //         self::$router->get ('/categorias/{valor}','\CantinhoModa\Controller\AdminCategoriaController@form');
    //         self::$router->post('/categorias/{valor}','\CantinhoModa\Controller\AdminCategoriaController@postForm');

    //         self::$router->get ('/marcas',        '\CantinhoModa\Controller\AdminMarcaController@listar');
    //         self::$router->get ('/marcas/{valor}','\CantinhoModa\Controller\AdminMarcaController@form');
    //         self::$router->post('/marcas/{valor}','\CantinhoModa\Controller\AdminMarcaController@postForm');
            
    //         self::$router->get ('/produtos',        '\CantinhoModa\Controller\AdminProdutoController@listar');
    //         self::$router->get ('/produtos/{valor}','\CantinhoModa\Controller\AdminProdutoController@form');
    //         self::$router->post('/produtos/{valor}','\CantinhoModa\Controller\AdminProdutoController@postForm');
           
    //         self::$router->get ('/imagens/(\w+)/(\d+)',      '\CantinhoModa\Controller\AdminImagemController@listar');
    //         self::$router->get ('/imagens/(\w+)/(\d+)/(\w+)','\CantinhoModa\Controller\AdminImagemController@form');
    //         self::$router->post('/imagens/(\w+)/(\d+)/(\w+)','\CantinhoModa\Controller\AdminImagemController@postForm');
    //     });
    // }

    /**
     * Registra rota genérica para erro de URL digitada
     *
     * @return void
     */
    // private static function registra404Generico()
    // {
    //     self::$router->set404(function() {
    //         header('HTTP/1.1 404 Not Found');
    //         $objErro = new ErrorController();
    //         $objErro->erro404();
    //     });
    // }

    /**
     * Função que inicia uma nova versão e, posteriormente,
     * carrega o ID da sessão gravada no dispositivo do usuário
     *
     * @return void
     */
    private static function carregaSessao()
    {
        session_start();
    }
}