<?php
require_once '../../config/connect.php';
if (!empty($_POST)) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $query = $db->query("SELECT t.name, e.model FROM equipment as e JOIN equipment_types as t ON e.type_id=t.id WHERE e.place_id=" . $id . " ORDER BY e.id");
    ?>
    <div class="alert-warning p-2 w-100 mb-3">
        <div class='text-left'>Elementy wyposażenia:</div>
        <?php
        if ($query->rowCount() == 0) {
            echo "<p class='mt-2 text-left ml-2'>brak wyposażenia</p>";
        } else {
            $equipments = $query->fetchAll();
            foreach ($equipments As $equipment) {
                echo "<p class='mt-2 text-left ml-2'>" . $equipment['name'] . ": " . $equipment['model'] . "</p>";
            }
        }
        ?>
    </div>
    <?php
}