    
    <div id="painel_principal">
    <div id="logo"></div>
<nav>
    <ul>
        <li><a href = "http://localhost/rpg"> Pagina Inicial</a></li>
    </ul>
</nav>
        
        <?php
        include 'functions.php';
        if(isset($_POST['cadastrar']))
        {
            $login = $_POST['login'];
            $senha = $_POST['senha'];

           if(empty($login)||empty($senha)) echo "Todos os campos devem ser preenchidos!";
           else{
            $senha = md5($senha);
            $sql = "SELECT `login` FROM player WHERE login = '{$login}'";
            $login_existe = mysqli_num_rows(mysqli_query($conexao,$sql));
            if($login_existe == 0)
            {
                $sql = "INSERT INTO `player`(`login`,`senha`) VALUES ( '$login', '$senha')";
                $executar = mysqli_query($conexao,$sql);
                echo "Cadastro realizado com sucesso!";
            }else echo "Login já cadastrado!";
           }
        }
        ?>
        <!-- formulário de login-->        
        <form action="" method="POST" id="painel_login">
            <label for="login">Login</label>
            <input type="text" name='login' id="login">
            <label for="senha">Senha</label>            
            <input type="password" name="senha" id="senha">
            <label>Email</label>
            <input type="email" name="email" id="email">
            <input type="submit" value="Cadastrar" id="sub_cadastrar" name="cadastrar">
        </form>
    </div>

