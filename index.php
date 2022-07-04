<?php
require_once 'classe-pessoa.php';
$p = new Pessoa('localhost','nobre_joias','3306','root','');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>CONTROLE DE FUNCIONÁRIOS</title>
</head>
<body>
    <?php
        if(isset($_POST['nome'])) { 

            //-----------------------------BOTÃO EDITAR-----------------------
            if(isset($_GET['id_up']) && !empty($_GET['id_up'])){

            $id_upd = addslashes($_GET['id_up']);
            $nome = addslashes ($_POST['nome']);
            $telefone = addslashes ($_POST['telefone']);
            $funcao = addslashes ($_POST['funcao']);
            $admissao = addslashes ($_POST['admissao']);
            $ferias = addslashes ($_POST['ferias']);
        
            if(!empty($nome) && !empty($telefone) && !empty($funcao) && !empty($admissao) && !empty($ferias)) {
            //EDITAR
            $p->atualizarDados($id_upd, $nome, $telefone, $funcao, $admissao, $ferias);
            header('location: index.php');
            } else {
                ?>
                <div>
                <h4 class='campo'>  <img class='alerta' src='images/alerta.png'> Preencha todos os campos!</h4>
                </div>
                <?php
            }
        }
            
            //-----------------------------BOTÃO CADASTRAR--------------------
            else {
                $nome = addslashes ($_POST['nome']);
                $telefone = addslashes ($_POST['telefone']);
                $funcao = addslashes ($_POST['funcao']);
                $admissao = addslashes ($_POST['admissao']);
                $ferias = addslashes ($_POST['ferias']);
            
            } if (!empty($nome) && !empty($telefone) && !empty($funcao) && !empty($admissao) && !empty($ferias)) {
                
                //CADASTRAR
                   if(!$p->cadastrarPessoa($nome, $telefone, $funcao, $admissao, $ferias)) {
                    ?>
                <div>
                <h4 class='campo'>  <img class='alerta' src='images/alerta.png'>Este funcionário já foi cadastrado!</h4>
                </div>
                <?php
                    }

            } else {
                ?>
                <div class='aviso'>
                <h4 class='campo'>  <img class='alerta' src='images/alerta.png'>Preencha todos os campos!</h4>
                </div>
                <?php
            }
        }
    

            

            
    ?>
    <?php
        if(isset($_GET['id_up'])){ //EDITAR
            $id_update = addslashes($_GET['id_up']);
            $res = $p->buscarDadosPessoa($id_update);
        }
    ?>
    <section id='esquerda'>
        <form method='POST'>
            <h2>CADASTRAR FUNCIONÁRIO</h2>
            <label class='nome' for='nome'>Nome Completo</label>
            <input type='text' name='nome' id='nome' value='<?php if(isset($res)){echo $res['nome'];} ?>'>

            <label for='telefone'>Telefone Whatsapp</label>
            <input type='text' name='telefone' id='telefone' value='<?php if(isset($res)){ echo $res['telefone'];} ?>'>

            <label for= 'funcao'>Função</label>
            <input type='text' name='funcao' id='funcao' value='<?php if(isset($res)){ echo $res['funcao'];} ?>'>

            <label for='admissao'>Data de Admissão</label>
            <input type='text' name='admissao' id='admissao' value='<?php if(isset($res)){ echo $res['admissao'];} ?>'>

            <label for='ferias'>Programação de Férias</label>
            <input type='text' name='ferias' id='ferias' value='<?php if(isset($res)){ echo $res['ferias'];} ?>'>

            <input type='submit' value='<?php if(isset($res)){ echo "Atualizar"; }else { echo 'Cadastrar'; } ?>'>
        </form>
        <img id='logo' class='Logo' src="images/Nobre.jpg">
    </section>
    <section id='direita'>
    <table>
                <tr class='titulo'>
                <td>NOME</td>
                <td>TELEFONE</td>
                <td>FUNÇÃO</td>
                <td>ADMISSÃO</td>
                <td>PROGRAMAÇÃO DE FÉRIAS</td>
                <td></td>
                </tr>
<?php
    $dados = $p->buscarDados();
        if(count($dados) > 0) {
            for ($i=0; $i < count($dados) ; $i++) { 
            echo '<tr>';
                foreach ($dados[$i] as $k => $v) {
                    if($k !='id'){
                    echo '<td>'.$v.'</td>';}
                }
            
        
?> 
<td>
    <a href='index.php?id_up=<?php echo $dados[$i]['id'];?>'>Editar</a>
    <a href='index.php?id=<?php echo $dados[$i]['id'];?>'>Excluir</a>
</td>                                       
<?php
            echo '</tr>';} 
    } else { //BANCO VAZIO
        ?>
        </table>
        <div class='vazio'>
            <h4>Ainda não há funcionários cadastrados!</h4>
        </div>
        <?php
        }
?>  

</section>
</body>
</html>

<?php
    if(isset($_GET['id'])){
        $id_pessoa = addslashes ($_GET['id']);
        $p->excluirPessoa($id_pessoa);
        header('location: index.php');
    }
?>