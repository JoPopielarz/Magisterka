<form action="index.php" method="post">
    <?php echo $lblPacjentWP; ?>
    <input type="text" name="uzytkownik" placeholder="<?php echo $plhPacjentWP; ?>"><br>
    <?php echo $lblImieNazwiskoFrmEK; ?>
    <input type="text" name="imie" placeholder="<?php echo $plhPacjentWP; ?>"><br>
    <input type="hidden" name="operacja" value="8051">
    <input type="submit" value="<?php echo $btFrmWyszukaj; ?>">
</form>