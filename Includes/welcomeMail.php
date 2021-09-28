<?php
// subject
$subject = 'Witaj w BioApp';

// message
$message = '
<html>
<head>
  <title>Witaj w BioApp!</title>
</head>
<body>
  <h3 style="color:black;">Witaj w BioApp!</h3>
  <p style="color:black;">
  Dziękuję za wybranie mojej aplikacji.
  BioApp ma na celu ułatwienie codziennego, samodzielnego monitorowania wybranych parametrów biomedycznych.<br>
  Pozwala na zapisywanie, usuwanie oraz przeglądanie wykonanych pomiarów.
  </p>
  <br>
  Pytania oraz uwagi można kierować na adres: popielarz@student.agh.edu.pl
  <br>
  Życzę miłego korzystania z BioApp!
  <br>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'From: popielarz@student.agh.edu.pl'       . "\r\n" .
            'Reply-To: popielarz@student.agh.edu.pl' . "\r\n" .
            'X-Mailer: PHP/' . phpversion() .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=iso-8859-1' . "\r\n";
?>