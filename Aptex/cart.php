<?php 
    $dostawa=12;
    include("connect.php");
    $connect=mysqli_connect($server_db,$user_db,$password_db,$table_db);
    $wynik=mysqli_query($connect,"select produkty.nazwa, produkty.img, produkty.cena, koszyk.ilosc, id_koszyk, produkty.id_produkt from koszyk inner join produkty on koszyk.id_produkt=produkty.id_produkt where login like '$login'") or die(mysqli_error($connect));
    $ile=mysqli_num_rows($wynik);
    $suma=0;
    function usunzkoszyka($id,$connect){
        mysqli_query($connect,"delete from koszyk where id_koszyk = '$id'");
    }
    
    if(isset($_GET['usun']))
    {
        echo $_GET['usun'];
        usunzkoszyka($_GET['usun'],$connect);
        headerphp("index.php?id=cart");
    }
    if(!isset($_POST["kup"]))
    {
        ?>
        
        <div class='row px-md-5 px-0 pb-2 pt-5 border-bottom fw-bold' >
            <div class='col-5 col-md-6 text-center'>
                <p>Produkt</p>
            </div>
            <div class='col-2 col-md-1 text-center'>
                <p>Ilość</p>
            </div>
            <div class='col-2 text-center'>
                <p>Cena</p>
            </div>
            <div class='col-2 text-center'>
                <p>Wartość</p>
            </div>
        </div>
        <?php
        for($i=0;$i<$ile;$i++)
        {
            $produkt=mysqli_fetch_array($wynik);
            $wartosc=$produkt[2]*$produkt[3];
            $suma+=$wartosc;
            echo("
                <div class='row px-md-5 px-0 py-2 border-bottom'>
                    <div class='col-md-2 col-0 d-none d-md-flex p-0'>
                        <p class='pe-0 pe-md-3 fw-bold text-secondary'>".$i+1 ."</p>
                        <img src='img/".$produkt[1]."' alt='".$produkt[1]."' class='w-100 d-none d-md-block rounded'>
                    </div>
                    <div class='col-5 col-md-4 align-middle py-5'>
                        <a href='index.php?id=product&id_prod=".$produkt[5]."' class='link-dark'>
                            <h3 class='ps-md-4 ps-0'>".$produkt[0]."</h3>
                        </a>
                    </div>
                    <div class='col-2 col-md-1 text-center align-middle py-5'>
                        <p class=''>".$produkt[3]."</p>
                    </div>
                    <div class='col-2 text-center align-middle py-5'>
                        <p class=''>".$produkt[2]." zł</p>
                    </div>
                    <div class='col-2 text-center align-middle py-5'>
                        <p class='fw-bold'>".$wartosc." zł</p>
                    </div>
                    <div class='py-5 px-0' style='max-width:20px'>
                    <a href='index.php?id=cart&usun=".$produkt[4]."' class='link-danger' >
                        <i class='bi bi-trash-fill'></i>
                    </a>
                    </div>
                </div>
            ");
        }
        $calkowite=$suma+$dostawa;
        if($ile>0)
        {
            echo("
                <div class='row px-5 py-5 border-bottom'>
                    <div class='col-9 text-center'>
                        <p class='fw-bold'>Suma</p>
                    </div>
                    <div class='col-2 fw-bold text-center'>$suma zł</div>
                </div>
            ");
            ?>
            <form method="post">
                <h2 class="mt-5 mb-2">Wybierz formę płatności</h2>
                <div class="d-flex w-100 justify-content-center">
                    <div class="text-center mx-2">
                        <label for="przelew">
                            <img src="img/przelew.png" alt="przelew" class="w-100">
                        </label><br>
                        <input type="radio" name="forma_plat" value="przelew" id="przelew" required>
                        <label for="przelew">
                            Przelew
                        </label>
                    </div>
                    <div class="text-center border-end border-start mx-2">
                        <label for="blik">
                            <img src="img/blik.png" alt="blik" class="w-100">
                        </label><br>
                        <input type="radio" name="forma_plat" value="blik" id="blik">
                        <label for="blik">
                            Blik
                        </label>
                    </div>
                    <div class="text-center mx-2">
                        <label for="karta">
                            <img src="img/karta.png" alt="karta" class="w-100">
                        </label><br>
                        <input type="radio" name="forma_plat" value="karta" id="karta">
                        <label for="karta">
                            Karta
                        </label>
                    </div>
                </div>
                <h2 class="mt-5 mb-2">Wybierz formę dostawy</h2>
                <div class="ms-5">
                    <input type="radio" name="dostawa" value="kurier" id="kurier"  onclick="update()" required checked>
                    <label for="kurier">
                        <img src="img/ups.png" alt="ups" class="mx-2">
                        Kurier ( 12 zł )
                    </label><br>
                    <input type="radio" name="dostawa" value="paczkomat" id="paczkomat" onclick="update()">
                    <label for="paczkomat">
                        <img src="img/inpost.png" alt="inpost" class="mx-2">
                        Paczkomat ( 5 zł )
                    </label>
                </div>
                <h2 class="mt-5 mb-2">Dane</h2>
                <div class="ms-5" id="adres">
                    <input class ="m-1" type="text" placeholder="Imię" name="imie" value="<?php echo $imie?>"required>
                    <input class ="m-1" type="text" placeholder="Nazwisko" name="nazwisko" value="<?php echo $nazwisko?>"required><br>
                    <input class ="m-1" type="tel" placeholder="*Numer telefonu" name="telefon">
                    <input class ="m-1" type="email" placeholder="*Adres email" name="email"><br>
                    <input class ="m-1" type="text" placeholder="Ulica i numer" name="adres" id="ulica"><br>
                    <input class ="m-1" type="text" placeholder="Kod pocztowy" name="kodpocztowy" pattern="^\d{2}-\d{3}$" required>
                    <input class ="m-1" type="text" placeholder="Miasto" name="miasto" required>
                </div>
                <h2 class="mt-5 pt-5 mb-2">Podsumowanie</h2>
                <div class="ms-5 mt-4 mb-5">
                    <p class="fw-bold">Produkty:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $suma?> zł</p>
                    <p class="fw-bold">Przesyłka:&nbsp;&nbsp;&nbsp;&nbsp;<span id="dostawa_cena"></span> zł</p>
                    <p class="h4 fw-bold mt-3">Do zapłaty:&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-success"><span id="calkowite"></span> zł</span></p>

                    <input type="submit" value="Zapłać" name="kup" id="kup" class="mt-2">
                    <input type="hidden" value="<?php echo $calkowite?>" name='wynik'>
                    
                </div>
            </form>
            <?php        
        }
        else
        {
            ?>
                <p class="h2 text-secondary fw-normal text-center pt-5 mt-5">Brak produktów w koszyku</p>
            <?php
        }
    }
    else
    {
        if(isset($_POST['dostawa']))
        {
            if($_POST['dostawa']=="kurier")
            {
                $dostawa=12;
                $d=strtotime("+5 days");
            }
            else
            {
                $dostawa=5;
                $d=strtotime("+3 days");
            }
        }
        $saldo=$_SESSION["saldo"];
        $calkowite=$_POST["wynik"];
        $form_dostawy=$_POST["dostawa"];
        $platnosc=$_POST["forma_plat"];
        $imie=$_POST["imie"];
        $nazwisko=$_POST["nazwisko"];
        $tel=$_POST["telefon"];
        $email=$_POST["email"];
        $adres=$_POST["adres"];
        $kodpocztowy=$_POST["kodpocztowy"];
        $miasto=$_POST["miasto"];
        if($calkowite>$saldo)
        {
            headerphp("index.php?id=wallet"); 
        }
        else
        {
            mysqli_query($connect,"INSERT INTO adres_zam (imie, nazwisko, telefon, email, adres, kodpocztowy, miasto) VALUES ('$imie', '$nazwisko', '$tel', '$email', '$adres', '$kodpocztowy', '$miasto')");
            $id_adres=mysqli_fetch_array(mysqli_query($connect,"select id_adres from adres_zam order by id_adres desc limit 1"));
            for($i=0;$i<$ile;$i++)
            {
                $produkt=mysqli_fetch_array($wynik);
                mysqli_query($connect,"insert into zamowienia (login, id_produkt, cena_calkowita, ilosc, data, platnosc, forma_dostawy, data_doreczenia, id_adres) VALUES ('$login', '".$produkt[5]."', '".$produkt[2]."', '".$produkt[3]."', '".date("Y-m-d H:i:s")."','$platnosc','$form_dostawy','".date("Y-m-d",$d)."', '".$id_adres[0]."')");
            }
            $_SESSION['saldo']=$_SESSION['saldo']-$calkowite;
            mysqli_query($connect,"UPDATE users SET saldo = '".$_SESSION['saldo']."' WHERE login like '$login'");
            mysqli_query($connect,"delete from koszyk where login like '$login'");
            headerphp("index.php?id=cart"); 
            //headerphp("index.php");            
        }
    }
    
?>
<script>
function update() {
    var suma=<?php echo $suma?>;
    if (document.getElementById('paczkomat').checked) 
    {
        document.getElementById('dostawa_cena').innerHTML=5;
        document.getElementById('calkowite').innerHTML=suma+5;

    }
    else if (document.getElementById('kurier').checked)
    {
        document.getElementById('dostawa_cena').innerHTML=12;
        document.getElementById('calkowite').innerHTML=suma+12;
    }
}
update();

</script>