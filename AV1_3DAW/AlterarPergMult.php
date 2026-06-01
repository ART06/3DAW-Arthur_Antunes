<?php
$msg = "";
$id = $perg = $A = $B = $C = $D = $correto = "";

if (isset($_POST['buscar'])) {
    $id_busca = $_POST['id'];
    if (file_exists("PergMult.txt")) {
        $linhas = file("PergMult.txt", FILE_IGNORE_NEW_LINES);
        foreach ($linhas as $linha) {
            $dados = explode(";", $linha);
            if ($dados[0] == $id_busca) {
                $id = $dados[0];
                $perg = $dados[1];
                $msg = "Pergunta encontrada.";
                break;
            }
        }
        if($id == "") { $msg = "ID não encontrado."; }
    }
}

if (isset($_POST['alterar'])) {
    $id = $_POST['id'];
    $novaLinha = $id . ";" . $_POST['perg'] . ";A)" . $_POST['A'] . " | B)" . $_POST['B'] . " | C)" . $_POST['C'] . " | D)" . $_POST['D'] . ";" . $_POST['correto'] . "\n";
    
    $linhas = file("PergMult.txt");
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
        file_put_contents("PergMult.txt", implode("", $linhas));
        $msg = "Pergunta atualizada.";
    } else {
        $msg = "Não foi possível atualizar. ID inexistente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alterar Pergunta Mult</title>
    <script>
        function validarBusca() {
            const id = document.querySelector('input[name="id"]').value.trim();
            if (id == "" || isNaN(id)) {
                alert("Digite um ID numérico válido para realizar a busca!");
                return;
            }
            
            const form = document.getElementById('formAlterarMult');
            const inputBuscar = document.createElement('input');
            inputBuscar.type = 'hidden';
            inputBuscar.name = 'buscar';
            inputBuscar.value = '1';
            form.appendChild(inputBuscar);
            
            form.submit();
        }

        function validarAlteracao() {
            const id = document.querySelector('input[name="id"]').value.trim();
            const perg = document.querySelector('input[name="perg"]').value.trim();
            const a = document.querySelector('input[name="A"]').value.trim();
            const b = document.querySelector('input[name="B"]').value.trim();
            const c = document.querySelector('input[name="C"]').value.trim();
            const d = document.querySelector('input[name="D"]').value.trim();
            const correto = document.querySelector('input[name="correto"]').value.trim().toUpperCase();

            if (id == "" || isNaN(id)) {
                alert("O ID precisa estar preenchido.");
                return;
            }
            if (perg == "" || a == "" || b == "" || c == "" || d == "") {
                alert("Preencha a pergunta e todas as 4 alternativas para alterar.");
                return;
            }
            if (correto != "A" && correto != "B" && correto != "C" && correto != "D") {
                alert("Insira A, B, C ou D no campo \"Correta\".");
                return;
            }

            const form = document.getElementById('formAlterarMult');
            const inputAlterar = document.createElement('input');
            inputAlterar.type = 'hidden';
            inputAlterar.name = 'alterar';
            inputAlterar.value = '1';
            form.appendChild(inputAlterar);

            form.submit();
        }
    </script>
</head>
<body>
    <h1>Alterar Pergunta de Múltipla Escolha</h1>
    <form id="formAlterarMult" method="POST" action="">
        ID da Pergunta para buscar: <input type="text" name="id" value="<?php echo $id; ?>">
        <button type="button" onclick="validarBusca()">Buscar Dados</button>
        <hr>
        Pergunta: <input type="text" name="perg" value="<?php echo $perg; ?>"><br><br>
        A: <input type="text" name="A"><br><br>
        B: <input type="text" name="B"><br><br>
        C: <input type="text" name="C"><br>
        D: <input type="text" name="D"><br><br>
        Correta: <input type="text" name="correto"><br><br>
        <button type="button" onclick="validarAlteracao()">Salvar Alterações</button>
    </form>
    <p><?php echo $msg; ?></p>
    <a href="CadastrarPergMult.php">Voltar</a>
</body>
</html>