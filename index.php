<?php
/*para rodar, abrir o terminal e no diretorio do arquivo rodar:
$ php -S localhost:8080
*/ 
$nome="";
$erroNome="";
$erroEmail="";
$erroSenha="";
$senha="";
$erroRepeteSenha="";
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    //Verificando se o nome esta preenchido
    if (empty($_POST['nome'])){
      $erroNome = "Por favor, preencha seu nome";
    }

    // Limpa valor do post
    else{
      $nome = safePost($_POST['nome']);
      //verificar caracteres
      if(!preg_match("/^[a-zA-Z-' ]*$/", $nome)){
        $erroNome = "Por favor, digite apenas letras e espaços";
      }
    }

    //Verificando se o e-mail esta preenchido
    if (empty($_POST['email'])){
      $erroEmail = "Por favor, preencha seu e-mail";
    }
    else{
      $email = safePost($_POST['email']);
      //Verifica campo de e-mail com funçao FILTER_VALIDATE_EMAIL
      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $erroEmail = "E-mail inválido!";
      }
    }
    //Verificando senha
    if (empty($_POST['senha'])){
      $erroSenha = "Por favor, defina uma senha segura";
    }
    else{
      $senha = safePost($_POST['senha']);
      if(strlen($senha) < 6){
        $erroSenha = "A senha precisa ter pelo menos 6 caracteres";
      }
    }

    //Verificando se a senha é a mesma
    if (empty($_POST['repete_senha'])){
      $erroRepeteSenha = "Por favor, informe a repetiçao da senha";
    }
    else{
      $repete_senha = safePost($_POST['repete_senha']);
        if ($repete_senha !== $senha){
          $erroRepeteSenha = "As senhas nao conferem";
        }
      }
    if(($erroNome=="") && ($erroEmail=="") && ($erroSenha=="") && ($erroRepeteSenha=="")){
      header('Location: obrigado.php');
    }
  }
  //regra de segurança
  function safePost($valor){
    $valor = trim($valor);
    $valor = stripslashes($valor);
    $valor = htmlspecialchars($valor);
    return $valor;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validação de Formulário</title>
    <link href="css/estilo.css" rel="stylesheet">
</head>
<body>
    <main>
    <h1><span>AULA PHP</span><br>Validação de Formulário</h1>

     <form method="post">

        <!-- NOME COMPLETO -->
        <label> Nome Completo </label>
        <input type="text" <?php if(!empty($erroNome))echo "class='invalido'";?> <?php if (isset($_POST['nome'])){ echo "value='".$_POST['nome']."'";} ?> name="nome" placeholder="Digite seu nome" >
        <br><span class="erro"><?php echo $erroNome;?></span>

        <!-- EMAIL -->
        <label> E-mail </label>
        <input type="email" <?php if(!empty($erroEmail))echo "class='invalido'";?> <?php if (isset($_POST['email'])){ echo "value='".$_POST['email']."'";} ?> name="email" placeholder="email@provedor.com" >
        <br><span class="erro"><?php echo $erroEmail;?></span>

        <!-- SENHA -->
        <label> Senha </label>
        <input type="password" <?php if(!empty($erroSenha))echo "class='invalido'";?> <?php if (isset($_POST['senha'])){ echo "value='".$_POST['senha']."'";} ?> name="senha" placeholder="Digite uma senha" >
        <br><span class="erro"><?php echo $erroSenha;?></span>

        <!-- REPETE SENHA -->
        <label> Repita a Senha </label>
        <input type="password" <?php if(!empty($erroRepeteSenha))echo "class='invalido'";?> <?php if (isset($_POST['repete_senha'])){ echo "value='".$_POST['repete_senha']."'";} ?>  name="repete_senha" placeholder="Repita a senha" >
        <br><span class="erro"><?php echo $erroRepeteSenha;?></span>

        <button type="submit"> Enviar Formulário </button>

      </form>
    </main>
</body>
</html>