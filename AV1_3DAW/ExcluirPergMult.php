<?php
$msg = "";
if(isset($_POST['id_excluir'])){
    $id = $_POST['id_excluir'];
    $linhas = file("PergMult.txt");
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

    file_put_contents("PergMult.txt", $novoArquivo);
    $msg = $achou ? "Excluído com sucesso!" : "ID não encontrado.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Excluir Pergunta Mult</title>
    <script>
        function validarExclusao() {
            const id = document.querySelector('input[name="id_excluir"]').value.trim();
            if (id == "" || isNaN(id)) {
                alert("Insira um ID válido.");
                return;
            }
            document.getElementById('formExcluirMult').submit();
        }
    </script>
</head>
<body>
    <h1>Excluir Pergunta de Múltipla Escolha</h1>
    <form id="formExcluirMult" method="POST" action="">
        Digite o ID para excluir: <input type="text" name="id_excluir">
        <button type="button" onclick="validarExclusao()">Excluir</button>
    </form>
    <p><?php echo $msg; ?></p>
    <a href="CadastrarPergMult.php">Voltar</a>
</body>
</html>