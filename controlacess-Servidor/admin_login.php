<?php
session_start();
//conectando ao Banco de dados.
require 'connectDB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
//Faço uma consulta no banco de dados para realizar a autenticação se é ou não admin.
	if(isset($_POST['login'])) {
      $uLogin = $_POST['Ulogin'];
      $pass = $_POST['Upass'];
      $sql = "SELECT user FROM admin WHERE user = ? AND senha = ?";
      $result = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($result, $sql)) {
          header("location: login.php?error=SQL_Error");
          exit();
      }else{
          mysqli_stmt_bind_param($result, "ss", $uLogin, $pass);
          mysqli_stmt_execute($result);
          $result1 = mysqli_stmt_get_result($result);
          if($row = mysqli_fetch_assoc($result1)){
            //COLOCAR A URL DO FORMULARIO DO ADMIN
            header("location: AddCard.php");
          }else{
            header("location: login.php?error=SQL_Error");
          }
      }

}
}
?>