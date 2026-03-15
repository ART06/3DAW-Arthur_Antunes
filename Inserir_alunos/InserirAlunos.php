<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST["matricula"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $msg = "";
    
    if (!file_exists("alunos.txt")) {
        $arqAlunos = fopen("alunos.txt", "w") or die("Erro ao criar arquivo!");
        $cabecalho = "matricula;nome;email\n";
        fwrite($arqAlunos, $cabecalho);
        fclose($arqAlunos);
    }

    $arqAlunos = fopen("alunos.txt", "a") or die("Erro ao abrir arquivo!");
    $linha = $matricula . ";" . $nome . ";" . $email . "\n";
    
    if (fwrite($arqAlunos, $linha)) {
        $msg = "Aluno cadastrado com sucesso!";
    } else {
        $msg = "Erro ao salvar os dados.";
    }
    
    fclose($arqAlunos);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aluno</title>
</head>
<body>
    <h1>Incluir Novo Aluno</h1>
    
    <form action="" method="POST">
        Matrícula: <input type="text" name="matricula" required>
        <br><br>
        Nome: <input type="text" name="nome" required>
        <br><br>
        E-mail: <input type="email" name="email" required>
        <br><br>
        <input type="submit" value="Cadastrar Aluno">
    </form>

    <p><strong><?php echo $msg; ?></strong></p>
    
    <br>
    <a href="alunos.txt" target="_blank">Visualizar arquivo de texto</a>
</body>
</html>