<?php
$msg = "";
if(isset($_POST['id_excluir'])){
    $id = $_POST['id_excluir'];
    $linhas = file("PergTxt.txt");
    $novoArquivo = "";
    $achou = false;

    foreach($linhas as $linha){
        $dados = explode(";", $linha);
        if($dados[0] == $id && $id != "ID"){
            $achou = true;
            continue;
        }
        $novoArquivo .= $linha;
    }

    file_put_contents("PergTxt.txt", $novoArquivo);
    $msg = $achou ? "Excluído com sucesso!" : "ID não encontrado.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Excluir Pergunta Texto</title>
    <script>
        function validarExclusaoTxt() {
            const id = document.querySelector('input[name="id_excluir"]').value.trim();
            if (id == "" || isNaN(id)) {
                alert("Insira um ID numérico válido para realizar a exclusão!");
                return;
            }
            document.getElementById('formExcluirTxt').submit();
        }
    </script>
</head>
<body>
    <h1>Excluir Pergunta de Texto</h1>
    <form id="formExcluirTxt" method="POST" action="">
        Digite o ID para excluir: <input type="text" name="id_excluir">
        <button type="button" onclick="validarExclusaoTxt()">Excluir</button>
    </form>
    <p><?php echo $msg; ?></p>
    <a href="CadastrarPergTxt.php">Voltar</a>
</body>
</html>