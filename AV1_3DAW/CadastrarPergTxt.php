<?php
$msg = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id=$_POST["id"];
    $perg=$_POST["perg"];
    $correto=$_POST["correto"];

    if(!file_exists("PergTxt.txt")){
        $arqTxt=fopen("PergTxt.txt","w") or die("Erro ao criar arquivo.");
        $cabecalho="ID;Pergunta;Resposta-Modelo\n";
        fwrite($arqTxt,$cabecalho);
        fclose($arqTxt);
    }

    $arqTxt=fopen("PergTxt.txt","a") or die("Erro ao abrir arquivo.");
    $linha=$id.";".$perg.";".$correto."\n";

    if(fwrite($arqTxt,$linha)){
        $msg="Pergunta de texto salva com sucesso.";
    }
    else{
        $msg="Falha ao salvar pergunta.";
    }
    fclose($arqTxt);
}
?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Pergunta Texto</title>
    <script>
        function validarCadastroTxt() {
            const id = document.querySelector('input[name="id"]').value.trim();
            const perg = document.querySelector('input[name="perg"]').value.trim();
            const correto = document.querySelector('input[name="correto"]').value.trim();

            if (id == "" || isNaN(id)) {
                alert("O ID é obrigatório e precisa ser numérico.");
                return;
            }
            if (perg == "") {
                alert("O campo da pergunta precisa ser preenchido.");
                return;
            }
            if (correto == "") {
                alert("A resposta-modelo é obrigatória.");
                return;
            }

            document.getElementById('formCadTxt').submit();
        }
    </script>
</head>
<body>
    <h1>Cadastrar Pergunta de Texto</h1>
    <form id="formCadTxt" action="" method="POST">
        Insira ID da pergunta: <input type="text" name="id"><br><br>
        Insira a pergunta: <input type="text" name="perg"><br><br>
        Qual é a resposta-modelo?<br><input type="text" name="correto"><br><br>
        <button type="button" onclick="validarCadastroTxt()">Enviar</button>
    </form>
    <p><?php echo $msg; ?></p>
    <a href="ListarPergResp.php">Ver Todas as Perguntas</a>
    <hr>
    <a href="CadastrarPergMult.php">Cadastrar Pergunta de Múltipla Escolha</a><br><br>
    <a href="ExcluirPergTxt.php">Excluir Pergunta de Texto</a><br>
    <a href="AlterarPergTxt.php">Alterar Pergunta de Texto</a>
</body>
</html>