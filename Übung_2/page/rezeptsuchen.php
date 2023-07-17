<form method="POST">

<?php

echo '<h1>Nach Rezpt suchen</h1>';




if(isset($_POST['save']))

{


$rezeptname = $_POST['rezeptname'];
$array = array($rezeptname);
$query = 'select rezeptname_id, rezeptname_name from rezeptname where lower(rezeptname_name) like "%'.$rezeptname.'%"';
            
$stmt = $con->prepare($query);
$stmt->execute();        

            echo 'Gesucht wurde nach "'.$rezeptname.'" <br>';
            echo 'Ergebnisliste der Suche: ';

            echo '<select name="rezeptID">';
            while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                echo '<option value="'.$row[0].'">'.$row[1];
               
            }
            echo '<br>';
            echo '<input type="submit" name="ja" value="anzeigen">';
            echo '<input type="hidden" name="rezeptname" value="'.$rezeptname.'">';




    }
    else if(isset($_POST['ja']))
        {
            $rezeptname = $_POST['rezeptname'];
            $rezeptnameID = $_POST['rezeptID'];
            
            $array = array($rezeptname);
    
    $query = "select zubereitung_id, zubereitung_beschreibung from zubereitung where rezeptname_id ='.$rezeptnameID.' ";
    $stmt = $con->prepare($query);
    $stmt->execute();


while ($zubereitung = $stmt->fetch(PDO::FETCH_NUM)) {
    



    $query2 = 'select zuei.zubereitung_einheit_menge as "Menge", ein.einheit_name as "Einheit", zut.zutat_name as "Zutat"
    from zubereitung_einheit zuei
    left join zutat_einheit ze on zuei.zutateinheit_id = ze.zutat_einheit_id
    left join einheit ein on ze.einheit_id = ein.einheit_id
    left join zutat zut on ze.zutat_id = zut.zutat_id
    where zuei.zubereitung_id ='.$zubereitung[0].'';
    

    echo '<label>Rezeptnummer '.$zubereitung[0].': '.$zubereitung[1],'</label>';
    maketable($query2);

}




 




        }
            

        
    
    else
    {
?>
        
    <label for="rezeptname">Rezept suchen: </label>
    <input type="text" id="rezeptname" name="rezeptname" placeholder="z.B. Mamorkuchen" required>
    
    <input type="submit" name="save" value="Suchen">
    <?php    
}
        

?>

</form>




<?php






?>
