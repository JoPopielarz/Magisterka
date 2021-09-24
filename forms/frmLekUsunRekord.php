<form action="index.php" method="post">
    <?php echo $lblPacjentWP; ?>
    <input type="text" name="pacjent" placeholder="<?php echo $plhPacjentWP; ?>" required><br>
    <?php echo $lblParametrWD; ?>
    <select name="parametr" placeholder="<?php echo $plhParametrWD; ?>" required>
        <option type="hidden" value="tetno"><?php echo $mn_tetno; ?></option>
        <option type="hidden" value="cisnienie"><?php echo $mn_cisnienie; ?></option>
        <option type="hidden" value="saturacja"><?php echo $mn_saturacja; ?></option>
        <option type="hidden" value="cukier"><?php echo $mn_cukier; ?></option>
    </select><br>
    <?php echo $lblDataPoczWP; ?>
    <input type="date" name="odkiedy" placeholder="<?php echo $plhDataPoczWP; ?>" required><br><br>
    <input type="hidden" name="operacja" value="8041">
    <input type="submit" value="<?php echo $btFrmWyszukaj; ?>">
</form>