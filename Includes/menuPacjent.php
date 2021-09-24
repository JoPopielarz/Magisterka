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
        <button class="btn btn-ssecondary dropdown-toggle" type="button" id="menuLista3"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $mn_tetno; ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="menuLista3">
        <a class="dropdown-item" href="index.php?operacja=301"><?php echo $mn_Wyswietl; ?></a>
        <a class="dropdown-item" href="index.php?operacja=302"><?php echo $mn_Dodaj; ?></a>
        <a class="dropdown-item" href="index.php?operacja=303"><?php echo $mn_Usun; ?></a>
        </div>
    </div>
    <div class="btn-group">
        <button class="btn btn-ssecondary dropdown-toggle" type="button" id="menuLista4"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $mn_cisnienie; ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="menuLista4">
        <a class="dropdown-item" href="index.php?operacja=401"><?php echo $mn_Wyswietl; ?></a>
        <a class="dropdown-item" href="index.php?operacja=402"><?php echo $mn_Dodaj; ?></a>
        <a class="dropdown-item" href="index.php?operacja=403"><?php echo $mn_Usun; ?></a>
        </div>
    </div>
    <div class="btn-group">
        <button class="btn btn-ssecondary dropdown-toggle" type="button" id="menuLista5"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $mn_saturacja; ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="menuLista5">
        <a class="dropdown-item" href="index.php?operacja=501"><?php echo $mn_Wyswietl; ?></a>
        <a class="dropdown-item" href="index.php?operacja=502"><?php echo $mn_Dodaj; ?></a>
        <a class="dropdown-item" href="index.php?operacja=503"><?php echo $mn_Usun; ?></a>
        </div>
    </div>
    <div class="btn-group">
        <button class="btn btn-ssecondary dropdown-toggle" type="button" id="menuLista6"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $mn_cukier; ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="menuLista6">
        <a class="dropdown-item" href="index.php?operacja=601"><?php echo $mn_Wyswietl; ?></a>
        <a class="dropdown-item" href="index.php?operacja=602"><?php echo $mn_Dodaj; ?></a>
        <a class="dropdown-item" href="index.php?operacja=603"><?php echo $mn_Usun; ?></a>
        </div>
    </div>
    <div class="btn-group">
        <button class="btn btn-secondary" type="button" id="Dokumentacja" aria-haspopup="true" aria-expanded="false">
            <a href="index.php?operacja=701"><?php echo $mn_Dokumentacja; ?></a></button>
    </div>
    <div class="btn-group">
        <button class="btn btn-secondary" type="button" id="StronaGlowna" aria-haspopup="true" aria-expanded="false">
            <a href="index.php?operacja=default"><?php echo $mn_StrGlowna; ?></a></button>
    </div>
    <hr>
</div>