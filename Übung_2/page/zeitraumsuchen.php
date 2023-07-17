

<?php
echo '<h1>Rezepte</h1>';
echo '<h2>Rezepte nach Bereitstellungszeitraum durchsuchen</h2>';




if(isset($_POST['save']))

{


$datumvon = $_POST['datumvon'];

$datumbis = $_POST['datumbis'];

$query = 'SELECT rezeptname_name as "Rezeptname"
FROM zubereitung z,rezeptname r
WHERE zubereitung_bereitgestellt_am 
BETWEEN "'.date('Y-m-d H:i:s',strtotime($datumvon)).'" AND "'.date('Y-m-d H:i:s',strtotime($datumbis)).'"
AND r.rezeptname_id = z.rezeptname_id';  

$stmt = $con->prepare($query);
$stmt->execute();        
maketable($query);


    }
    else if(isset($_POST['save2']))
    {

    $zeitraum = $_POST['zeitraum'];
    $monatsnummer = $_POST['monatsnummer'];

  
    if($zeitraum == 'letzter Monat')
    {
        $query = 'SELECT rezeptname_name as "Rezeptname"
        FROM zubereitung z,rezeptname r
        WHERE zubereitung_bereitgestellt_am 
BETWEEN "'.date('Y-m-d H:i:s',strtotime('first day of previous month')).'" AND "'.date('Y-m-d H:i:s',strtotime('last day of previous month')).'"
and r.rezeptname_id = z.rezeptname_id';  
    }
    else if($zeitraum == 'laufender Monat')
    {
        $query = 'SELECT rezeptname_name as "Rezeptname"
        FROM zubereitung z,rezeptname r
        WHERE zubereitung_bereitgestellt_am 
        BETWEEN "'.date('Y-m-d H:i:s',strtotime('first day of this month')).'" AND "'.date('Y-m-d H:i:s',strtotime('last day of this month')).'"
        and r.rezeptname_id = z.rezeptname_id';
    }
    else
    {

$tmp = date('n');
$monatsnummer -= $tmp;

     
$query = 'SELECT rezeptname_name as "Rezeptname" as "Rezeptname"
FROM zubereitung z,rezeptname r
WHERE zubereitung_bereitgestellt_am 
BETWEEN "'.date('Y-m-d H:i:s',strtotime('first day of '.$monatsnummer.' month')).'" AND "'.date('Y-m-d H:i:s',strtotime('last day of '.$monatsnummer.' month')).'"
and r.rezeptname_id = z.rezeptname_id';

        
    }
    
    $stmt = $con->prepare($query);
    $stmt->execute();        
    maketable($query);


        }
    
    else
    {
?>
<form method="POST">        
    <label for="rezeptname">Zeitraum von: </label>
    <input type="date" id="datumvon" name="datumvon" placeholder="01.01.2022" required><br><br>
    
    
    <label for="rezeptname">Zeitraum bis: (kann ausgelesen werden)</label>
    <input type="date" id="datumbis" name="datumbis" placeholder="01.01.2023" required><br><br>
    

    <input type="submit" name="save" value="Suche starten"><br><br>
</form>
<form method="POST">
    <h2>Oder wählen Sie folgende Optionoen aus</h2>

    <fieldset>
    <input type="radio" id="last" name="zeitraum" value="letzter Monat">
    <label for="mc"> letzter Monat</label> <br>
    <input type="radio" id="now" name="zeitraum" value="laufender Monat">
    <label for="vi"> laufender Monat</label><br>
    <input type="radio" id="monat" name="zeitraum" value="monat">
    <label for="ae"><input type="text" id="monatsnummer" name="monatsnummer" > Monat des laufenden Jahres z.B. 4</label> 
  </fieldset><br>


  <input type="submit" name="save2" value="Suche starten"><br><br>
  </form>

    <?php    
}
        

?>






<?php






?>

