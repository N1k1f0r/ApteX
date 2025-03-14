<?php
    include("connect.php");
    $connect=mysqli_connect($server_db,$user_db,$password_db,$table_db);
    $id_prod=@$_GET["id_prod"];
    $wynik=mysqli_query($connect,'select * from produkty where id_produkt='.$id_prod);
    $produkt1=mysqli_fetch_array($wynik);
    if(isset($_POST["kosz"]))
    {
        $ilosc=$_POST["ilosc"];
        if($ilosc>$produkt1[4])
        {
            ?>
            <script>
                alert("Nie mamy takiej ilości na stanie");
            </script>
            <?php
                headerphp("index.php?id=product&id_prod=$id_prod");
        }
        else if(isset($_SESSION["login"]))
        {
            mysqli_query($connect,"INSERT INTO koszyk (login,id_produkt,ilosc) values ('".$_SESSION["login"]."', '$id_prod', '$ilosc')") or die(mysqli_error($connect));
            mysqli_query($connect,"UPDATE produkty SET ilosc = '".($produkt1[4] - $ilosc)."' WHERE id_produkt = '$id_prod'");
            headerphp("index.php");

        }
        else
        {
            headerphp("login.php");
        }
    }
    else
    {
?>
<div class="row mt-5 produkt1 align-items-center justify-content-center">
    <div class="col-md-6 text-center">
        <?php
            echo("<img src='img/".$produkt1[2]."' alt='".$produkt1[2]."'>");
        ?>
    </div>
    <div class="col-md-6 d-flex justify-content-center mt-md-0 mt-5">
        <div class="align-middle" style="max-width:500px;">
        <?php
            echo("
                <h2>".$produkt1[1]."</h2>
                <p class='fw-bold text-primary' id='cena'>".$produkt1[3]." zł</p>
                <p>Zostało: ".$produkt1[4]." sztuk</p>
           ");
        ?>
        <form method="post">
            <input type="number" name="ilosc" min="1" max="999" value="1" placeholder="Podaj ilość">
            <input type="submit" name="kosz" id="kosz" value="Dodaj do koszyka">
        </form>
    </div>
    </div>
</div>
<?php
}
?>