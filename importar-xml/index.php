<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Upload de XMLs</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Upload de XMLs de Nota Fiscal teste</h1>
  <?php include '../includes/templates/menu_navegacao.php' ?>

  <form action="processa.php" method="POST" enctype="multipart/form-data" target="output">
    <input type="file" name="xmls[]" multiple required accept=".xml">
    <button type="submit">Processar XMLs</button>
  </form>

  <div class="output-container">
    <button class="copy-btn" onclick="copiar()">Copiar tudo</button>
    <iframe name="output" style="width: 100%; height: 600px; border: none;"></iframe>
  </div>

  <script>
    function copiar() {
      const iframe = document.querySelector('iframe');
      const pre = iframe.contentDocument.querySelector('pre');
      if (pre) {
        const texto = pre.innerText;
        navigator.clipboard.writeText(texto).then(() => {
          alert('Comandos copiados para a área de transferência!');
        });
      } else {
        alert('Nada para copiar!');
      }
    }
  </script>

</body>
</html>