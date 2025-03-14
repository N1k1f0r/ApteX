<?php
    if(isset($_POST["ok"]))
    {
        $pieniadze=$_POST["budzet"];
        include("connect.php");
        $connect=mysqli_connect($server_db,$user_db,$password_db,$table_db);
        $pieniadze+=$saldo;
        mysqli_query($connect,"update users set saldo=".$pieniadze." where login like '".$_SESSION["login"]."'");        
        // headerphp("index.php");
        $_SESSION["saldo"]=$pieniadze;
        headerphp("index.php");
    }
    else
    {
?>
<div class="d-grid" style="place-items:center; height:100vh;">
    <div class="text-center" style="margin-top:-100px">
        <h1>Ile chcesz wpłacić?</h1>
        <form method="post" id="wplacanie">
            <input type="number" name="budzet" min="0" >
            <input type="submit" value="Wpłać" name="ok">
        </form>
    </div>
</div>
<?php 
    }
?>