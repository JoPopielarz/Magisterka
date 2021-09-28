<form action="operacjeDB.php" method="post">
    <h4>Wprowadź nowe dane:</h4>
    <input type="text" name="uzytkownik" placeholder="<?php echo $plhUzytkownikFrmEK; ?>" required><br>
    <input type="text" name="mail" placeholder="<?php echo $plhMailFrmEK; ?>" required><br>
    <input type="password" name="haslo" placeholder="<?php echo $plhHasloFrmEK; ?>" required><br>
    <input type="password" name="haslo2" placeholder="<?php echo $plhHaslo2FrmEK; ?>" required><br>
    <input type="hidden" name="id" value="<?php echo $iduzytkownika; ?>">
    <input type="hidden" name="kodOperacji" value="203">
    <input type="submit" value="<?php echo $btFrmPotwierdz; ?>">
</form>