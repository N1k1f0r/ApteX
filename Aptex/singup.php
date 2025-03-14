<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Robert Żewecki">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>    
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
                    $imie=$_POST["imie"];
                    $nazwisko=$_POST["nazwisko"];
                    $password=md5($_POST["password"]);
                    $password2=md5($_POST["password2"]);
                    if($password!=$password2)
                    {                        
                        echo"<p class='text-danger'>Hasła są różne</p>";
                    }
                    else
                    {
                        include("connect.php");
                        $connect=mysqli_connect($server_db,$user_db,$password_db,$table_db);
                        $zapytanie="select count(login) from logowanie where login like '".$login."'";
                        $wynik =mysqli_query($connect,$zapytanie);
                        $wiersz = mysqli_fetch_array($wynik);
                        if($wiersz[0]==0)
                        {
                            mysqli_query($connect,"insert into logowanie values ('$login','$password')");

                            mysqli_query($connect,"INSERT INTO `users` (`login`, `imie`, `nazwisko`, `saldo`, `rola`) VALUES ('$login', '$imie', '$nazwisko', '0', 'Uzytkownik')") or die(mysqli_error($connect));
                            headerphp("login.php");
                        }
                        else
                        {
                            echo"<p class='text-danger'>Już taki login istnieje</p>";
                        }
                    }
                }
            ?>
            <a href="index.php"><h1><span class="text-dark">Apte</span>X</h1></a>
            <form method="post" class="logowanie">
                <input type="text" placeholder="Login" name="login" autocomplete="off" required><br>
                <input type="text" placeholder="Imie" name="imie" autocomplete="off" required><br>
                <input type="text" placeholder="Nazwisko" name="nazwisko" autocomplete="off" required><br>
                <input type="password" placeholder="Hasło" name="password" required><br>
                <input type="password" placeholder="Powtórz hasło" name="password2" required><br>
                <input type="submit" value="Zarejestruj się" name="submit" id="submit">
                <input type="reset">
            </form>    
        </div>
    </div>
    
</body>
</html>