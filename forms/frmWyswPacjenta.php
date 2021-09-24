<form action="index.php" method="post">
    <?php echo $lblPacjentWP; ?>
    <input type="text" name="pacjent" placeholder="<?php echo $plhPacjentWP; ?>" required><br>
    <?php echo $lblDataPoczWP; ?>
    <input type="date" name="odkiedy" placeholder="<?php echo $plhDataPoczWP; ?>" required><br>
    <input type="hidden" name="operacja" value="8011">
    <input type="submit" value="<?php echo $btFrmWyszukaj; ?>">
</form>