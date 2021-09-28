<form action="index.php" method="post">
    <h4>Wprowadź dane pacjenta:</h4>
    <?php echo $lblPacjentWP; ?><br>
    <input type="text" name="pacjent" placeholder="<?php echo $plhPacjentWP; ?>" required><br>
    <?php echo $lblDataPoczWP; ?><br>
    <input type="date" name="odkiedy" placeholder="<?php echo $plhDataPoczWP; ?>" required><br>
    <input type="hidden" name="operacja" value="8011">
    <input type="submit" value="<?php echo $btFrmWyszukaj; ?>">
</form>