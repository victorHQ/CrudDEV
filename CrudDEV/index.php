<?php
    require_once 'classes/class-dev.php';               //Classe com os metodos                      
    include_once 'database/createdb.php';               //Criação do banco de dados desse projeto
    $dev = new Dev($dbname, $host, $username, $passwd); //Objeto instanciando a classe
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <link rel="stylesheet" href="styles/css/index.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100&display=swap" rel="stylesheet">

    <?php include 'includes/header.php'?>

    <body>
        <h1>DEVs</h1>
        <section class="flex">
            <?php

                if(isset($_GET["enviaBusca"])){
                    
                    $pesquisa = addslashes($_GET["busca"]);
                    
                    if(!empty($pesquisa)){
                        $dados = $dev->buscarDadosPesquisa($pesquisa);
                    }
                    else{
                        $dados = $dev->buscarDados();
                    }
                }
                else{
                    $dados = $dev->buscarDados();
                }

                if(count($dados) > 0){ //Tem pessoas no banco

                    for ($i=0; $i < count($dados) ; $i++) { 
                        echo "<div id='dev'>";

                        foreach ($dados[$i] as $key => $value) {

                            if($key != "DevID"){
                                echo "<p>" .$value. "</p>";
                            }
                        }
                        ?>
                            <br>
                            <a href="update.php?DevID_up=<?php echo $dados[$i]['DevID'];?>">Editar</a>
                            <a href="index.php?DevID=<?php echo $dados[$i]['DevID'];?>">Excluir</a>
                        <?php
                        echo "</div>";
                    }      
                }
                else{
                    echo "<p style='color: #e8e6e3;'>" ."Nenhum cadastro no banco de dados!". "</p>";
                }
            ?>
        </section>
    </body>

    <?php include 'includes/footer.php' ?>

    <?php
        //Exclusão de DEVs
        if(isset($_GET['DevID'])){
            $id_dev = addslashes($_GET['DevID']);
            $dev->excluirDev($id_dev);
            header("location: index.php");
        }
    ?>