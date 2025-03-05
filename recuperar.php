<?php
    //enlace video configuracion xammp https://www.youtube.com/watch?v=5NY603OX-eQ 
    
    //deben de asignar una contraseña de aplicación desde Gmail
    //"Gestionar tu cuenta de Google" buscar "verificación en dos pasos" 
    //"acceder con su contraseña y otorgar un numero telefónico"
    // una vez esto, acceder de nuevo a "Gestionar tu cuenta de Google" 
    //buscar contraseñas de aplicaciones esta opción solo se habilita 
    //si hacen la verificación en dos pasos una vez hecho les generara 
    //una contraseña específicamente para sus proyectos esa es la contraseña
    // que deben de poner en la configuración del sendmail (carpeta dentro del xammp y en archivo php.ini) y el correo es el mismo


    $paracorreo = "alanvergara24547@gmail.com";
    $titulo ="Prueba php";
    $msj = "Prueba php";
    $tucorreo="From:warflexcodess@gmail.com";
    if(mail($paracorreo, $titulo, $msj, $tucorreo))
    {
        echo "Email enviado a";
    }
    else{
        echo "Error";
    }

    header("Location: ingresar_codigo.php")

?>


<?php 
    // $to = "alanvergara24547@gmail.com";
    // $subject = "Codigo De Recuperación";
    // $headers = "From: warflexcodess@gmail.com\r\n";
    // // $headers .= "Reply-To: replytomail@gmail.com\r\n";
    // // $headers .= "CC: theassassin.edu@gmail.com\r\n";
    // // $headers .= "MIME-Version: 1.0\r\n";
    // $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    // $message = '<html><body>';
    // $message .= '<img src="//css-tricks.com/examples/WebsiteChangeRequestForm/images/wcrf-header.png" alt="Website Change Request" />';
    // $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
    // $message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>Details</td></tr>";
    // $message .= "<tr><td><strong>Email:</strong> </td><td>Details</td></tr>";
    // $message .= "<tr><td><strong>Type of Change:</strong> </td><td>Details</td></tr>";
    // $message .= "<tr><td><strong>Urgency:</strong> </td><td>Details</td></tr>";
    // $message .= "<tr><td><strong>URL To Change (main):</strong> </td><td>Details</td></tr>";
    // $addURLS = 'google.com';
    // if (($addURLS) != '') {
    //     $message .= "<tr><td><strong>URL To Change (additional):</strong> </td><td>" . $addURLS . "</td></tr>";
    // }
    // $curText = 'dummy text';           
    // if (($curText) != '') {
    //     $message .= "<tr><td><strong>CURRENT Content:</strong> </td><td>" . $curText . "</td></tr>";
    // }
    // $message .= "<tr><td><strong>NEW Content:</strong> </td><td>New Text</td></tr>";
    // $message .= "</table>";
    // $message .= "</body></html>";
    // $codigo = 1234;

    // if(mail($to,$subject,$message,$headers))
    // {
    //     echo "Email enviado exitosamente";
    //     echo $codigo;
    // }
    // else{
    //     echo "Mail Send Failed";    
    // }
?> 