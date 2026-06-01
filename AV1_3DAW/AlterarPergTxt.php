<?php
$msg = "";
$id = $perg = $correto = "";

if (isset($_POST['buscar'])) {
    $id_busca = $_POST['id'];
    if (file_exists("PergTxt.txt")) {
        $linhas = file("PergTxt.txt", FILE_IGNORE_NEW_LINES);
        foreach ($linhas as $linha) {
            $dados = explode(";", $linha);
            if ($dados[0] == $id_busca) {
                $id = $dados[0];
                $perg = $dados[1];
                $correto = $dados[2];
                break;
            }
        }
        if($id == "") { $msg = "ID não encontrado."; }
    }
}

if (isset($_POST['alterar'])) {
    $id = $_POST['id'];
    $novaLinha = $id . ";" . $_POST['perg'] . ";" . $_POST['correto'] . "\n";
    $linhas = file("PergTxt.txt");
    $achou = false;
    foreach ($linhas as $i => $linha) {
        $dados = explode(";", $linha);
        if ($dados[0] == $id) {
            $linhas[$i] = $novaLinha;
            $achou = true;
            break;
        }
    }
    if($achou){
        file_put_contents("PergTxt.txt", implode("", $linhas));
        $msg = "Pergunta de texto atualizada.";
    } else {
        $msg = "Não foi possível alterar. ID inexistente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alterar Pergunta de Texto</title>
    <script>
        function acaoBuscar() {
            const id = document.querySelector('input[name="id"]').value.trim();
            if (id == "" || isNaN(id)) {
                alert("Insira um ID válido para buscar.");
                return;
            }
            const form = document.getElementById('formAlterarTxt');
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'buscar';
            hidden.value = '1';
            form.appendChild(hidden);
            form.submit();
        }

        function acaoAlterar() {
            const id = document.querySelector('input[name="id"]').value.trim();
            const perg = document.querySelector('input[name="perg"]').value.trim();
            const correto = document.querySelector('input[name="correto"]').value.trim();

            if (id == "" || isNaN(id)) {
                alert("O ID precisa estar preenchido.");
                return;
            }
            if (perg == "" || correto == "") {
                alert("Os campos Pergunta e Resposta precisam estar preenchidos.");
                return;
            }

            const form = document.getElementById('formAlterarTxt');
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'alterar';
            hidden.value = '1';
            form.appendChild(hidden);
            form.submit();
        }
    </script>
</head>
<body>
    <h1>Alterar Pergunta de Texto</h1>
    <form id="formAlterarTxt" method="POST" action="">
        ID: <input type="text" name="id" value="<?php echo $id; ?>">
        <button type="button" onclick="acaoBuscar()">Buscar</button>
        <br><br>
        Pergunta: <input type="text" name="perg" value="<?php echo $perg; ?>"><br><br>
        Resposta modelo: <input type="text" name="correto" value="<?php echo $correto; ?>"><br><br>
        <button type="button" onclick="acaoAlterar()">Alterar</button>
    </form>
    <p><?php echo $msg; ?></p>
    <a href="CadastrarPergTxt.php">Voltar</a>
</body>
</html>