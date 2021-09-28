<div class="container">
    <div class="btn-group">
        <hr>
        <button class="btn btn-ssecondary dropdown-toggle" type="button" id="menuLista2"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $mn_konto; ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="menuLista2">
        <a class="dropdown-item" href="index.php?operacja=201"><?php echo $mnKonto_Wyloguj; ?></a>
        <a class="dropdown-item" href="index.php?operacja=202"><?php echo $mnKonto_MojeKonto; ?></a>
        <a class="dropdown-item" href="index.php?operacja=203"><?php echo $mnKonto_Edytuj; ?></a>
        <a class="dropdown-item" href="index.php?operacja=204"><?php echo $mnKonto_Usuń; ?></a>
        </div>
    </div>
    <div class="btn-group">
        <button class="btn btn-ssecondary dropdown-toggle" type="button" id="menuLista8"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $mnL_pacjent; ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="menuLista3">
        <a class="dropdown-item" href="index.php?operacja=801"><?php echo $mn_Wyswietl; ?></a>
        <a class="dropdown-item" href="index.php?operacja=802"><?php echo $mn_Wyszukaj; ?></a>
        <a class="dropdown-item" href="index.php?operacja=803"><?php echo $mn_Dodaj; ?></a>
        <a class="dropdown-item" href="index.php?operacja=804"><?php echo $mn_Usun; ?></a>
        <a class="dropdown-item" href="index.php?operacja=805"><?php echo $mnL_WyszukajPacjent; ?></a>
        </div>
    </div>
    <div class="btn-group">
        <button class="btn btn-secondary" type="button" id="Dokumentacja" aria-haspopup="true" aria-expanded="false" style="background-color: #ededed; border-color: #ededed;">
            <a style="color: black;" href="index.php?operacja=901"><?php echo $mn_Dokumentacja; ?></a></button>
    </div>
    <div class="btn-group">
        <button class="btn btn-secondary" type="button" id="StronaGlowna" aria-haspopup="true" aria-expanded="false" style="background-color: #ededed; border-color: #ededed;">
            <a style="color: black;" href="index.php?operacja=default"><?php echo $mn_StrGlowna; ?></a></button>
    </div>
    <hr>
</div>