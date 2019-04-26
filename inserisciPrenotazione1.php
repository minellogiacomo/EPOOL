<!-- Book Taxi Section -->
<div class="book-taxi-section">
    <!-- Container -->
    <div class="container">
        <!-- Section Header -->
        <div class="section-header section-header-white">
            <h6>Prenota</h6>
        </div><!-- Section Header -->
        <form class="row" action='inserisciPrenotazione.php' method="post">
            <div class="form-group col-lg-4 col-md-6">
                <label>Note</label>
                <input type="text" name="Note" placeholder="Note" required class="form-control"/>
            </div>
            <div class="form-group col-lg-4 col-md-6">
                <label>Auto</label>
                <?php
                $objectC = new Car();
                $result = $objectC -> getVeicoliDisponibili();
                echo '<select name="automenu" required class="form-control">'; // Open your drop down box
                while ($row=$result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="'.$row['TARGA'].'">'.$row['TARGA'].'</option>';

                }
                echo '</select>';
                ?>
            </div>
            <div class="form-group col-lg-4 col-md-6">
                <label>Indirizzo di Arrivo</label>
                <?php
                $objectD = new Car();
                $result2 = $objectD -> getSostaVeicolo();
                echo '<select name="sostamenu" required class="form-control">'; // Open your drop down box
                while ($row=$result2->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="'.$row['INDIRIZZO'].'">'.$row['INDIRIZZO'].'</option>';

                }
                echo '</select>';
                ?>
            </div>
            <div class="form-group col-12 car-type">
                <span><input type="submit"  name="submit1" value="Prenota" /></span>
            </div>
        </form>
    </div><!-- Container /- -->
</div><!-- Book Taxi Section /- -->
