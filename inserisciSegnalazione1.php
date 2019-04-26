<!-- Book Taxi Section -->
<div class="book-taxi-section">
    <!-- Container -->
    <div class="container">
        <!-- Section Header -->
        <div class="section-header section-header-white">
            <h6>Segnalazione</h6>
        </div><!-- Section Header -->
        <form class="row" action='inserisciSegnalazione.php' method="post">

            <div class="form-group col-lg-4 col-md-6">
                <label>Titolo Segnalazione</label>
                <input type="text" name="TitoloSegnalazione" placeholder="Titolo Segnalazione" required class="form-control"/>
            </div>
            <div class="form-group col-lg-4 col-md-6">
                <label>Testo Segnalazione</label>
                <input type="text" name="TestoSegnalazione" placeholder="Testo Segnalazione" required class="form-control"/>
            </div>
            <div class="form-group col-lg-4 col-md-6">
                <label>Automobile</label>
                <?php
                $objectC = new User();
                $result = $objectC -> getBookingList($_SESSION['email']);
                echo '<select name="automenu" required class="form-control">'; // Open your drop down box
                while ($row=$result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="'.$row['AUTO'].'">'.$row['AUTO'].'</option>';

                }
                echo '</select>';
                ?>

            </div>
            <div class="form-group col-12 car-type">
                <span><input type="submit"  name="submit1" value="Submit" /></span>
            </div>
        </form>
    </div><!-- Container /- -->
</div><!-- Book Taxi Section /- -->
