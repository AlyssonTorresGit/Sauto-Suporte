<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sauto Suporte</title>
  <link rel="stylesheet" href="estilos/lista.css">
</head>
<body>    
    <header>
        <h1 class="pesquisa">Base de Conhecimento - Sauto Suporte</h1>
        <form class="lista" method="GET">
            <input class="campo-pesquisa" type="text" name="query" placeholder="Pesquisar Título">
            <button class="btn-consultar" type="submit">Consultar</button>
            <a href="upload.html" class="btn-inclur">Incluir</a>
        </form>
        <nav class="menu-navegacao">
            <ul>
            <li><a href="listar.php">Lista</a></li>
            <li><a href="lista_comandos.php">Comando SQLs</a></li>
            <li><a href="importar_xml.php">Importar XMLs</a></li>
            <li><a href="tutoriais.php">Tutoriais</a></li>
            <li><a href="novidades.php">Novidades</a></li>
            <li><a href="#">sugestoes</a></li>
            </ul>
        </nav>
    </header>