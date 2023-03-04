<?php
/* ############# PROCESSANDO AS COLUNAS/TÍTULOS DA TABELA ############# */

// Pega as propriedades dos campos do objeto e converte os nomes para minúsculo
$colunasObjeto = array_change_key_case($objeto->getFields());

// Monta o cabeçalho da tabela a partir das informações o objeto
$htmlColunas = '';
foreach ($colunas as $coluna) {
    $infoColuna = $colunasObjeto[$coluna['campo']];

    $class = $coluna['class'] ?? '';

    $htmlColunas .= <<<HTML
            <th class="{$class}">{$infoColuna['label']}</th>
        HTML;
}
$htmlColunas .= '<th class="text-center align-middle">Opções</th>';

/* ############# PROCESSANDO AS LINHAS DE DADOS ############# */

// Pega o nome do campo chave da tabela atual
$campoChave = $objeto->getPkName();

// Pega a rota atual para fazer o link de edição
$rotaAtual = $_SERVER['REQUEST_URI'];

if ( !isset($rows) ) {
    // Pega todos os registros cadastrados nesta tabela/objeto
    $rows = $objeto->find();
}

// Motando as linhas de dados da tabela
$htmlLinhas = '';
foreach ($rows as $row) {
    $htmlLinhas .= '<tr>';

    foreach ($colunas as $coluna) {
        $class = $coluna['class'] ?? '';
        $valorColuna = $row[$coluna['campo']];

        $htmlLinhas .= "<td class='{$class}'>{$valorColuna}</td>";
    }

    // Criando o botão de editar
    $valorChave = $row[$campoChave];
    $linkEdicao = "{$rotaAtual}/{$valorChave}";

    $btnEditar = <<<HTML
        <a href="{$linkEdicao}" class="text-secondary text-decoration-none px-1" title="Editar Registro">
            <i class="bi bi-pencil-square"></i>
        </a>
    HTML;

    $btnImagem = '';
    if ( !empty($imagens) ) {
        $model = pathinfo($objeto::class, PATHINFO_BASENAME);
        $rotaImagens = "/admin/imagens/{$model}/{$valorChave}";

        $btnImagem = <<<HTML
            <a href="{$rotaImagens}" class="text-primary text-decoration-none px-1" title="Editar Imagens">
                <i class="bi bi-file-image"></i>
            </a>
        HTML;
    }

    $btnExcluir = '';
    if ( !empty($remover) ) {
        $model = pathinfo($objeto::class, PATHINFO_BASENAME);
        $rotaExclusao = "/admin/remover/{$model}/{$valorChave}";

        $btnExcluir = <<<HTML
            <a href="{$rotaExclusao}" class="link-excluir text-danger text-decoration-none px-1" title="Remover registro">
                <i class="bi bi-trash3-fill"></i>
            </a>
        HTML;
    }

    $htmlLinhas .= <<<HTML
            <td class="text-center align-middle">
                {$btnEditar}
                {$btnImagem}
                {$btnExcluir}
            </td>
        </tr>
    HTML;
}
?>
<div class="text-end mb-3">
    <a href="<?=$rotaAtual?>/add" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Novo registro
    </a>
</div>
<div class="table-responsive">
    <table class="table table-striped table-middle">
        <thead>
            <tr>
                <?= $htmlColunas ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?= $htmlLinhas ?>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="text-end" colspan="<?= count($colunas)+1 ?>">
                    Total de registros encontrados: <strong><?= count($rows) ?></strong>
                </td>
            </tr>
        </tfoot>
    </table>
</div>