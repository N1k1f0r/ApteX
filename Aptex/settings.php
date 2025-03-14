<?php
    include("connect.php");
    $connect=mysqli_connect($server_db,$user_db,$password_db,$table_db);
    $konto=mysqli_fetch_array(mysqli_query($connect,"select * from users where login like '".$_SESSION['login']."'"));
    if(isset($_POST['zmien']))
    {
        $imie=$_POST['imie'];
        $nazwisko=$_POST['nazwisko'];
        mysqli_query($connect,"UPDATE users SET imie = '$imie', nazwisko = '$nazwisko' WHERE login = '".$_SESSION['login']."'");  
        $_SESSION["imie"]=$imie;
        $_SESSION["nazwisko"]=$nazwisko;
        headerphp("index.php?id=settings");
    }

?>
<div class="w-100 h-100 d-grid place-items-center">
    <div>
        <h2 class="text-center">Ustawienia</h2>
        <form method="post" class="text-center">
            <input type="text" value="<?php echo $konto[0]?>" name="login" disabled><br>
            <input type="text" value="<?php echo $konto[1]?>" name="imie" placeholder="Imie"><br>
            <input type="text" value="<?php echo $konto[2]?>" name="nazwisko" placeholder="Nazwisko"><br>
            <input type="submit" value="Zmień" name="zmien">
        </form>
    </div>
</div>