<?php
$msg = "";
$arqUser = "Usuarios.txt";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id=$_POST["id"];
    $nome=$_POST["nome"];
    $email=$_POST["email"];

    if(!file_exists($arqUser)){
        $arqUser=fopen("Usuarios.txt","w") or die("Erro ao criar arquivo.");
        $cabecalho="ID;Nome;Email\n";
        fwrite($arqUser,$cabecalho);
        fclose($arqUser);
    }

    $arqUser=fopen("Usuarios.txt","a") or die("Erro ao abrir arquivo.");
    $linha=$id.";".$nome.";".$email."\n";

    if(fwrite($arqUser,$linha)){
        $msg="Usuário cadastrado com sucesso.";
    }
    else{
        $msg="Falha ao cadastrar usuário.";
    }
    fclose($arqUser);
}
?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <script>
        function validarUsuario() {
            const id = document.querySelector('input[name="id"]').value.trim();
            const nome = document.querySelector('input[name="nome"]').value.trim();
            const email = document.querySelector('input[name="email"]').value.trim();

            if (id == "" || isNaN(id)) {
                alert("O ID é obrigatório e deve conter apenas números.");
                return;
            }
            if (nome.length < 3) {
                alert("O nome deve ter pelo menos 3 caracteres.");
                return;
            }
            const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regexEmail.test(email)) {
                alert("Insira um e-mail válido.");
                return;
            }

            document.getElementById('formUsuario').submit();
        }
    </script>
</head>
<body>
    <h1>Cadastro de Usuário</h1>
    <form id="formUsuario" action="" method="POST">
        ID: <input type="text" name="id"><br><br>
        Nome: <input type="text" name="nome"><br><br>
        Email: <input type="text" name="email"><br><br>
        <button type="button" onclick="validarUsuario()">Enviar</button>
    </form>
    <p><?php echo $msg; ?></p>
    <a href="Usuarios.txt">Ver Arquivo de Usuários</a>
    <br><br>
    <a href="CadastrarPergMult.php">Iniciar Cadastro de Perguntas</a>
</body>
</html>