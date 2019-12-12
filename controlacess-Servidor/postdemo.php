<?php
    //Conectando ao Banco de Dados
    require('connectDB.php');
//**********************************************************************************************
    //Get current date and time
    date_default_timezone_set('Asia/Damascus');
    $d = date("Y-m-d");
    $t = date("H:i:sa");
//**********************************************************************************************
    $Tarrive = mktime(01,30,00);
    $TimeArrive = date("H:i:sa", $Tarrive);
//**********************************************************************************************   
    $Tleft = mktime(02,30,00);
    $Timeleft = date("H:i:sa", $Tleft);
//**********************************************************************************************

if(!empty($_GET['test'])){
    if($_GET['test'] == "test"){
        echo "The Website is online";
        exit();
    }
}

if(!empty($_GET['CardID'])){

    $Card = $_GET['CardID'];

    $sql = "SELECT * FROM users WHERE CardID=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select_card";
        exit();
    }
    else{
        mysqli_stmt_bind_param($result, "s", $Card);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)){ 
            //Um cartão cadastrado teve acesso
            if (!empty($row['Nome'])){
                $Uname = $row['Nome'];
                $Number = $row['Matricula'];
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select_logs";
                    exit();
                }
                else{
                    //Um usuario cadastrado teve acesso, cadastrando na tabela logs suas informações.
                    if (!$row = mysqli_fetch_assoc($resultl)){
                        
                        $sql = "INSERT INTO logs (CardNumber, Name, Matricula, DateLog, TimeIn) VALUES (? ,?, ?, CURDATE(), CURTIME())";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_Select_login1";
                            exit();
                        }
                        else{
                            mysqli_stmt_bind_param($result, "ssd", $Card, $Uname, $Number);
                            mysqli_stmt_execute($result);
                            echo "Acesso Permitido";
                            exit();
                        }
                    }
                    // //Logout
                    // else {
                    
                    //     $sql="UPDATE logs SET TimeOut=CURTIME() WHERE CardNumber=? AND DateLog=CURDATE()";
                    //     $result = mysqli_stmt_init($conn);
                    //     if (!mysqli_stmt_prepare($result, $sql)) {
                    //         echo "SQL_Error_insert_logout1";
                    //         exit();
                    //     }
                    //     else{
                    //         mysqli_stmt_bind_param($result, "d", $Card);
                    //         mysqli_stmt_execute($result);

                    //         echo "logout";
                    //         exit();
                    //     }
                    // }
                }
            }
            //*****************************************************
            //Cartão disponivel para cadastro
            else{
                $sql = "SELECT CardID_select FROM users WHERE CardID_select=?";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select";
                    exit();
                }
                else{
                    $card_sel = 1;
                    mysqli_stmt_bind_param($result, "i", $card_sel);
                    mysqli_stmt_execute($result);
                    $resultl = mysqli_stmt_get_result($result);
                    
                    if ($row = mysqli_fetch_assoc($resultl)) {

                        $sql="UPDATE users SET CardID_select =?";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_insert";
                            exit();
                        }
                        else{
                            $card_sel = 0;
                            mysqli_stmt_bind_param($result, "i", $card_sel);
                            mysqli_stmt_execute($result);

                            $sql="UPDATE users SET CardID_select =? WHERE CardID=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error_insert_An_available_card";
                                exit();
                            }
                            else{
                                $card_sel = 1;
                                mysqli_stmt_bind_param($result, "is", $card_sel, $Card);
                                mysqli_stmt_execute($result);

                                echo "Cartão RFID Disponivel";
                                exit();
                            }
                        }
                    }
                    else{
                        $sql="UPDATE users SET CardID_select =? WHERE CardID=?";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_insert_An_available_card";
                            exit();
                        }
                        else{
                            $card_sel = 1;
                            mysqli_stmt_bind_param($result, "is", $card_sel, $Card);
                            mysqli_stmt_execute($result);

                            echo "Cartão RFID Disponivel";
                            exit();
                        }
                    }
                } 
            }
        }
        //*****************************************************
        //Um cartão não cadastrando sendo lido pela primeira vez pelo RFID, É PRE CADASTRADO NO BANCO DE DADOS(SOMENTE O NUMERO DO CARTÃO É INSERIDO)
        else{
            $Uname = "";
            $Number = "";

            $sql = "SELECT CardID_select FROM users WHERE CardID_select=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo "SQL_Error_Select";
                exit();
            }
            else{
                $card_sel = 1;
                mysqli_stmt_bind_param($result, "i", $card_sel);
                mysqli_stmt_execute($result);
                $resultl = mysqli_stmt_get_result($result);
                if ($row = mysqli_fetch_assoc($resultl)) {

                    $sql="UPDATE users SET CardID_select =?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error_insert";
                        exit();
                    }
                    else{
                        $card_sel = 0;
                        mysqli_stmt_bind_param($result, "i", $card_sel);
                        mysqli_stmt_execute($result);

                        $sql = "INSERT INTO users (Nome , Matricula, Permissao, TempoEntrada, TempoSaida, CardID, CardID_select) VALUES (?, ?, NULL, NULL, NULL, ?, ?)";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_Select_add";
                            exit();
                        }
                        else{
                            $card_sel = 1;
                            mysqli_stmt_bind_param($result, "sdsi", $Uname, $Number, $Card, $card_sel);
                            mysqli_stmt_execute($result);

                            echo "CARTÃO RFID Disponivel";
                            exit();
                        }
                    }
                }
                else{
                    $sql = "INSERT INTO users (Nome , Matricula, Permissao, TempoEntrada, TempoSaida, CardID, CardID_select) VALUES (?, ?, NULL, NULL, NULL, ?, ?)";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error_Select_add";
                        exit();
                    }
                    else{
                        $card_sel = 1;
                        mysqli_stmt_bind_param($result, "sdsi", $Uname, $Number, $Card, $card_sel);
                        mysqli_stmt_execute($result);

                        echo "CARTÃO RFID Disponivel";
                        exit();
                    }
                }
            } 
        }    
    }
}
//Nenhum cartão detectado
else{
    echo "Empty_Card_ID";
    exit();
}
mysqli_stmt_close($result);
mysqli_close($conn);
?>
