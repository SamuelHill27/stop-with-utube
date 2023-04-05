window.onload = function () {
    let texts = document.getElementsByTagName('TEXTAREA');
    for (let elem of texts) {
        elem.addEventListener('change', getDB([Number(elem.id.slice(-1)), elem.value]));
    }
}

// ajax call responsible for requesting database results as obj using search data
// returns object of database rows
function getDB(toSend) {
    console.log(toSend);

    let response;

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        //document.getElementById("test").innerHTML = this.responseText;
        response = JSON.parse(this.responseText);
    }
    xhttp.open("GET", "update.php?q=" + toSend, false);
    xhttp.send();

    return response;
}