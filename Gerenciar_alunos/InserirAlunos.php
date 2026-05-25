<?php
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST["matricula"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $existeMatricula = false;

    if (!file_exists("alunos.txt")) {
        $arqAlunos = fopen("alunos.txt", "w") or die("Erro ao criar arquivo!");
        $cabecalho = "matricula;nome;email\n";
        fwrite($arqAlunos, $cabecalho);
        fclose($arqAlunos);
    }

    $arqAlunos = fopen("alunos.txt", "r") or die("Erro ao abrir arquivo para leitura!");
    fgets($arqAlunos);
    
    while (!feof($arqAlunos)){
        $linha = fgets($arqAlunos);

        if (trim($linha) == "") continue; 
        $colunaDados = explode(';', $linha);
        
        if ($colunaDados[0] == $matricula){
            $existeMatricula = true;
            break;
        }
    }
    fclose($arqAlunos);

    if ($existeMatricula) {
        $msg = "Matrícula já cadastrada";
    } else {
        $arqAlunos = fopen("alunos.txt", "a") or die("Erro ao abrir arquivo para gravação!");
        $linha = $matricula . ";" . $nome . ";" . $email . "\n";

        if (fwrite($arqAlunos, $linha)) {
            $msg = "Aluno cadastrado com sucesso!";
        } else {
            $msg = "Erro ao salvar os dados.";
        }
        fclose($arqAlunos);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aluno</title>
    
    <script>
        function validarEEnviar() {
            const matricula = document.querySelector('input[name="matricula"]').value.trim();
            const nome = document.querySelector('input[name="nome"]').value.trim();
            const email = document.querySelector('input[name="email"]').value.trim();

            if (matricula == "" || isNaN(matricula)) {
                alert("Insira uma matrícula válida que contenha apenas números.");
                return;
            }

            if (nome.length < 2 || nome == "") {
                alert("Insira um nome válido.");
                return;
            }

            const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regexEmail.test(email)) {
                alert("Insira um endereço de e-mail válido.");
                return;
            }

            document.getElementById('formAluno').submit();
        }
    </script>
</head>
<body>
    <h1>Incluir Novo Aluno</h1>
    
    <form id="formAluno" action="" method="POST">
        Matrícula: <input type="text" name="matricula" required>
        <br><br>
        Nome: <input type="text" name="nome" required>
        <br><br>
        E-mail: <input type="email" name="email" required>
        <br><br>
        
        <button type="button" onclick="validarEEnviar()">Cadastrar Aluno</button>
    </form>

    <p><strong><?php echo $msg; ?></strong></p>

    <hr>
    <a href="EncontrarAlunoEditar.php">Editar Aluno</a> | 
    <a href="EncontrarAlunoExcluir.php">Excluir Aluno</a>
    <hr>
    
    <br>
    <a href="alunos.txt" target="_blank">Visualizar arquivo de texto</a>
</body>
</html>
