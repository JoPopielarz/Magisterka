<form action="operacjeDB.php" method="post">
    <h4>Wprowadź nowe dane:</h4>
    <?php echo $lblUzytkownikFrmEK; ?>
    <input type="text" name="uzytkownik" placeholder="<?php echo $wiersz['NazwaUzytkownika']; ?>" required><br>
    <?php echo $lblMailFrmEK; ?>
    <input type="text" name="mail" placeholder="<?php echo $wiersz['Mail']; ?>" required><br>
    <?php echo $lblHasloFrmEK; ?>
    <input type="password" name="haslo" required><br>
    <?php echo $lblHaslo2FrmEK; ?>
    <input type="password" name="haslo2" required><br>
    <input type="hidden" name="id" value="<?php echo $iduzytkownika; ?>">
    <input type="hidden" name="kodOperacji" value="203">
    <input type="submit" value="<?php echo $btFrmPotwierdz; ?>">
</form>