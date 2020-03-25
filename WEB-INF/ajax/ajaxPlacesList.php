<?php
require_once '../../config/connect.php';
if (isset($_POST['value'])) {
    $cleanValue = filter_input(INPUT_POST, 'value', FILTER_SANITIZE_NUMBER_INT);
    $cleanId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $query = $db->prepare("UPDATE equipment SET place_id=:cleanValue WHERE id=:cleanId");
    $query->bindValue(':cleanValue', $cleanValue, PDO::PARAM_INT);
    $query->bindValue(':cleanId', $cleanId, PDO::PARAM_INT);
    $query->execute();
}
?>
<table class="table table-hover">
    <?php
    $query = $db->query("SELECT id, description FROM places ORDER BY id");
    $places = $query->fetchAll();
    foreach ($places As $place) {
        echo "<tr><td class='text-left table-dark'>" . $place['description'] . ":</td></tr>";
        echo "<tr><td class='pb-4'>";
        $query = $db->query("SELECT t.name, e.model FROM equipment as e JOIN equipment_types as t ON e.type_id=t.id WHERE e.place_id=" . $place['id'] . " ORDER BY e.id");

        echo "<div class='text-left'>Elementy wyposażenia:</div>";
        if ($query->rowCount() == 0) {
            echo "<p class='mt-2 text-left ml-5'>Brak przypisanego wyposażenia</p>";
        } else {
            $equipments = $query->fetchAll();
            foreach ($equipments As $equipment) {
                echo "<p class='mt-2 text-left ml-5'>" . $equipment['name'] . ": " . $equipment['model'] . "</p>";
            }
        }
        echo "</td></tr>";
    }
    ?>
</table>