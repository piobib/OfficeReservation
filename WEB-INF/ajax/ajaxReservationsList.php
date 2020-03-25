<?php
require_once '../../config/connect.php';
if (!empty($_POST)) {
    $cleanPlace = filter_input(INPUT_POST, 'place', FILTER_SANITIZE_NUMBER_INT);
    $cleanPerson = filter_input(INPUT_POST, 'person', FILTER_SANITIZE_NUMBER_INT);
    $cleanDate = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
    $cleanTime = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_STRING);
    $cleanLength = filter_input(INPUT_POST, 'finish', FILTER_SANITIZE_STRING);
    list($day, $month, $year) = explode('-', $cleanDate);
    $dateFormat = $year . "-" . $month . "-" . $day;
    $date = date("Y-m-d");
    if ($dateFormat >= $date) {
        //check free date and time
        $startTime = date('H:i', strtotime($cleanTime));
        $finishTime = date("H:i", strtotime($cleanLength));
        $query = $db->prepare("SELECT id, reservation_time, reservation_finish FROM reservations WHERE reservation_date = :date AND place_id=:place");
        $query->bindValue(':date', $dateFormat, PDO::PARAM_INT);
        $query->bindValue(':place', $cleanPlace, PDO::PARAM_INT);
        $query->execute();
        $reservations = $query->fetchAll();
        $insert = 1;
        foreach ($reservations As $reservation) {
            $startTimeDb = date('H:i', strtotime($reservation['reservation_time']));
            $finishTimeDb = date("H:i", strtotime($reservation['reservation_finish']));
            if (($startTime >= $startTimeDb && $startTime < $finishTimeDb) || ($finishTime > $startTimeDb && $finishTime <= $finishTimeDb)) {
                $insert = 0;
            }

        }
        if ($insert == 1) {
            $query = $db->prepare("INSERT INTO reservations (place_id, person_id, reservation_date, reservation_time, reservation_finish, reservation_made_date) VALUES (:place, :person, :resDate, :resTime, :resLength, :madeDate)");
            $query->bindValue(':place', $cleanPlace, PDO::PARAM_INT);
            $query->bindValue(':person', $cleanPerson, PDO::PARAM_INT);
            $query->bindValue(':resDate', $dateFormat, PDO::PARAM_INT);
            $query->bindValue(':resTime', $cleanTime, PDO::PARAM_INT);
            $query->bindValue(':resLength', $finishTime, PDO::PARAM_INT);
            $query->bindValue(':madeDate', $date, PDO::PARAM_INT);
            $query->execute();
            ?>
            <div class="alert-success p-3">Rezerwacja została dodana.
            </div>
            <?php
        } else {
            ?>
            <div class="alert-danger p-3">Wprowadzony termin został już wcześniej zarezerwowany. Proszę wybrać inny
                dzień, zmienić miejsce pracy lub zmodyfikować godziny pracy.
            </div>
            <?php
        }
    } else {
        ?>
        <div class="alert-danger p-3">Nie można dokonać rezerwacji, ponieważ wskazany termin już minął.
        </div>
        <?php
    }
}
$query = $db->query("SELECT place_id, person_id, reservation_date, reservation_time, reservation_finish 
FROM reservations ORDER BY reservation_date, reservation_time");
$reservations = $query->fetchAll();
?>
<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">Data</th>
        <th scope="col">Od</th>
        <th scope="col">Do</th>
        <th scope="col">Zarezerwowane miejsce</th>
        <th scope="col">Osoba rezerwująca</th>
        <th scope="col">Telefon</th>
        <th scope="col">Email</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($reservations As $reservation) {
        echo "<tr><td>" . $reservation['reservation_date'] . "</td><td>" . $reservation['reservation_time'] . "</td><td>" . $reservation['reservation_finish'] . "</td>";
        $query = $db->query("SELECT description FROM places WHERE id=" . $reservation['place_id']);
        $place = $query->fetch();
        echo "<td>" . $place['description'] . "</td>";
        $query = $db->query("SELECT name, surname, phone, mail FROM people WHERE id=" . $reservation['person_id']);
        $person = $query->fetch();
        echo "<td>" . $person['name'] . " " . $person['surname'] . "</td><td>" . $person['phone'] . "</td><td>" . $person['mail'] . "</td>";
    }
    ?>
    </tbody>
</table>