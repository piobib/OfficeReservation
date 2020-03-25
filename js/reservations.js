function ajax(target) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
            if (xhttp.status == 200) {
                document.getElementById(target).innerHTML = xhttp.responseText;
            } else {
                alert('Wystąpił nieoczekiwany błąd. Spróbuj jeszcze raz uruchomić stronę.');
            }
        }
    };
    return xhttp;
}

function addReservation() {
    document.getElementById('messages').innerText = "";
    let place = document.getElementById('place').value;
    let person = document.getElementById('person').value;
    let date = document.getElementById('datepicker').value;
    let time = document.getElementById('time').value;
    let finish = document.getElementById('finish').value;
    let reg = new RegExp("\\d{2}-\\d{2}-\\d{4}");
    if (!reg.test(date)) {
        document.getElementById('messages').innerText = "Proszę wprowadzić poprawną datę";
    } else {
        let start = time.split(":");
        let end = finish.split(":");
        if (end[1] === '00') {
            end[1] = 0;
        }
        if (start[1] === '00') {
            start[1] = 0;
        }
        if (parseInt(start[0]) > parseInt(end[0]) || (parseInt(start[0]) == parseInt(end[0]) && parseInt(start[1]) >= parseInt(end[1]))) {
            document.getElementById('messages').innerText = "Proszę wprowadzić poprawne godziny rezerwacji. Godzina zakończenia musi być późniejsza od godziny rozpoczęcia.";
        } else {
            xhttp = ajax('reservationList');
            xhttp.open("POST", "WEB-INF/ajax/ajaxReservationsList.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("place=" + place + "&person=" + person + "&date=" + date + "&time=" + time + "&finish=" + finish);
        }
    }
}

function showReservations() {
    xhttp = ajax('reservationList');
    xhttp.open("POST", "WEB-INF/ajax/ajaxReservationsList.php", true);
    xhttp.send();
}

function changePlace(id, value) {
    xhttp = ajax('placesList');
    xhttp.open("POST", "WEB-INF/ajax/ajaxPlacesList.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id + "&value=" + value);
}

function showEquipment(id) {
    xhttp = ajax('equipmentList');
    xhttp.open("POST", "WEB-INF/ajax/ajaxShowEquipment.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id);
    document.getElementById('equipment').style.display = 'block';
}