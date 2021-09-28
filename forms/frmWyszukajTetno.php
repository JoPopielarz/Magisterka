<form action="index.php" method="post">
    <h4>Wyszukaj pomiary:</h4>
    <?php echo $lblDataPoczWP; ?><br>
    <input type="date" name="data" placeholder="<?php echo $plhDataPoczWP; ?>"><br>
    <?php echo $lblPomiarWD; ?><br>
    <input type="text" name="pomiar" placeholder="<?php echo $plhPomiarDP; ?>"><br>
    <input type="hidden" name="operacja" value="3012">
    <input type="submit" value="<?php echo $btFrmWyszukaj; ?>">
</form>