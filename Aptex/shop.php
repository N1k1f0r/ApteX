<?php
    include("connect.php");
    $connect=mysqli_connect($server_db,$user_db,$password_db,$table_db);
    if(isset($_GET["search"]))
    {
        $search='%'.$_GET["search"].'%';
        $zapytanie="select * from produkty where nazwa like '$search'";
    }
    else
    {
        $zapytanie="select * from produkty";
    }
    $wynik=mysqli_query($connect,$zapytanie);
    $ile=mysqli_num_rows($wynik);
    ?>
    <div class="banner-przecena">

    </div>
    <div class='d-flex flex-wrap justify-content-around'>
    <?php
    for($i=0;$i<$ile;$i++)
    {
        $produkt=mysqli_fetch_array($wynik);
        echo("
            <a href='index.php?id=product&id_prod=".$produkt[0]."' class='text-dark'>
                <div class='produkt'>
                    <img src='img/".$produkt[2]."' alt='".$produkt[1]."'>
                    <div class='mt-2 ms-3'>
                        <h3>".$produkt[1]."</h3>
                        <p class='price text-end fw-bold text-primary me-2'>".$produkt[3]." zł</p>
                    </div>
                </div>
            </a>
        ");
    }
    echo("</div>");
?>