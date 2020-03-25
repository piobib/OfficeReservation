<div class="container-fluid pt-3">
    <div class="row m-2">
        <div class="col-xs-12 col-sm-12 col-md-12 m-auto main-opacity-background text-center">
            <div class="h4 text-primary p-3 mt-2 mb-4">Wyposażenie miejsc do pracy
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 mt-0 text-center p-5">

                    <div id='placesList'></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 mt-0 text-center">
                    <!-- Lista dostępnego wyposażenia wraz z przypisaniem-->
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Rodzaj</th>
                            <th scope="col">Model</th>
                            <th scope="col">Wartość</th>
                            <th scope="col">Opis</th>
                            <th scope="col">Przypisane miejsce</th>
                        </tr>
                        </thead>
                        <?php
                        $query = $db->query("SELECT e.id, t.name, e.model, e.mark, e.buy_year, e.value, e.description, e.place_id FROM equipment as e JOIN equipment_types as t ON e.type_id=t.id ORDER BY e.id");
                        $equipments = $query->fetchAll();
                        foreach ($equipments As $equipment) {
                            echo "<tr><td>" . $equipment['name'] . "</td><td>" . $equipment['model'] . "</td><td>" . $equipment['value'] . "</td><td>" . $equipment['description'] . "</td><td>";
                            $query = $db->query("SELECT id, description FROM places ORDER BY id");
                            $places = $query->fetchAll();
                            echo "<select onChange='changePlace(" . $equipment['id'] . ", this.value);' class='form-control'>";
                            echo "<option value='0'>Brak przypisanego stanowiska</option>";
                            foreach ($places As $place) {
                                $checked = null;
                                if ($place['id'] === $equipment['place_id']) {
                                    $checked = "selected";
                                }
                                echo "<option value=" . $place['id'] . " $checked>" . $place['description'] . "</option>";
                            }
                            echo "</select>";
                        }
                        ?>
                    </table>
                    <div class="row pb-3">
                        <div class="col-xs-12 col-sm-6 col-md-6 text-center mt-4">
                            <a href='rezerwacja-miejsca' class="btn btn-info btn-block">Przejdź do rezerwacji miejsc</a>
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
    changePlace();
</script>

