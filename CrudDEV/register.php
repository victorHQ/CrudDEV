<?php
    require_once 'classes/class-dev.php';                       //Classe com os metodos                         
    $devCadastro = new Dev($dbname, $host, $username, $passwd); //Objeto instanciando a classe
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <!-- Metadados-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        

        <!-- Contador da textarea -->
        <script src="scripts/textarea.js"></script>

        <!-- Style geral -->
        <link rel="stylesheet" href="styles/css/formulario.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100&display=swap" rel="stylesheet">
        
        <!-- Style da img -->
        <style>
            .imgregistro{
                width: 385px;
                margin-bottom: -4.5px;
            }

            img{
                max-width: 23em;
                border-radius: 1em 0 0 1em;
                margin-left: -0.1em;
                height: 58em;
            }
        </style>      

        <!-- Título da página -->
        <title>Formulario - Cadastro</title>
    </head>

    <?php require 'includes/header.php' ?>

    <body>          
        
        <div class="container">            
            <!-- Início do formulário -->
            <div class="imgregistro">
                <img src="img/Cadastro-de-DEVs.png" alt="Cadastro de DEVs">
            </div>

            <?php
                //Verificação das variáveis de input
                if(isset($_POST["enviar"])){
                    $nome = addslashes($_POST["nome"]);
                    $sobrenome = addslashes($_POST["sobrenome"]);
                    $email = addslashes($_POST["email"]);
                    $telefone = addslashes($_POST["telefone"]);
                    $especialidade = addslashes($_POST["especialidade"]);
                    $senioridade = addslashes($_POST["senioridade"]);
                    $tecnologias = addslashes(implode(", ", $_POST["tecnologias"]));
                    $experiencia = addslashes($_POST["experiencia"]);

                    if(!empty($nome) && !empty($sobrenome) && !empty($email) && !empty($telefone) 
                        && !empty($especialidade) && !empty($senioridade) && !empty($tecnologias) && !empty($experiencia)){

                            //Cadastrar
                            if(!$devCadastro->cadastrarDev($nome, $sobrenome, $email, $telefone, $especialidade, $senioridade, $tecnologias, $experiencia)){
                                echo "<script type='text/javascript'>alert('Email já cadastrado!');</script>";
                            }
                    }
                    else{
                        echo "<script type='text/javascript'>alert('Preencha todos os campos!');</script>";
                    }
                }
            ?>

            <form method="post">
                <div class="limitar">
                    <fieldset class="grupo">
                            
                        <div class="campo">
                            <label for="nome"><strong>Nome</strong></label>
                            <input type="text" name="nome" id="nome" maxlength="30" required>
                        </div>
         
                        <div class="campo sobrenome">
                            <label for="sobrenome"><strong>Sobrenome</strong></label>
                            <input type="text" name="sobrenome" id="sobrenome" maxlength="70" required>
                        </div>
    
                    </fieldset>
                            
                    <fieldset class="grupo">
    
                        <div class="campo">
                            <label for="email"><strong>Email</strong></label>
                            <input type="email" name="email" id="email" maxlength="100" required>
                        </div>
    
                        <div class="campo telefone">
                                <label for="telefone"><strong>Telefone</strong></label>
                                <input type="tel" name="telefone" id="telefone" maxlength="11" required>
                        </div>
                    </fieldset>
                </div>

                <!-- Radio -->
                <div class="campo">
                    <label><strong>Qual sua area de desenvolvimento?</strong></label><br>
                    <label>
                        <input type="radio" name="especialidade" value="Frontend" required> Front-end
                    </label><br>

                    <label>
                        <input type="radio" name="especialidade" value="Backend" required> Back-end
                    </label><br>

                    <label>
                        <input type="radio" name="especialidade" value="Fullstack" required> Fullstack
                    </label>
                </div>

                <!-- Select -->
                <div class="campo">
                    <label for="senioridade"><strong>Senioridade</strong></label><br>
                    <select id="senioridade" name="senioridade" required>
                        <option value="" selected disabled>Selecione</option>
                        <option value="Junior" >Junior</option>
                        <option value="Pleno"  >Pleno</option>
                        <option value="Senior" >Senior</option>
                    </select>
                </div>

                <fieldset class="grupo">
                    <!-- Checkbox -->
                    <div class="campo">
                    <label><strong>Selecione as suas tecnologias</strong></label><br>
                        <select multiple name="tecnologias[]" id="tecnologia" style="width: 15em;" required>
                            <option value="HTML">HTML</option>
                            <option value="CSS">CSS</option>
                            <option value="JavaScript">JavaScript</option>
                            <option value="PHP">PHP</option>
                            <option value="C#">C#</option>
                            <option value="SQL">SQL</option>
                        </select>
                    </div>
                </fieldset>

                <!-- Caixa de texto -->
                <div class="campo">
                    <br>
                    <label><strong>Conte um pouco da sua experiência.</strong></label>
                    <span id="cont" style="float: rigth; font-weight: bold; font-size: 13px" > 500 <strong style="font-size: 13px">Restantes</strong></span>
                    <textarea onkeyup="limite_textarea(this.value)" name="experiencia" id="experiencia" style="width: 35em; margin-right: 2em;" rows="6" maxlength="500" required></textarea>
                        
                    <!-- Botão para enviar o formulário -->
                    <button type="submit" class="botao" name="enviar">Enviar</button>
                </div>
            </form>
        </div>
    </body>
    
<?php include 'includes/footer.php' ?>
