<div class="container-fluid pt-3">
    <div class="row m-2">
        <div class="col-xs-12 col-sm-12 col-md-12 m-auto main-opacity-background text-center">
            <div class="h4 text-primary p-3 mt-2">Rezerwacja miejsca do pracy
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 mt-0 text-center p-5">
                    <div id='reservationList'></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 mt-0 text-center">
                    <div id="messages" class="text-danger w-100 p-3"></div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label text-right">Miejsce pracy:</label>
                        <div class="col-sm-8">
                            <select id='place' class="form-control" onChange="showEquipment(this.value)">
                                <?php
                                $query = $db->query("SELECT id, description FROM places ORDER BY id");
                                $places = $query->fetchAll();
                                foreach ($places As $place) {

                                    echo "<option value=" . $place['id'] . ">" . $place['description'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div id="equipment" style="display: none;">
                        <div class="form-group row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8" id="equipmentList">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label text-right">Rezerwujący:</label>
                        <div class="col-sm-8">
                            <select id='person' class="form-control">
                                <?php

                                $query = $db->query("SELECT id, name, surname FROM people ORDER BY surname, name");
                                $people = $query->fetchAll();
                                foreach ($people As $person) {

                                    echo "<option value=" . $person['id'] . ">" . $person['surname'] . " " . $person['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label text-right">Dzień rezerwacji:</label>
                        <div class="col-sm-8">
                            <input type="text" id="datepicker" class="form-control" placeholder="DD-MM-RRRR">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label text-right">Godzina rozpoczęcia:</label>
                        <div class="col-sm-8">
                            <select id="time" class="form-control">
                                <?php
                                for ($i = 6; $i <= 21; ++$i) {
                                    echo "<option value=" . $i . ":00:00>" . $i . ":00</option>";
                                    echo "<option value=" . $i . ":30:00>" . $i . ":30</option>";
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label text-right">Godzina zakończenia:</label>
                        <div class="col-sm-8">
                            <select id="finish" class="form-control">
                                <?php
                                echo "<option value='06:30:00'>6:30</option>";
                                for ($i = 7; $i <= 22; ++$i) {
                                    echo "<option value=" . $i . ":00:00>" . $i . ":00</option>";
                                    echo "<option value=" . $i . ":30:00>" . $i . ":30</option>";
                                }
                                echo "<option value='22:00:00'>22:00</option>";
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button onClick="addReservation()" class="btn btn-success btn-block">Dodaj rezerwację
                            </button>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-xs-12 col-sm-6 col-md-6 text-center mt-4">
                            <a href='lista-miejsc' class="btn btn-info btn-block">Lista dostępnych miejsc</a>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 text-center mt-4">
                            <a href='../' class="btn btn-dark btn-block">Powót do strony głównej</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    showReservations();
</script>