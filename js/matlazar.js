function ProvjeraRegistracije() {
    var formular = document.getElementById("form2");
    var ispis = document.getElementsByClassName("pogreska");
    formular.addEventListener("submit", function (event) {
        var izlazZaIme = true;
        var izlazZaPrezime = true;
        var izlazZaKorIme = true;
        var izlazZaPass = true;
        var provjeriLozinke = true;
        var izalzZaDanRodjenja = true;
        var izalzZaMjesecRodjenja = true;
        var izlazZaGodinuRodjenja = true;
        var izlazZaTel = true;
        var izlazZaEmail = true;
        var izlazZaSpol = true;
        var izlazZaDrzava = true;

        //Provjera za ime
        var ime = document.getElementById("ime");
        if (ime.value.length === 0) {
            ispis[0].innerHTML = "*Ime morate unijeti";
            izlazZaIme = false;
        }

        if (izlazZaIme !== false) {
            ispis[0].innerHTML = "";
            formular[0].className = "zeleno";
        } else {
            formular[0].className = "crveno";
            event.preventDefault();
        }
        //Kraj provjere za ime

        //Provjera za prezime
        var prezime = document.getElementById("prezime");
        if (prezime.value.length === 0) {
            ispis[1].innerHTML = "*Prezime morate unijeti";
            izlazZaPrezime = false;
        }

        if (izlazZaPrezime !== false) {
            formular[1].className = "zeleno";
            ispis[1].innerHTML = "";
        } else {
            formular[1].className = "crveno";
            event.preventDefault();
        }
        //Kraj provjere za prezime

        //Provjera korisnickog imena
        var korisnickoIme = document.getElementById("korime");
        var brojiSlova = 0;
        var brojiZnakove = 0;
        for (var i = 1; i < korisnickoIme.value.length; i++) {
            if (korisnickoIme.value[i] >= 'A' && korisnickoIme.value[i] <= 'Z') {
                brojiSlova++;
            }
            if (korisnickoIme.value[i] === "?" || korisnickoIme.value[i] === "-" || korisnickoIme.value[i] === "!" || korisnickoIme.value[i] === "#" || korisnickoIme.value[i] === "_" || korisnickoIme.value[i] === "$") {
                brojiZnakove++;
            }
        }

        if (korisnickoIme.value.length === 0) {
            ispis[2].innerHTML = "*Korisničko ime morate unijeti";
            izlazZaKorIme = false;
        }

        if (korisnickoIme.type !== "text") {
            ispis[2].innerHTML = "*Korisničko ime mora biti tipa text";
            izlazZaKorIme = false;
        }
        if (korisnickoIme.value.length < 10) {
            ispis[2].innerHTML = "*Korisničko ime moram imati minimalno 10 znakova";
            izlazZaKorIme = false;
        }
        if (korisnickoIme.value[0] < 'a' || korisnickoIme.value[0] > 'z') {
            ispis[2].innerHTML = "*Prvo slovo mora biti malo";
            izlazZaKorIme = false;
        }

        if (brojiZnakove < 2 || brojiSlova < 1 || brojiSlova > 1) {
            ispis[2].innerHTML = "*Mora sadrzavati dva poseban znaka i točno jedno veliko slovo";
            izlazZaKorIme = false;
        }

        if (izlazZaKorIme !== false) {
            ispis[2].innerHTML = "";
            formular[2].className = "zeleno";
        } else {
            formular[2].className = "crveno";
            event.preventDefault();
        }
        //Kraj provjere korisnickog imena 

        //Provjera lozinke 
        var lozinkaProvjera = document.getElementById("lozinka");
        var brojacZaLozinku = 0;
        var brojacZaPass = 0;
        var brojacBroja = 0;
        for (var j = 0; j < lozinkaProvjera.value.length; j++) {
            if (lozinkaProvjera.value[j] >= 'A' && lozinkaProvjera.value[j] <= 'Z') {
                brojacZaLozinku++;
            }
            if (lozinkaProvjera.value[j] === "?" || lozinkaProvjera.value[j] === "!" || korisnickoIme.value[j] === "#" || lozinkaProvjera.value[j] === "$") {
                brojacZaPass++;
            }
            if (isNaN(lozinkaProvjera.value[j])) {
                brojacBroja++;
            }
        }
        if (lozinkaProvjera.type !== "password") {
            ispis[3].innerHTML = "*Lozinka mora biti tipa password";
            izlazZaPass = false;
        }
        if (lozinkaProvjera.value.length < 8) {
            ispis[3].innerHTML = "*Lozinka mora imati minimalno 8 znakova";
            izlazZaPass = false;
        }

        if (brojacZaPass < 2 || brojacZaLozinku < 2 || brojacBroja < 2) {
            ispis[3].innerHTML = "*Mora sadrzavati barem dva poseban znaka ?,!,#,$, barem dva velika slova i barem dva broja";
            izlazZaPass = false;
        }


        if (izlazZaPass !== false) {
            ispis[3].innerHTML = "";
            formular[3].className = "zeleno";
        } else {
            formular[3].className = "crveno";
            event.preventDefault();
        }
        //Kraj provjere lozinke

        //Provjera potvrdne lozinke
        var brojacPogodaka = 0;
        var lozinka2Provjera = document.getElementById("potvrda_lozinke");
        for (var j = 0; j < lozinka2Provjera.value.length; j++) {
            if (lozinka2Provjera.value[j] === lozinkaProvjera.value[j]) {
                brojacPogodaka++;
            }
        }
        if (lozinka2Provjera.value.length === 0) {
            ispis[4].innerHTML = "*Lozinku morate potvrditi";
            provjeriLozinke = false;
        }

        if (brojacPogodaka !== lozinka2Provjera.value.length) {
            ispis[4].innerHTML = "*Lozinke se ne podudaraju";
            provjeriLozinke = false;
        }

        if (provjeriLozinke !== false) {
            ispis[4].innerHTML = "";
            formular[4].className = "zeleno";
        } else {
            formular[4].className = "crveno";
            event.preventDefault();
        }
        //Kraj provjere potvrdne lozinke

        //Provjera dana rođenja 
        var danRodjenja = document.getElementById("dan");
        if (danRodjenja.type !== "number") {
            ispis[5].innerHTML = "*Dan rođenja mora biti tipa number";
            izalzZaDanRodjenja = false;
        }

        if (danRodjenja.value.length < 1) {
            ispis[5].innerHTML = "*Morate unijeti dan rođenja";
            izalzZaDanRodjenja = false;
        }

        if (danRodjenja.value < 0) {
            ispis[5].innerHTML = "*Dan rođenja ne može biti negativna vrijednost";
            izalzZaDanRodjenja = false;
        }

        if (izalzZaDanRodjenja !== false) {
            ispis[5].innerHTML = "";
            formular[5].className = "zeleno";
        } else {
            formular[5].className = "crveno";
            event.preventDefault();
        }
        //Kraj provjere dana rođenja

        //Provjera mjeseca rođenja
        var mjesecRodjenjaLista = document.getElementById("mjesec");
        if (mjesecRodjenjaLista.value === "0") {
            ispis[6].innerHTML = "*Morate odabrati mjesec rođenja";
            izalzZaMjesecRodjenja = false;
        }
        if (izalzZaMjesecRodjenja !== false) {
            ispis[6].innerHTML = "";
            formular[6].className = "zeleno";
        } else {
            formular[6].className = "crveno";
            event.preventDefault();
        }
        //Kraj provjere mjeseca rođenja

        //Provjera godine rođenja
        var godRodjenja = document.getElementById("godina");
        if (godRodjenja.type !== "number") {
            ispis[7].innerHTML = "*Godina mora biti tipa number";
            izlazZaGodinuRodjenja = false;
        }
        if (godRodjenja.value < 0) {
            ispis[7].innerHTML = "*Godina ne moze biti negativan broj";
            izlazZaGodinuRodjenja = false;

        }

        if (godRodjenja.value < 1930 || godRodjenja.value > 2015) {
            ispis[7].innerHTML = "*Godina mora biti u rasponu od 1930 - 2015";
            izlazZaGodinuRodjenja = false;

        }

        if (izlazZaGodinuRodjenja !== false) {
            ispis[7].innerHTML = "";
            formular[7].className = "zeleno";
        } else {
            formular[7].className = "crveno";
            event.preventDefault();
        }
        //Kraj provjere godine rođenja

        //Provjera spola
        var spol = document.getElementById("spol");
        if (spol.value === '0') {
            ispis[8].innerHTML = "*Morate odabrati spol";
            izlazZaSpol = false;
        }

        if (izlazZaSpol !== false) {
            ispis[8].innerHTML = "";
            formular[8].className = "zeleno";
        } else {
            formular[8].className = "crveno";
            event.preventDefault();
        }
        //Kraj provjere spola

        //Provjera drzave
        var drzava = document.getElementById("drzava");
        if (drzava.value === "") {
            ispis[9].innerHTML = "*Obavezni ste odabrati državu";
            izlazZaDrzava = false;
        }

        if (izlazZaDrzava !== false) {
            ispis[9].innerHTML = "";
            formular[9].className = "zeleno";
        } else {
            formular[9].className = "crveno";
            event.preventDefault();
        }
        //Kraj provjere drzave

        //Provjera telefona
        var telefon = document.getElementById("telefon");
        if (telefon.value.length !== 11) {
            ispis[10].innerHTML = "Telefon ima 11 znaemnaka plus praznina na 4. mjestu";
            izlazZaTel = false;
        } else {
            for (var i = 0; i < 3; i++) {
                if (isNaN(telefon.value[i])) {
                    ispis[8].innerHTML = "Dozvoljen je samo unos brojeva";
                    izlazZaTel = false;
                    break;
                }
            }
            if (telefon.value[3] !== "-") {
                ispis[10].innerHTML = "Poslije početna tri broja dolazi -";
                izlazZaTel = false;
            }
            for (var j = 4; j < 11; j++) {
                if (isNaN(telefon.value[j])) {
                    ispis[10].innerHTML = "Dozvoljen je samo unos brojeva";
                    izlazZaTel = false;
                    break;
                }
            }
        }
        if (izlazZaTel !== false) {
            ispis[10].innerHTML = "";
            formular[10].className = "zeleno";
        } else {
            formular[10].className = "crveno";
            event.preventDefault();
        }

        //Kraj provjera teleofona

        //Provejram emaila
        var email = document.getElementById("email");
        var brojacZaEt = 0;
        var Etpozicija = 0;
        var provjeraTocke = 0;
        var Tockapozicija = 0;
        for (var i = 0; i < email.value.length; i++) {
            if (email.value[i] === "@") {
                brojacZaEt++;
                Etpozicija = i;
            }
        }
        for (var j = Etpozicija; j < email.value.length; j++) {
            if (email.value[j] === ".") {
                provjeraTocke++;
                Tockapozicija = j;
            }
        }
        if (brojacZaEt !== 1) {
            ispis[11].innerHTML = "Email sadrzi samo jedan @ znak";
            izlazZaEmail = false;
        }

        if (provjeraTocke !== 1) {
            ispis[11].innerHTML = "Postoji samo jedna tocka poslije znaka @";
            izlazZaEmail = false;
        }
        if (email.value[Etpozicija] + 1 < email.value[Tockapozicija]) {
            ispis[11].innerHTML = "Tocka ne moze uslijediti odmah poslihe @";
            izlazZaEmail = false;
        }
        if (email.value.length === 0) {
            ispis[11].innerHTML = "Email morate obavezno unijeti";
            izlazZaEmail = false;
        }

        if (izlazZaEmail !== false) {
            ispis[11].innerHTML = "";
            formular[11].className = "zeleno";
        } else {
            formular[11].className = "crveno";
            event.preventDefault();
        }
        //Kraj provjere emaila


    }, false);

}

