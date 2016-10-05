<?php
require ("functions.php");
//kas on sisseloginud, kui ei ole siis
//suunata login lehele

//kas ?logout on aadressireal
if (isset($_GET['logout'])){
    session_destroy();
    header("Location: login.php");
}

if (!isset ($_SESSION["userId"])){
    header("Location: login.php");
}

$campusNotice = "";

if(isset($_POST["campusGender"]) && isset($_POST['campusColor'])){
    $campusNotice = campusClothing($_POST["campusGender"], $_POST["campusColor"]);
}


$people = getAllCampusClothing();
//echo "<pre>";
//var_dump($people);
//echo "<pre>";

?>


<html>

<style>
    @import "styles.css";
</style>



<form method ="post">
    <table class="table1">
        <tr>
            <th><h2>Profiil</h2></th>
        </tr>
        <tr>
            <td>
                <table class="table2">
                    <tr>
                        <td colspan="3"">Tere tulemast <?=$_SESSION['email'];?>!</td>
                    </tr>
                    <tr>
                        <td colspan="3"><a href="?logout=1">Logi välja</a></td>
                    </tr>
                </table>
        </tr>
        <tr>
            <th><h2>Uuete inimeste lisamine</h2></th>
        </tr>
        <tr>
            <td>
                <table class="table2">
                    <td>
                        <label>Sugu</label><br>
                        <input name = "campusGender" type ="radio" value="Mees" checked>Mees<br>
                        <input name = "campusGender" type ="radio" value="Naine">Naine<br>
                        <input name = "campusGender" type ="radio" value="Unspecified">N/A<br>
                    </td>
                    <td colspan="2">
                        <label>Värv</label><br>
                        <input name = "campusColor" type="color">
                    </td>
                    <tr>
                        <td colspan="3" ><input type ="submit" value = "Submit"></td>
                    </tr>

                    <tr>
                        <td colspan="3"><p class = "redtext"><?=$campusNotice;?></p></td>
                    </tr>
                </table>
        </tr>
        <tr>
            <th><h2>Arhiiv</h2></th>
        </tr>
        <tr>
            <td>
                <table class="table2">
                    <tr>
                        <td colspan="3"">
                        <?php
                        foreach($people as $p){
                            echo "<h3 style='color:".$p->clothingColor.";'>"
                                .$p->clothingGender
                                ."</h3>";
                        }
                        ?>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <th><h2>Arhiivtabel</h2></th>
        </tr>
        <tr>
            <td>
                <table class="table2">
                    <tr>
                        <td colspan="3"">
                        <?php
                        $html = "<table>";
                        $html .= "<tr>";
                        $html .= "<th>id</th>";
                        $html .= "<th>Sugu</th>";
                        $html .= "<th>Värv</th>";
                        $html .= "<th>Loodud</th>";
                        $html .= "</tr>";

                        foreach($people as $p){
                            $html .= "<tr>";
                            $html .= "<td>$p->clothingId</td>";
                            $html .= "<td>$p->clothingGender</td>";
                            $html .= "<td style='background-color:".$p->clothingColor.";'>$p->clothingColor</td>";
                            $html .= "<td>$p->clothingCreated</td>";
                            $html .= "</tr>";
                        }

                        $html .= "</table>";
                        echo $html;

                        ?>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    
    
</form>

</html>