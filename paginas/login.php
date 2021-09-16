
<div id="painel_principal">
<div id="logo"></div>
<nav>
    <ul>
        <li><a href = "http://localhost/rpg"> Pagina Inicial</a></li>
        <li><a href = "http://localhost/rpg/index.php?pagina=cadastrar">Cadastrar</a></li>
    </ul>
</nav>

<?php
        include "conexao.php";
        if(isset($_POST['logar']))
        {
            $login = $_POST['login'];
            $senha = $_POST['senha'];

           if(empty($login)||empty($senha)) echo "Todos os campos devem ser preenchidos!";
           else{
            $senha = md5($senha);
            $sql = "SELECT p.id_player, p.login, p.senha, ps.id_personagem FROM rpg.player p
            LEFT JOIN rpg.personagens ps ON ps.id_player = p.id_player
            WHERE login = '{$login}' 
            AND senha = '{$senha}'";
            $valida_login = mysqli_num_rows(mysqli_query($conexao,$sql));
            $info_player = mysqli_fetch_assoc(mysqli_query($conexao,$sql));
            if($valida_login == 1)
            {
                $_SESSION['id_personagem'] = $info_player['id_personagem'];
                $_SESSION['id_player'] = $info_player['id_player'];
                $info_player = $_SESSION['id_player'];
                $id_personagem = $_SESSION['id_personagem'];     
                $id_player = $_SESSION['id_player'];
                if(!isset($id_personagem)){
                    header("location: http://localhost/rpg/index.php?pagina=criarpersonagem");
                }
                
                $sql = "SELECT nick, lv, xp, xp_max, c.nm_classe, sta, `str`, `int`, dex, gold 
                FROM rpg.personagens p 
                JOIN rpg.classes c ON c.id_classe = p.id_classe
                JOIN rpg.atributos a ON c.id_classe = a.id_classe 
                WHERE p.id_personagem = '{$_SESSION['id_personagem']}'";
                $info_player = mysqli_fetch_assoc(mysqli_query($conexao,$sql));

//lista equipamentos
                // $sql = "SELECT sta,str,int,dex,refino
                // FROM rpg.iventarios i
                // JOIN rpg.personagens p ON p.id_personagem = i.id_personagem
                // JOIN rpg.atributos a ON i.id_item = a.id_item
                // WHERE i.id_personagem = '{$id_player}' AND slot IS NULL";
                // $equipamento = mysqli_query($conexao,$sql);
                // $i=1;
                // $equipamentos['slot1'] = '';
                // while($i<=($equipamento->num_rows)){
                // $equipamentos["slot".$i] = mysqli_fetch_assoc($equipamento);
                // $i = $i+1;
                // }
                // $item_slot1 = $equipamentos['slot1']['sta'];

                $sql = "SELECT sum(sta*(refino+1)) sta, sum(`str`*(refino+1)) `str`, sum(`int`*(refino+1)) `int`, sum(dex*(refino+1)) dex, refino
                FROM rpg.inventarios i
                JOIN rpg.personagens p ON p.id_personagem = i.id_personagem
                JOIN rpg.atributos a ON i.id_item = a.id_item
                WHERE i.id_personagem = '{$id_player}' AND slot IS NULL";
                $equipamento = mysqli_fetch_assoc(mysqli_query($conexao,$sql));

                
                $_SESSION['sta_itens_equipados']=$equipamento['sta'];
                $_SESSION['str_itens_equipados']=$equipamento['str'];
                $_SESSION['int_itens_equipados']=$equipamento['int'];
                $_SESSION['dex_itens_equipados']=$equipamento['dex'];
                $_SESSION['nick'] = $info_player['nick'];
                $_SESSION['lv'] = $info_player['lv'];
                $_SESSION['xp'] = $info_player['xp'];
                $_SESSION['xp_max'] = $info_player['xp_max'];
                $_SESSION['classe']  = $info_player['nm_classe'];
                $_SESSION['sta'] = ($info_player['sta']+($info_player['lv']*$info_player['sta']))+$equipamento['sta'];
                $_SESSION['str'] = ($info_player['str']+($info_player['lv']*$info_player['str']))+$equipamento['sta'];
                $_SESSION['int'] = ($info_player['int']+($info_player['lv']*$info_player['int']))+$equipamento['sta'];
                $_SESSION['dex'] = ($info_player['dex']+($info_player['lv']*$info_player['dex']))+$equipamento['sta'];
                $_SESSION['gold'] = $info_player['gold'];


                header("location: http://localhost/rpg/index.php?pagina=jogo");
            }else echo "Login ou senha incorretos!";
        }
           }
        
    
        ?>

        <!-- formulário de login-->
        <form action="" method="POST" id="painel_login">
            <label for="login">Login</label>
            <input type="text" name='login' id="login">
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha">
            <input type="submit" value="Login" id="sub_login" name="logar">
        </form>
        
    </div>

    <script>
        localStorage.setItem('nick',<?php echo $_SESSION['nick'] ?>);
        localStorage.setItem('lv',<?php echo $_SESSION['lv'] ?>);
        var lv = parseInt(localStorage.getItem('lv'));
        localStorage.setItem('xp',<?php echo $_SESSION['xp'] ?>);
        var xp = parseInt(localStorage.getItem('xp'));
        localStorage.setItem('xp_max',<?php echo $_SESSION['xp_max'] ?>);
        var xp_max = parseInt(localStorage.getItem('xp_max'));
        localStorage.setItem('classe',<?php echo $_SESSION['classe'] ?>);
        localStorage.setItem('sta_personagem',<?php echo $_SESSION['sta'] ?>);
        var sta_personagem = parseInt(localStorage.getItem('sta_personagem'));
        var hp_personagem = sta_personagem*3;
        var hp_batalha_personagem = hp_personagem;
        localStorage.setItem('str_personagem',<?php echo $_SESSION['str'] ?>);
        var str_personagem = parseInt(localStorage.getItem('str_personagem'));
        localStorage.setItem('int_personagem',<?php echo $_SESSION['int'] ?>);
        var int_personagem = parseInt(localStorage.getItem('int_personagem'));
        localStorage.setItem('dex_personagem',<?php echo $_SESSION['dex'] ?>); 
        var dex_personagem = parseInt(localStorage.getItem('dex_personagem'));
        localStorage.setItem('gold',<?php echo $_SESSION['gold'] ?>);
        var gold = parseInt(localStorage.getItem('gold'));
        
    </script>