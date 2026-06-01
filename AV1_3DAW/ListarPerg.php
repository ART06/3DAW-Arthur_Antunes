<?php $id_encontrado = false; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Buscar Pergunta</title>
    <script>
        function validarBuscaCega() {
            const id = document.querySelector('input[name="id_busca"]').value.trim();
            if (id == "" || isNaN(id)) {
                alert("Insira um ID válido.");
                return;
            }
            document.getElementById('formBuscarPerg').submit();
        }
    </script>
</head>
<body>
    <h1>Buscar Pergunta por ID</h1>
    <form id="formBuscarPerg" method="GET" action="">
        ID: <input type="text" name="id_busca" value="<?php echo isset($_GET['id_busca']) ? $_GET['id_busca'] : ''; ?>">
        <button type="button" onclick="validarBuscaCega()">Buscar</button>
    </form>

    <?php
    if(isset($_GET['id_busca'])){
        $id = $_GET['id_busca'];
        $arquivos = ["PergMult.txt", "PergTxt.txt"];
        foreach($arquivos as $arq){
            if(file_exists($arq)){
                $linhas = file($arq);
                foreach($linhas as $linha){
                    $dados = explode(";", $linha);
                    if($dados[0] == $id){
                        $id_encontrado = true;
                        echo "<h3>Encontrado no arquivo: $arq</h3>";
                        echo "Detalhes: " . str_replace(";", " | ", $linha);
                    }
                }
            }
        }
        if(!$id_encontrado) {
            echo "<p>Nenhuma pergunta encontrada com o ID " . htmlspecialchars($id) . ".</p>";
        }
    }
    ?>
    <br><br><a href="CadastrarPergMult.php">Voltar</a>
</body>
</html>