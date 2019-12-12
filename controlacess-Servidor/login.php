<!DOCTYPE html>
<html lang="pt-br">

<style type="text/css">
body {background-image:url("image/fundo.jpg");background-repeat:no-repeat;background-attachment:fixed;
    background-position: top right;
    background-size: cover;}
header .head h1 {font-family:aguafina-script;text-align: center;color:#ddd;}
header .head img {float: left;}
header a {float: right;text-decoration: none;font-size:25px;color:red;margin:-60px 0px 0px 20px;padding-right: 100px;color:#ddd;}
a:hover {opacity: 0.8;cursor: pointer;}
.bod {background-color:#ddd; opacity: 0.7;border-collapse: collapse;width:100%;height:270px;padding-bottom:20px}
.opt {float: left;margin: 20px 80px 0px 20px;}
.opt input {padding:4px 0px 2px 6px;margin:4px;border-radius:10px;background-color:#ddd; color: black;font-size:16px;border-color: black}
.opt p {font-family:cursive;text-align: left;font-size:19px;color:#f2f2f2;}
.opt label {color:black;font-size:23px}
.opt label:hover {color:red;opacity: 0.8;cursor: pointer;}
.opt table tr td {font-family:cursive;font-size:19px;color:black;}
.opt #lo {padding:4px 8px;margin-left:0px;background-color:#00A8A9;border-radius:7px;font-size:15px}
.opt #up {padding:4px 8px;margin-left:0px;background-color:#00A8A9;border-radius:7px;font-size:15px}
#lo:hover{opacity: 0.8;cursor: pointer;background-color:red}
#up:hover{opacity: 0.8;cursor: pointer;background-color:green}

.car {font-family:cursive;font-size:19px;padding-top: 45px;margin: 10px}

.op input {border-radius:10px;background-color:#ddd; color: black;font-size:16px;padding-left:5px;margin:18px 0px 0px 10px;border-color: black}
.op button {margin:7px 0px 5px 82px}
.op button:hover {cursor: pointer;}

#table {font-family: Arial, sans-serif;border-collapse: collapse;width:      100%;}
#table td, #table th {border: 1px solid #ddd;padding: 8px;opacity: 0.6;}
#table tr:nth-child(even){background-color: #f2f2f2;}
#table tr:nth-child(odd){background-color: #f2f2f2;opacity: 0.9;}
#table tr:hover {background-color: #ddd; opacity: 0.8;}
#table th {opacity: 0.6;padding-top: 12px;padding-bottom: 12px;text-align: left;background-color:         #00A8A9;color: white;}
   
</style>

<head>
    <meta charset="UTF-8">
    <title>Sistema de Acesso</title>
</head>

<body>
    <header>
        <div class="head">
        <h1>Sistema de Acesso<br>
        Login de Administrador</h1>
        </div>
    </header>
    <div class="bod">    

    <div class="opt">
        <form action="admin_login.php" method="POST" >
            <table>
                <tr>
                    <td>Usuario:</td>
                    <td><input type="text" placeholder="Digite o User" name="Ulogin" required></td>
                </tr>
                <tr>
                    <td>Senha:</td>
                    <td><input type="password" placeholder="Digite a Senha" name="Upass" required></td>
                </tr>
                <tr> 
                  <td><input type="submit" value="Login" name="login" id="up"></td>
            </tr>
            </table>

        </form>
       <div class="car">
      <?php 
        if (isset($_GET['error'])) {
          if ($_GET['error'] == "SQL_Error") {
             echo '<label style="color:red">Usuario ou Senha Incorretos.</label>'; 
          }
          else if ($_GET['error'] == "Matricula") {
             echo '<label style="color:red">Esta matricula esta em uso</label>'; 
          }
          else if ($_GET['error'] == "No_SelID") {
             echo '<label style="color:red">Não foi selecionado um cartão RFID</label>'; 
          }
          else if ($_GET['error'] == "No_ExID") {
             echo '<label style="color:red">Esse cartão não existe</label>'; 
          }
        }
        else if (isset($_GET['success'])) {
          if ($_GET['success'] == "registerd") {
            echo '<label style="color:green;">Usuario cadastrado com sucesso.</label>';
          }
          else if ($_GET['success'] == "Updated") {
            echo '<label style="color:green;">Cadastro atualizado com sucesso</label>';
          }
          else if ($_GET['success'] == "deleted") {
            echo '<label style="color:green;">Cadastro removido com sucesso.</label>';
          }
          else if ($_GET['success'] == "Selected") {
            echo '<label style="color:green;">Cartão Selecionado.</label>';
          }
        }
      ?> 
    </div>  
      </div>  
</div>
   
</body>


</html>