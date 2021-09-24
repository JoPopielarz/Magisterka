<form action="index.php" method="post">
    <?php echo $lblDataPoczWP; ?>
    <input type="date" name="data" placeholder="<?php echo $plhDataPoczWP; ?>"><br>
    <?php echo $lblPomiarWD; ?>
    <input type="text" name="pomiar" placeholder="<?php echo $plhPomiarDP; ?>"><br> <br>
    <input type="hidden" name="operacja" value="4012">
    <input type="submit" value="<?php echo $btFrmWyszukaj; ?>">
</form>