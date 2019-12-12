<?php
session_start();

//Conectando ao Banco de Dados
require 'connectDB.php';
//**********************************************************************************************
//**********************************************************************************************
if ($_SERVER["REQUEST_METHOD"] == "POST"){

	if(isset($_POST['login'])) {

      $Uname = $_POST['Uname'];
      $Number = $_POST['Number'];
      //verifique se existe algum cartão selecionado
      $sql = "SELECT CardID FROM users WHERE CardID_select=?";
      $result = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($result, $sql)) {
          header("location: AddCard.php?error=SQL_Error");
          exit();
      }
      else{
          $card_sel = 1;
          mysqli_stmt_bind_param($result, "i", $card_sel);
          mysqli_stmt_execute($result);
          $resultl = mysqli_stmt_get_result($result);
          if ($row = mysqli_fetch_assoc($resultl)) {
              //verifique se algum usuário já possui a Matricula
              $sql = "SELECT Matricula FROM users WHERE Matricula=?";
              $result = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($result, $sql)) {
                  header("location: AddCard.php?error=SQL_Error");
                  exit();
              }
              else{
                  mysqli_stmt_bind_param($result, "d", $Number);
                  mysqli_stmt_execute($result);
                  $resultl = mysqli_stmt_get_result($result);
                  if (!$row = mysqli_fetch_assoc($resultl)) {
                      //Adicionando um user na tabela user, um simples update é feito ja que o cartão RFID ja foi pré cadastrado.
                      $sql = "UPDATE users SET Nome=?, Matricula=? WHERE CardID_select=?";
                      $result = mysqli_stmt_init($conn);
                      if (!mysqli_stmt_prepare($result, $sql)) {
                          header("location: AddCard.php?error=SQL_Error");
                          exit();
                      }
                      else{
                          $card_sel = 1;
                          mysqli_stmt_bind_param($result, "sdi", $Uname, $Number, $card_sel);
                          mysqli_stmt_execute($result);
                          header("location: AddCard.php?success=registerd");
                          exit();
                      }
                  }
                  //Matricula ja cadastrada
                  else{
                      header("location: AddCard.php?error=Matricula");
                      exit();
                  }
              }
          }
          //Nenhum cartão selecionado
          else{
              header("location: AddCard.php?error=No_SelID");
              exit();
          }
      }
  }

  if (isset($_POST['update'])) {
        
      $Uname = $_POST['Uname'];
      $Number = $_POST['Number'];
      
      $sql = "SELECT CardID FROM users WHERE CardID_select=?";
      $result = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($result, $sql)) {
          header("location: AddCard.php?error=SQL_Error");
          exit();
      }
      else{
          $card_sel = 1;
          mysqli_stmt_bind_param($result, "i", $card_sel);
          mysqli_stmt_execute($result);
          $resultl = mysqli_stmt_get_result($result);
          if ($row = mysqli_fetch_assoc($resultl)) {
              //verifique se algum usuário já possui a Matricula
              $sql = "SELECT Matricula FROM users WHERE Matricula=?";
              $result = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($result, $sql)) {
                  header("location: AddCard.php?error=SQL_Error");
                  exit();
              }
              else{
                  mysqli_stmt_bind_param($result, "d", $Number);
                  mysqli_stmt_execute($result);
                  $resultl = mysqli_stmt_get_result($result);
                  if (!$row = mysqli_fetch_assoc($resultl)) {
                      //atualizando os dados de um usuario na tabela user, um simples update é feito ja que o cartão RFID ja foi cadastrado.
                      $sql = "UPDATE users SET Nome=?, Matricula=? WHERE CardID_select=?";
                      $result = mysqli_stmt_init($conn);
                      if (!mysqli_stmt_prepare($result, $sql)) {
                          header("location: AddCard.php?error=SQL_Error");
                          exit();
                      }
                      else{
                          mysqli_stmt_bind_param($result, "sdi", $Uname, $Number, $card_sel);
                          mysqli_stmt_execute($result);
                          header("location: AddCard.php?success=Updated");
                          exit();
                      }
                  }
                  //matricula ja cadastrada
                  else{
                      header("location: AddCard.php?error=Matricula");
                      exit();
                  }
              }
          }
          //nenhum cartão selecionado
          else{
              header("location: AddCard.php?error=No_SelID");
              exit();
          }
      }
  }
    if(isset($_POST['del']))  {
        //Deletar um usuario com base na numeração do seu cartão RFID
        
        if (!empty($_POST['CardID'])) {

            $CardID = $_POST['CardID'];
            $sql = "SELECT CardID FROM users WHERE CardID=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                header("location: AddCard.php?error=SQL_Error");
                exit();
            }
            else{
                mysqli_stmt_bind_param($result, "s", $CardID);
                mysqli_stmt_execute($result);
                $resultl = mysqli_stmt_get_result($result);
                if ($row = mysqli_fetch_assoc($resultl)) {

                    $sql ="DELETE FROM users WHERE CardID=?";
                    $result = mysqli_stmt_init($conn);
                    if ( !mysqli_stmt_prepare($result, $sql)){
                        header("location: AddCard.php?error=sqlerror");
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "s", $CardID);
                        mysqli_stmt_execute($result);
                        header("location: AddCard.php?success=deleted");
                        exit();
                    }
                }
                else{
                    header("location: AddCard.php?error=No_ExID");
                    exit();
                }
            }
        }
        else{
            header("location: AddCard.php?error=No_SelID");
            exit();
        }
    }

    if(isset($_POST['set'])) {
        //SELECIONANDO UM CARTÃO 
        if (!empty($_POST['CardID'])) {
          
            $CardID = $_POST['CardID'];

            $sql = "SELECT CardID FROM users WHERE CardID=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                header("location: AddCard.php?error=SQL_Error");
                exit();
            }
            else{
                mysqli_stmt_bind_param($result, "s", $CardID);
                mysqli_stmt_execute($result);
                $resultl = mysqli_stmt_get_result($result);
                if ($row = mysqli_fetch_assoc($resultl)) {

                    $sql = "SELECT CardID_select FROM users WHERE CardID_select=?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        header("location: AddCard.php?error=SQL_Error");
                        exit();
                    }
                    else{
                        $card_sel = 1;
                        mysqli_stmt_bind_param($result, "i", $card_sel);
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if ($row = mysqli_fetch_assoc($resultl)) {

                            $sql = "UPDATE users SET CardID_select=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                header("location: AddCard.php?error=SQL_Error");
                                exit();
                            }
                            else{
                                $card_sel = 0;
                                mysqli_stmt_bind_param($result, "i", $card_sel);
                                mysqli_stmt_execute($result);

                                $sql = "UPDATE users SET CardID_select=? WHERE CardID=?";
                                $result = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($result, $sql)) {
                                    header("location: AddCard.php?error=SQL_Error");
                                    exit();
                                }
                                else{
                                    $card_sel = 1;
                                    mysqli_stmt_bind_param($result, "is", $card_sel, $CardID);
                                    mysqli_stmt_execute($result);
                                    header("location: AddCard.php?success=Selected");
                                    exit();
                                }
                            }
                        }
                        else{
                            $sql = "UPDATE users SET CardID_select=? WHERE CardID=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                header("location: AddCard.php?error=SQL_Error");
                                exit();
                            }
                            else{
                                $card_sel = 1;
                                mysqli_stmt_bind_param($result, "is", $card_sel, $CardID);
                                mysqli_stmt_execute($result);
                                header("location: AddCard.php?success=Selected");
                                exit();
                            }
                        }
                    }    
                }
                //CARTÃO NÃO EXISTE
                else{
                    header("location: AddCard.php?error=No_ExID");
                    exit();
                }
            }
        }
        //CARTÃO NÃO SELECIONADO
        else{
            header("location: AddCard.php?error=No_SelID");
            exit();
        }
    }
}
//**********************************************************************************************
?>