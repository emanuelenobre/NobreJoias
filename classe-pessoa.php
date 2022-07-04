<?php
Class Pessoa {

    private $pdo;
    //FUNÇÕES

    //CONEXÃO COM O BANCO DE DADOS
    public function __construct($host, $dbname, $port, $user, $senha){
        
        try{
            $this->pdo = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$dbname,$user,$senha);
        }
        catch (PDOException $e) {
            echo 'Erro relacionado ao Banco de Dados: '.$e->getMessage();
            exit();
        }
        catch (Exception $e) {
            echo 'Erro genérico: '.$e->getMessage();
            exit();
        }

    }
    //FUNÇÃO PARA BUSCAR DADOS
    public function buscarDados() {
        $res = array();
        $cmd = $this->pdo->query('SELECT * FROM funcionario ORDER BY nome');
        $res = $cmd->fetchAll($this->pdo::FETCH_ASSOC);
        return $res;
        
    }
    
    //FUNÇÃO CADASTRAR
    public function cadastrarPessoa($nome, $telefone, $funcao, $admissao, $ferias) {
        //VERIFICAR SE FUNCIONARIO JÁ FOI CADASTRADO
        $cmd = $this->pdo->prepare('SELECT id from funcionario WHERE nome =:n');
        $cmd->bindValue(':n', $nome);
        $cmd->execute();
        if($cmd->rowCount()>0){
            return false;
        } else {
            $cmd = $this->pdo->prepare('INSERT INTO funcionario (nome, telefone, funcao, admissao, ferias) VALUES (:n, :t, :c, :a, :f)'); 
            $cmd->bindValue(':n', $nome);
            $cmd->bindValue(':t', $telefone);
            $cmd->bindValue(':c', $funcao);
            $cmd->bindValue(':a', $admissao);
            $cmd->bindValue(':f', $ferias);
            $cmd->execute();
            return true;
        }

        }

        public function excluirPessoa($id){
            $cmd = $this->pdo->prepare('DELETE FROM funcionario WHERE id = :id');
            $cmd->bindValue(':id', $id);
            $cmd->execute();

        }

        //BUSCAR DADOS DE UMA PESSOA
        public function buscarDadosPessoa($id){
            $cmd = $this->pdo->prepare('SELECT * FROM funcionario WHERE id = :id');
            $cmd->bindValue(':id', $id);
            $cmd->execute();
            $res = $cmd->fetch($this->pdo::FETCH_ASSOC);
            return $res;

        }

        //ATUALIZAR DO BANCO DE DADOS

      
        public function atualizarDados($id, $nome, $telefone, $funcao, $admissao, $ferias ){
    
            $cmd = $this->pdo->prepare('UPDATE funcionario SET nome = :n, telefone = :t, funcao = :c, admissao = :a , ferias = :f WHERE id = :id');
            $cmd->bindValue(':n', $nome);
            $cmd->bindValue(':t', $telefone);
            $cmd->bindValue(':c', $funcao);
            $cmd->bindValue(':a', $admissao);
            $cmd->bindValue(':f', $ferias);
            $cmd->bindValue(':id', $id);
            $cmd->execute();
          
        }
    
}
?>
