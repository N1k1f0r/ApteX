
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Robert Żewecki">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>    
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
    
<body>
    <div class="d-grid" style="place-items:center; height:100vh;">
        <div>
            <?php
                include("header.php");
                if(isset($_SESSION["login"]))
                {
                    headerphp("index.php");
                }
                if(isset($_POST["submit"]))
                {
                    $login=$_POST["login"];
                    $password=md5($_POST["password"]);
                    include("connect.php");
                    $connect=mysqli_connect($server_db,$user_db,$password_db,$table_db);
                    $czy_aktywny=mysqli_fetch_array(mysqli_query($connect,"select aktywny from users where login like '$login'"));
                    $zapytanie="select count(login) from logowanie where login like '".$login."' and password like '".$password."'";
                    $wynik =mysqli_query($connect,$zapytanie);
                    $wiersz = mysqli_fetch_array($wynik);
                    if($wiersz[0]!=0)
                    {
                        if($czy_aktywny[0]==0)
                        {
                            echo"<p class='text-danger'>Niestety konto na które próbujesz się<br> zalgować zostało zablokowane</p>";
                        }
                        else
                        {
                            $wynik=mysqli_query($connect,"select * from users where login like '$login'");
                            $dane=mysqli_fetch_array($wynik);
                            session_start();                        
                            $_SESSION["login"]=$login;
                            $_SESSION["imie"]=$dane[1];
                            $_SESSION["nazwisko"]=$dane[2];
                            $_SESSION["saldo"]=$dane[3];
                            $_SESSION["rola"]=$dane[4];
    
                            // $_SESSION
                            headerphp("index.php");
                        }
                    }
                    else
                    {
                        echo"<p class='text-danger'>Nie poprawny login lub hasło</p>";
                    }
                }
            ?>
            <a href="index.php"><h1><span class="text-dark">Apte</span>X</h1></a>
            <form method="post" class="logowanie">
                <input type="text" placeholder="login" name="login" autocomplete="off"><br>
                <input type="password" placeholder="hasło" name="password" autocomplete="off"><br>
                <input type="submit" value="Zaloguj" name="submit" id="submit"><input type="reset">
            </form><br>
            <a href="singup.php">Nie masz konta?</a>    
        </div>
    </div>
    
</body>
</html>