<?php
$msg = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id=$_POST["id"];
    $perg=$_POST["perg"];
    $A=$_POST["A"];
    $B=$_POST["B"];
    $C=$_POST["C"];
    $D=$_POST["D"];
    $correto=$_POST["correto"];

    if(!file_exists("PergMult.txt")){
        $arqMult=fopen("PergMult.txt","w") or die("Erro ao criar arquivo.");
        $cabecalho="ID;Pergunta;Alternativas;Alternativa Correta\n";
        fwrite($arqMult,$cabecalho);
        fclose($arqMult);
    }

    $arqMult=fopen("PergMult.txt","a") or die("Erro ao abrir arquivo.");
    $linha=$id.";".$perg.";A)".$A." | B)".$B." | C)".$C." | D)".$D.";".$correto."\n";

    if(fwrite($arqMult,$linha)){
        $msg="Pergunta de múltipla escolha salva com sucesso.";
    }
    else{
        $msg="Falha ao salvar pergunta.";
    }
    fclose($arqMult);
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Pergunta Múltipla Escolha</title>
    <script>
        function validarCadastroMult() {
            const id = document.querySelector('input[name="id"]').value.trim();
            const perg = document.querySelector('input[name="perg"]').value.trim();
            const a = document.querySelector('input[name="A"]').value.trim();
            const b = document.querySelector('input[name="B"]').value.trim();
            const c = document.querySelector('input[name="C"]').value.trim();
            const d = document.querySelector('input[name="D"]').value.trim();
            const correto = document.querySelector('input[name="correto"]').value.trim().toUpperCase();

            if (id == "" || isNaN(id)) {
                alert("O ID é obrigatório e deve conter apenas números.");
                return;
            }
            if (perg == "" || a == "" || b == "" || c == "" || d == "") {
                alert("A pergunta e todas as 4 alternativas devem ser preenchidas.");
                return;
            }
            if (correto != "A" && correto != "B" && correto != "C" && correto != "D") {
                alert("A alternativa correta deve ser estritamente A, B, C ou D.");
                return;
            }

            document.getElementById('formCadMult').submit();
        }
    </script>
</head>
<body>
    <h1>Cadastrar Pergunta de Múltipla Escolha</h1>
    <form id="formCadMult" action="" method="POST">
        Insira ID da pergunta: <input type="text" name="id"><br><br>
        Insira a pergunta: <input type="text" name="perg"><br><br>
        Alternativa A: <input type="text" name="A"><br><br>
        Alternativa B: <input type="text" name="B"><br><br>
        Alternativa C: <input type="text" name="C"><br><br>
        Alternativa D: <input type="text" name="D"><br><br>
        Qual é a alternativa correta? (Insira somente a letra da alternativa)<br>
        <input type="text" name="correto" placeholder="Ex: A"><br><br>
        <button type="button" onclick="validarCadastroMult()">Enviar</button>
    </form>
    <p><?php echo $msg; ?></p>
    <a href="ListarPergResp.php">Ver Todas as Perguntas</a>
    <hr>
    <a href="CadastrarPergTxt.php">Cadastrar Pergunta de Texto</a><br><br>
    <a href="AlterarPergMult.php">Editar Pergunta de Múltipla Escolha</a><br>
    <a href="ExcluirPergMult.php">Excluir Pergunta de Múltipla Escolha</a>
</body>
</html>