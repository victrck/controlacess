<TABLE id='table'>
<TR>
    <TH>Numero RFID</TH>
    <TH>Nome</TH>
    <TH>Matricula</TH>
    <TH>Data</TH>
    <TH>Hora de Entrada</TH>
</TR>
<?php
session_start();
//Conectando ao Banco de Dados
require'connectDB.php';

$seldate = $_SESSION["exportdata"];
//Recupero os logs com base na Data fornecida pelo o usuario e os mostro em uma tabela.
$sql = "SELECT * FROM logs WHERE DateLog='$seldate' ORDER BY id DESC";
$result=mysqli_query($conn,$sql);

if (mysqli_num_rows($result) > 0)
{
  while ($row = mysqli_fetch_assoc($result))
  {
?>
        <TR>
        <TD><?php echo $row['CardNumber'];?></TD>
        <TD><?php echo $row['Name'];?></TD>
        <TD><?php echo $row['Matricula'];?></TD>
        <TD><?php echo $row['DateLog'];?></TD>
        <TD><?php echo $row['TimeIn'];?></TD>
        </TR>
<?php
  }
}
?>
</TABLE>