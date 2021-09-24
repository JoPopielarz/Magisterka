<form action="operacjeDB.php" method="post">
    <?php echo $lblPacjentWP; ?>
    <input type="text" name="pacjent" placeholder="<?php echo $plhPacjentWP; ?>" required><br>
    <?php echo $lblParametrWD; ?>
    <select name="parametr" placeholder="<?php echo $plhParametrWD; ?>">
        <option type="hidden" value="tetno"><?php echo $mn_tetno; ?></option>
        <option type="hidden" value="cisnienie"><?php echo $mn_cisnienie; ?></option>
        <option type="hidden" value="saturacja"><?php echo $mn_saturacja; ?></option>
        <option type="hidden" value="cukier"><?php echo $mn_cukier; ?></option>
    </select><br>
        <?php echo $lblDataDP; ?>
    <input type="date" name="data" placeholder="<?php echo $plhDataDP; ?>" required><br>
    <?php echo $lblGodzinaDP; ?>
    <input type="text" name="godzina" placeholder="<?php echo $plhGodzinaDP; ?>" required><br>
    <?php echo $lblPomiarDP; ?>
    <input type="text" name="pomiar" placeholder="<?php echo $plhPomiarDP; ?>" required><br>
    <input type="hidden" name="kodOperacji" value="803"><br>
    <input type="submit" value="<?php echo $btFrmZapisz; ?>">
</form>