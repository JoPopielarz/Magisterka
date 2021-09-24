<form action="operacjeDB.php" method="post">
    <?php echo $lblDataDP; ?>
    <input type="date" name="data" placeholder="<?php echo $plhDataDP; ?>" required><br>
    <?php echo $lblGodzinaDP; ?>
    <input type="text" name="godzina" placeholder="<?php echo $plhGodzinaDP; ?>" required><br>
    <?php echo $lblPomiarDP; ?>
    <input type="text" name="pomiar" placeholder="<?php echo $plhPomiarDP; ?>" required><br>
    <input type="hidden" name="kodOperacji" value="402"><br>
    <input type="submit" value="<?php echo $btFrmZapisz; ?>">
</form>