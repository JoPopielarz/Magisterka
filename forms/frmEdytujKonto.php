<form action="operacjeDB.php" method="post">
    <h4>Wprowadź nowe dane:</h4>
    <?php echo $lblUzytkownikFrmEK; ?>
    <input type="text" name="uzytkownik" placeholder="<?php echo $wiersz['NazwaUzytkownika']; ?>" required><br>

    <?php echo $lblImieNazwiskoFrmEK; ?>
    <input type="text" name="ImieNazwisko" placeholder="<?php echo $wiersz['ImieNazwisko']; ?>" required><br>
    <?php echo $lblAdresFrmEK; ?>
    <input type="text" name="adres" placeholder="<?php echo $wiersz['Adres']; ?>" required><br>
    <?php echo $lblMiejscowoscFrmEK; ?>
    <input type="text" name="miejscowosc" placeholder="<?php echo $wiersz['Miejscowosc']; ?>" required><br>

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