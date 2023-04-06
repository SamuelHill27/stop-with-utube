window.onload = function () {
    let texts = document.getElementsByTagName('TEXTAREA');
    let toSend;

    for (let elem of texts) {
        elem.value = getDB([Number(elem.id.slice(-1))]); // converts last char from textarea id to int where textareas text is then set to text in database with specific id
        if (!elem.value) {
            alert("Error: Unable to get data. Please contact Sam");
        }

        elem.addEventListener('input', function () { 
            toSend = [Number(this.id.slice(-1)), this.value]; // creating array with id and text of textarea
            toSend = encodeURIComponent(JSON.stringify(toSend)); // putting array into form more easily readable by php
            if (!getDB(toSend)) {
                alert("Error: Unable to update. Please contact Sam");
            }
        });
    }
}

// ajax call responsible for requesting database results as obj using search data
// returns object of database rows
function getDB(toSend) {
    let response;

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () { response = JSON.parse(this.responseText) }
    xhttp.open("GET", "update.php?q=" + toSend, false);
    xhttp.send();

    return response;
}