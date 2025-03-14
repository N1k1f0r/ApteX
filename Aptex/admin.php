<?php
    if($_SESSION["rola"]!="Admin")
    {
        headerphp("index.php");
    }
    else
    {
?>
<div class="">
    <h2 class="text-center">Panel Administratora</h2>

</div>
<?php
    include("connect.php");
    $connect=mysqli_connect($server_db,$user_db,$password_db,$table_db);
    function dezeaktywuj($connect,$login)
    {
        mysqli_query($connect,"UPDATE users SET aktywny = '0' WHERE login = '$login'");
    }
    function aktywuj($connect,$login)
    {
        mysqli_query($connect,"UPDATE users SET aktywny = '1' WHERE login = '$login'");
    }
    $wynik=mysqli_query($connect,"select * from users");
    $ileW=mysqli_num_rows($wynik);
    $ileK=mysqli_num_fields($wynik);
    if(isset($_GET['dezaktywuj']))
    {
        dezeaktywuj($connect,$_GET['dezaktywuj']);
        headerphp("index.php?id=admin");
    }
    if(isset($_GET['aktywuj']))
    {
        aktywuj($connect,$_GET['aktywuj']);
        headerphp("index.php?id=admin");
    }
    echo("
    <h4 class='mt-5 text-center'>Użytkownicy</h4>
    <table class='text-center'>
    <tr>
        <th></th>
        <th>login</th>
        <th>imie</th>
        <th>nazwisko</th>
        <th>saldo</th>
        <th>rola</th>
        <th>czy_aktywny</th>
        <th>opcja</th>
    </tr>
    ");
    for($i=0;$i<$ileW;$i++)
    {
        echo("<tr>");
        $users=mysqli_fetch_array($wynik);
        for($j=0;$j<$ileK+2;$j++)
        {
            
            if($j==0)
            {
                echo "<td class='px-4'>".$i+1 ."</td>";
            }
            else if($j!=$ileK+1)
            {
                echo "<td>".$users[$j-1]."</td>";
            }
            else
            {
                if($users[5]==1)
                    echo"<td><a href='index.php?id=admin&dezaktywuj=".$users[0]."'>Dezaktywuj</a></td>";
                else
                    echo"<td><a href='index.php?id=admin&aktywuj=".$users[0]."'>Aktywuj</a></td>";
            }
        }
        echo "</tr>";
    }
    echo "</table>";
    $wynik=mysqli_query($connect,"select * from produkty");
    $ileW=mysqli_num_rows($wynik);
    $ileK=mysqli_num_fields($wynik);
    echo("
    <h4 class='mt-5 text-center'>Produkty</h4>
    <table class='text-center'>
    <tr>
        <th>id_produkt</th>
        <th>nazwa</th>
        <th>img</th>
        <th>cena</th>
        <th>ilosc</th>
        <th>opcja</th>
    </tr>");
    if(isset($_GET["edytuj"]))
    {
        $edytuj=$_GET["edytuj"];
    }
    else
    {
        $edytuj=-1;
    }
    if(isset($_POST["dodaj"]))
    {
        $dod_p1=$_POST['dod_produkt1'];
        $dod_p2=$_POST['dod_produkt2'];
        $dod_p3=$_POST['dod_produkt3'];
        $dod_p4=$_POST['dod_produkt4'];
        mysqli_query($connect,"INSERT INTO produkty VALUES (NULL, '$dod_p1', '$dod_p2', '$dod_p3', '$dod_p4')");
        headerphp('index.php?id=admin');
        
    }
    
    for($i=0;$i<$ileW+1;$i++)
    {
        echo("<tr>");
        $produkty=mysqli_fetch_array($wynik);
        if($i!=$edytuj&&$i!=$ileW)
        {
            for($j=0;$j<$ileK+1;$j++)
            {
                
                if($j!=$ileK)
                {
                    echo "<td>".$produkty[$j]."</td>";
                }
                else
                {
                    echo"<td>
                    <a href='index.php?id=admin&edytuj=$i'>Edytuj</a>
                    </td>";
                }
            }
        }
        else if($i==$edytuj)
        {
            if(!isset($_POST["zapisz"]))
            {
                echo("<form method='post'>");
                for($j=0;$j<$ileK+1;$j++)
                {
                    if($j==1||$j==2)
                    {
                        echo "<td> <input type='text' class='text-center' name='produkt".$j."' value='".$produkty[$j]."'></td>";
                    }
                    else if($j==3||$j==4)
                    {
                        echo "<td> <input type='number' class='text-center' name='produkt".$j."' value='".$produkty[$j]."'></td>";
                    }
                    else if($j==0)
                    {   
                        echo "<td> <input type='number' class='text-center' name='produkt0' value='".$produkty[$j]."' readonly></td>";
                    }
                    else
                    {
                        echo"<td>
                        <input type='submit' value='Zapisz' name='zapisz'>
                        </td>";
                    }
                }
                echo("</form>");
            }
            else
            {
                $p0=$_POST['produkt0'];
                $p1=$_POST['produkt1'];
                $p2=$_POST['produkt2'];
                $p3=$_POST['produkt3'];
                $p4=$_POST['produkt4'];
                mysqli_query($connect,"UPDATE produkty SET nazwa = '$p1', img = '$p2', cena = '$p3', ilosc = '$p4' WHERE id_produkt = '$p0'");
                headerphp('index.php?id=admin');
                
            }
        }
        else
        {
            echo("<form method='post'>");
                for($j=0;$j<$ileK+1;$j++)
                {
                    if($j==1||$j==2)
                    {
                        echo "<td> <input type='text' class='text-center' name='dod_produkt".$j."'></td>";
                    }
                    else if($j==3||$j==4)
                    {
                        echo "<td> <input type='number' class='text-center' name='dod_produkt".$j."'></td>";
                    }
                    else if($j==0)
                    {   
                        echo "<td></td>";
                    }
                    else
                    {
                        echo"<td>
                        <input type='submit' value='Dodaj' name='dodaj'>
                        </td>";
                    }
                }
                echo("</form>");

        }
        echo "</tr>";
    }
    echo "</table>";
}
?>