<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sauto Suporte</title>
  <link rel="stylesheet" href="estilos/lista.css">
  <style>
/* header{
  text-align: center;
  background-color: #0056b3;
  border-radius: 8px;
  padding: 5px 20px;
  margin: 5px 0px;
  color: white;
}
.menu-navegacao {
  background-color: #0056b3;
  margin: 10px 0px;
  border-radius: 8px;
}

.menu-navegacao ul {
  list-style: none;
  display: flex;
  justify-content: center;
  margin: 0px;
  padding: 0px;
}

.menu-navegacao li {
  margin: 0px 12px;
}

.menu-navegacao a {
  background-color: #0056b3;
  color: white;
  text-decoration: none;
  font-weight: bold;
  padding: 6px 10px;
  border-radius: 5px;
  transition: background-color 0.3s;
}

.menu-navegacao a:hover {
  background-color:rgb(1, 62, 128);
} */
  </style>
</head>
<body>    
<header>
    <h1 class="pesquisa">Base de Conhecimento - Sauto Suporte</h1>
    <form class="lista" method="GET">
        <input class="campo-pesquisa" type="text" name="query" placeholder="Digite sua pesquisa">
        <button class="btn-consultar" type="submit">Consultar</button>
        <a class="btn-inclur" href="upload.html">Incluir</a>
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