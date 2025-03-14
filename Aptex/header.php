<?php
    function headerphp($string)
    {
        echo("
            <script>
               window.location.replace('$string'); 
            </script>");
    }
    function refreshphp()
    {
        echo("
            <script>
                window.location.reload(true); 
            </script>");
    }
?>