<form action="operacjeDB.php" method="post">
    <h4>Nowy pomiar ciśnienia:</h4>
    <input type="date" name="data" required><br>
    <input type="text" name="godzina" placeholder="<?php echo $plhGodzinaDP; ?>" required><br>
    <input type="text" name="pomiar" placeholder="<?php echo $plhPomiarDP; ?>" required><br>
    <input type="hidden" name="kodOperacji" value="402"><br>
    <input type="submit" value="<?php echo $btFrmZapisz; ?>">
</form>