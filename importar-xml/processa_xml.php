<?php
// processar_xml.php - Versão para hospedagem: Gera comandos SQL prontos

// Configurações iniciais
error_reporting(E_ALL);
ini_set('max_execution_time', '0');
header("Content-Type: text/html; charset=utf-8");

// Função para limpar textos
function limpar($texto) {
    return str_replace("'", "", trim((string)$texto));
}

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['xmls'])) {
    $sql = "";
    foreach ($_FILES['xmls']['tmp_name'] as $index => $tmpName) {
        $xmlContent = file_get_contents($tmpName);
        $xml = simplexml_load_string($xmlContent);
        if (!$xml) continue;

        foreach ($xml->NFe->infNFe->det as $det) {
            $prod = $det->prod;

            $codigo = limpar($prod->cProd);
            $descricao = limpar($prod->xProd);
            $ncm = limpar($prod->NCM);
            $cfop = limpar($prod->CFOP);
            $unidade = substr(limpar($prod->uCom), 0, 5);
            $valor = number_format((float)$prod->vUnCom, 2, '.', '');

            // UPDATE
            $sql .= "UPDATE PRODUTOS SET DESCRICAO = '$descricao', NCM = '$ncm', CFOP = '$cfop', UNIDADE = '$unidade', VALOR_UNITARIO = $valor WHERE CODIGO = '$codigo';\n";
            // INSERT
            $sql .= "INSERT INTO PRODUTOS (CODIGO, DESCRICAO, NCM, CFOP, UNIDADE, VALOR_UNITARIO)\n";
            $sql .= "VALUES ('$codigo', '$descricao', '$ncm', '$cfop', '$unidade', $valor);\n\n";
        }
    }

    // Mostra resultado
    echo "<h2>Comandos SQL Gerados</h2>";
    echo "<pre class='log'>$sql</pre>"; // Usando <pre> para preservar a formatação dos comandos
    echo "<form method='post' action='baixar_sql.php'>
            <input type='hidden' name='sql' value='".htmlspecialchars($sql, ENT_QUOTES)."' />
            <button type='submit'>📥 Baixar SQL</button>
          </form>";
} else {
    // Formulário
    echo '<form method="POST" enctype="multipart/form-data">
            <h2>Enviar XMLs de Nota Fiscal</h2>
            <input type="file" name="xmls[]" multiple accept=".xml" required />
            <button type="submit">Processar</button>
          </form>';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Processar XMLs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 20px;
        }

        .container {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: auto;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        .log {
            background-color: #111;
            color: #0f0;
            padding: 15px;
            font-family: monospace;
            max-height: 600px;
            overflow-y: scroll;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        pre {
            font-family: monospace;
            color: #0f0; /* Verde para os comandos */
            background-color: #222;
            padding: 15px;
            border-radius: 8px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: #45a049;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="file"] {
            margin: 10px 0;
            padding: 10px;
        }

        .aviso {
            font-weight: bold;
            color: #fc0;
        }

    </style>
</head>
<body>
    <div class="container">
        <!-- Aqui vai o conteúdo dinâmico do PHP -->
    </div>
</body>
</html>
