
<?php 
    include("header.php");
    session_start();
    if(isset($_SESSION['login']))
        include("dane.php");
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Robert Żewecki">
    <link rel="icon" href="icon.png">
    <title>Aptex | Robert Żewecki</title>
    <script src="http://code.jquery.com/jquery-latest.pack.js"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div id="wrapper">
        <nav class="navbar navbar-expand-md navbar-light bg-light py-0">
            <div class="container-fluid px-5">
            <a class="navbar-brand" href="index.php">Apte<span class="text-primary">X</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse ms-0 ms-md-5" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-md-0 nav-main-menu">
                    <li class="nav-item">
                        <form class="d-flex" method="">
                            <input class="form-control me-2" type="search" placeholder="Wpisz tutaj" aria-label="Search" name="search">
                            <button class="btn btn-outline-success" type="submit" name="szukaj4" >
                                <div class="d-flex">
                                    <i class="bi bi-search me-2" style="font-size:16px"></i> Szukaj
                                </div>
                            </button>
                        </form>
                    </li>
                </ul>
                <?php
                if(!isset($_SESSION['login']))
                {
                    echo('
                        <a href="login.php" class="zaloguj">Zaloguj</a>'
                    );
                }
                else
                {
                    ?>
                    
                    <ul class="navbar-nav me-auto mb-2 mb-md-0 justify-content-end w-100">
                        <li class="text-center nav-item"> 
                            <a href="index.php?id=wallet" class="nav-link py-0">
                                <i class="bi bi-piggy-bank-fill"></i>
                                <p class='icon-desc ' id="saldo">( <span class="text-success fw-bold"><?php echo $saldo?>zł</span> )</p>
                            </a>
                        </li>
                        <li class="text-center nav-item">
                            <a href="index.php?id=cart" class="nav-link py-0">
                                <i class="bi bi-cart3"></i>
                                <p class="icon-desc">Koszyk</p>
                            </a>
                        </li>
                        <li class="text-center nav-item dropdown px-3">
                            <a href='#' class="nav-link dropdown-toggle py-0 text-primary" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-fill"></i>
                                <!-- <br> -->
                                <?php echo ("<p class='icon-desc'> $imie </p>");?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item link-dark" href="index.php?id=settings">
                                        <i class="bi bi-gear-fill" style="font-size:16px"></i> Ustawienia
                                    </a>
                                </li>
                                <?php
                                    if($_SESSION["rola"]=="Admin")
                                    {
                                    ?>
                                        <li>
                                            <a class="dropdown-item link-dark" href="index.php?id=admin">
                                            <i class="bi bi-code-square" style="font-size:16px"></i> Panel administratora
                                            </a>
                                        </li>
                                    <?php
                                    }
                                ?>
                                <li>
                                    <a class="dropdown-item link-danger" href="index.php?logout=true"><i class="bi bi-power" style="font-size:16px"></i> Wyloguj</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <?php
                }
                ?>
            </div>
        </nav>
            
        <main class="p-5">
            <?php
                if(isset($_POST["szukaj"]))
                {
                    $search=$_POST["search"];
                    headerphp("index.php?search=$search");
                }
                if(isset($_GET['logout']))
                {
                    session_destroy();
                    headerphp("index.php");
                }
                $x=@$_GET["id"];
                if($x=="product")
                {
                    include("product.php");
                }
                else if($x=="wallet")
                {
                    include("wallet.php");
                }
                else if($x=="cart")
                {
                    include("cart.php");
                }
                else if($x=="settings")
                {
                    include("settings.php");
                }
                else if($x=="admin")
                {
                    include("admin.php");
                }
                else
                {
                    include("shop.php");
                }
                
            ?>
        </main>        
    </div>
    <footer class="bg-dark text-light text-center p-5">
        <p class="m-0">Copyright&copy; Robert Żewecki 3fg</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>