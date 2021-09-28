<form action="index.php" method="post">
    <h4>Wyszukaj pacjenta:</h4>
    <input type="text" name="uzytkownik" placeholder="<?php echo $plhPacjentWP; ?>"><br>
    <input type="hidden" name="operacja" value="8051">
    <input type="submit" value="<?php echo $btFrmWyszukaj; ?>">
</form>