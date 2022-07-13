<?php

    $host="localhost";
    $usuario="root";
    $senha="";
    $bd="projeto";

    $conn = mysqli_connect($host, $usuario, $senha, $bd);

    if(mysqli_connect_errno())
        echo "Falha na conexão: (".mysqli_connect_errno().")";

?>