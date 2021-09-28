<form action="operacjeDB.php" method="post">
    <h4>Wprowadź nowy pomiar:</h4>
    <input type="text" name="pacjent" placeholder="<?php echo $plhPacjentWP; ?>" required><br>
    <select name="parametr" placeholder="<?php echo $plhParametrWD; ?>">
        <option type="hidden" value="tetno"><?php echo $mn_tetno; ?></option>
        <option type="hidden" value="cisnienie"><?php echo $mn_cisnienie; ?></option>
        <option type="hidden" value="saturacja"><?php echo $mn_saturacja; ?></option>
        <option type="hidden" value="cukier"><?php echo $mn_cukier; ?></option>
    </select><br>
    <input type="date" name="data" placeholder="<?php echo $plhDataDP; ?>" required><br>
    <input type="text" name="godzina" placeholder="<?php echo $plhGodzinaDP; ?>" required><br>
    <input type="text" name="pomiar" placeholder="<?php echo $plhPomiarDP; ?>" required><br>
    <input type="hidden" name="kodOperacji" value="803">
    <input type="submit" value="<?php echo $btFrmZapisz; ?>">
</form>