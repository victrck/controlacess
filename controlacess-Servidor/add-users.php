<TABLE  id="table">
  <TR>
    <TH>Matricula</TH>
    <TH>Nome</TH>
    <TH>Numero RFID</TH>
    <TH>Permissao</TH>
    <TH>Inicio Aula</TH>
    <TH>Final Aula</TH>
  </TR>
<?php 
//Conectando ao Banco de Dados
require('connectDB.php');
//Recuperando todos os Users cadastrados no banco de dados e mostrando em uma tabela.
$sql ="SELECT * FROM users ORDER BY id DESC";
$result=mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0)
{
  while ($row = mysqli_fetch_assoc($result))
    {
?>
   <TR>
      <TD><?php echo $row['Matricula']?></TD>
      <TD><?php echo $row['Nome']?></TD>
      <TD><?php echo $row['CardID'];
          if ($row['CardID_select'] == 1) {
              echo '<img src="image/che.png" style="margin-right: 60%; float: right;" width="20" height="20" title="The selected Card">';
          }
          else{
              echo '';
          }?>
      </TD>
      <TD><?php echo $row['Permissao']?></TD>
      <TD><?php echo $row['TempoEntrada']?></TD>
      <TD><?php echo $row['TempoSaida']?></TD>
   </TR>
<?php   
    }
}
?>
</TABLE>