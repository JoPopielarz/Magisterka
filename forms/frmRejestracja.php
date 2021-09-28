<div class="logowanie">
    <h4>
        <?php echo $napRejestracja; ?><br>
    </h4>
    <form action="Rejestracja.php" method="post">
        <?php echo $NapNazwa; ?><br><input type="text" name="nazwa" placeholder="<?php echo $plhNazwa; ?>" required>
        <?php echo $NapMail; ?><br><input type="email" name="mail" placeholder="<?php echo $plhMail; ?>" required>
        <?php echo $NapHaslo; ?><br><input type="password" name="haslo" required>
        <?php echo $NapHaslo2; ?><br><input type="password" name="haslo2" required>
        <?php echo $NapRola; ?><br><select name="rola" placeholder="Rola użytkownika">
            <option type="hidden" value="pacjent"><?php echo $NapPacjent; ?></option>
            <option type="hidden" value="lekarz"><?php echo $NapLekarz; ?></option>
        </select>
        <div class="g-recaptcha" data-sitekey="6LcWdY4cAAAAAAiqHHYLGcIJ1iPWhNpe5Nx4cfC3"></div>
        <input type="submit" value="<?php echo $btZarejestruj; ?>">
    </form>
</div>