<?php

    $a = $_POST["a"];
    $b = $_POST["b"];
    $operacao = $_POST['operacao'];
    if ($_SERVER["REQUEST_METHOD"] == "POST" && ($a!=null || $b!=null)) {
        switch($operacao){
            case 'soma':
                $resultado = $a + $b;
                break;
            case 'subtracao':
                $resultado = $a - $b;
                break;
            case 'multiplicacao':
                $resultado = $a * $b;
                break;
            case 'divisao':
                if($b==0){
                    echo 'Divisão por 0 inválida';
                }else{
                    $resultado = $a / $b;
                }
                break;
            case 'raiz':
                if($a<=0 || $b<=0){
                    echo 'Insira um índice e/ou um radicando válido';
                }else{
                    $resultado = pow($a, 1/$b);
                }
                break;
            case 'potencia':
                $resultado =  pow($a, $b);
                /*$resultado=$a;
                for($i=1;$i<$b;$i++)
                    {
                        $resultado *= $a;
                    }*/
                break;
        }
    }else{
        echo 'Insira um número válido';
    }
?>
<!DOCTYPE html>
<html>
<body>
<h1><?php echo 'Minha Calculadora!';?></h1>

<form method='POST' action='calculadora.php'>
    a:<input type=text name='a'><br>
    b:<input type=text name='b'>
    <hr>
    <input type=submit value='soma' placeholder="Soma" name="operacao">
    <input type=submit value='subtracao' placeholder="Subtração" name="operacao">
    <input type=submit value='multiplicacao' placeholder="Multiplicação" name="operacao">
    <input type=submit value='divisao' placeholder="Divisão" name="operacao">
    <input type=submit value='raiz' placeholder="Raiz quadrada" name="operacao">
    <input type=submit value='potencia' placeholder="Potência" name="operacao">
    <br><br>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo 'Resultado: ' . $resultado; 
}
?>
    
</body>
</html>