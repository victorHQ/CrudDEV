<?php

require_once 'database/vardb.php';

class Dev
{

    private $conn; //Variável de conexão

    //CONEXÃO COM O BANCO DE DADOS
    public function __construct($dbname, $host, $username, $passwd)
    {
        try {

            $this->conn = new PDO("mysql:host=$host;dbname=cadastro", $username, $passwd);

            //Setando PDO para modo de erro
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $ex) {
            echo 'Erro na conexão: ' . $ex->getMessage();
            exit();
        } catch (Exception $e) {
            echo 'Erro na genérico: ' . $ex->getMessage();
            exit();
        }
    }

    //Metodo para buscar dados e colocar na página index.php
    public function buscarDados()
    {
        $resultado = array();
        $sql = $this->conn->query("SELECT * FROM DESENVOLVEDOR ORDER BY Nome");
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Metodo para buscar dados da Pesquisa
    public function buscarDadosPesquisa($pesquisa)
    {
        $resultado = array();
        $sql = $this->conn->query("SELECT * FROM DESENVOLVEDOR WHERE Nome LIKE '%$pesquisa%' OR Sobrenome LIKE '%$pesquisa%' OR
                                   Especialidade LIKE '%$pesquisa%' OR Senioridade LIKE '%$pesquisa%' OR Tecnologia LIKE '%$pesquisa%'");

        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Metodo para cadastrar DEVs
    public function cadastrarDev($nome, $sobrenome, $email, $telefone, $especialidade, $senioridade, $tecnologias, $experiencia)
    {
        //Verificação da existência do email
        $stmt = $this->conn->prepare("SELECT DevID FROM DESENVOLVEDOR WHERE Email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        //Email ja existe
        if ($stmt->rowCount() > 0) {
            return false;
        }

        //Email não existe
        else {
            $stmt = $this->conn->prepare("INSERT INTO DESENVOLVEDOR(Nome, Sobrenome, Email, Telefone, Especialidade, Senioridade, Tecnologia, Experiencia)
                                    VALUES(:nome, :sobrenome, :email, :telefone, :especialidade, :senioridade, :tecnologia, :experiencia)");
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':sobrenome', $sobrenome);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':telefone', $telefone);
            $stmt->bindValue(':especialidade', $especialidade);
            $stmt->bindValue(':senioridade', $senioridade);
            $stmt->bindValue(':tecnologia', $tecnologias);
            $stmt->bindValue(':experiencia', $experiencia);

            if ($stmt->execute()) {
                header("location: register.php");
                return true;
            }
        }
    }

    //Excluir Desenvolvedor
    public function excluirDev($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM DESENVOLVEDOR WHERE DevID = :devID");
        $stmt->bindValue(":devID", $id);
        $stmt->execute();
    }

    //Buscar os dados de um DEV
    public function buscarDadosDev($id)
    {
        $resultado = array();
        $stmt = $this->conn->prepare("SELECT * FROM DESENVOLVEDOR WHERE DevID = :devID");
        $stmt->bindValue(":devID", $id);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Atualizar os dados no banco de dados
    public function atualizarDados($id, $nome, $sobrenome, $email, $telefone, $especialidade, $senioridade, $tecnologias, $experiencia)
    {
        $stmt = $this->conn->prepare("UPDATE DESENVOLVEDOR SET Nome = :nome, Sobrenome = :sobrenome, Email = :email, Telefone = :telefone,
                Especialidade = :especialidade, Senioridade = :senioridade, Tecnologia = :tecnologia, Experiencia = :experiencia WHERE DevID = :devID");

        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':sobrenome', $sobrenome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':telefone', $telefone);
        $stmt->bindValue(':especialidade', $especialidade);
        $stmt->bindValue(':senioridade', $senioridade);
        $stmt->bindValue(':tecnologia', $tecnologias);
        $stmt->bindValue(':experiencia', $experiencia);
        $stmt->bindValue(':devID', $id);
        $stmt->execute();
    }
}
