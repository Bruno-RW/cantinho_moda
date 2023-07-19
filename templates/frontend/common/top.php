<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <!-- ESTILO DO PROJETO -->
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    <!-- FONT AWESOME ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    
    <!-- SWEET ALERT -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SCRIPT CANCELA A TRANSFORMAÇÃO DE ICONES PARA SVG DO FONT AWESOME -->
    <script>
        FontAwesomeConfig = { autoReplaceSvg: false }
    </script>

    <link rel="icon" href="/assets/img/icones/logos/coroa.ico" type="image/x-icon"/>
</head>
<body>
    <?= $topo??'' ?>