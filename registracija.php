<?php
include 'baza_class.php';
$ime = filter_input(INPUT_POST, 'ime');
$prezime = filter_input(INPUT_POST, 'prezime');
$korime = filter_input(INPUT_POST, 'korime');
$pass1 = filter_input(INPUT_POST, 'lozinka');
$pass2 = filter_input(INPUT_POST, 'potvrda_lozinke');
$dan = filter_input(INPUT_POST, 'dan');
$mjesec = filter_input(INPUT_POST, 'mjesec');
$godina = filter_input(INPUT_POST, 'godina');
$tel = filter_input(INPUT_POST, 'telefon');
$email = filter_input(INPUT_POST, 'email');
$spol = filter_input(INPUT_POST, 'spol');
$drzava = filter_input(INPUT_POST, 'drzava');
$baza = new Baza();
$baza->spojiDB();
$errorMessage = "";
$broj = $brojPZnakova = $brojPass = $BrojMalih = $BrojVelikih = $brojBroj = $brojacPogodaka = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Petlje
    for ($i = 0; $i < strlen($korime); $i++) {
        if ($korime[$i] >= 'A' && $korime[$i] <= 'Z') {
            $broj++;
        }
        if ($korime[$i] == '!' || $korime[$i] == '?' || $korime[$i] == '$' || $korime[$i] == '#' || $korime[$i] == '-' || $korime[$i] == '_') {
            $brojPZnakova++;
        }
    }

    for ($i = 0; $i < strlen($pass1); $i++) {
        if ($pass1[$i] >= 'A' && $pass1[$i] <= 'Z') {
            $BrojVelikih++;
        }
        if ($pass1[$i] >= 'a' && $pass1[$i] <= 'z') {
            $BrojMalih++;
        }
        if ($pass1[$i] == '!' || $pass1[$i] == '?' || $pass1[$i] == '$' || $pass1[$i] == '#') {
            $brojPass++;
        }
        if (is_numeric($pass1[$i])) {
            $brojBroj++;
        }
    }

    for ($i = 0; $i < strlen($pass2); $i++) {
        if ($pass1[$i] === $pass2[$i]) {
            $brojacPogodaka++;
        }
    }
//Provjera imena
    if (empty($ime)) {
        $errorMessage .= "Treba unijeti ime" . '<br>';
    }

//Provjera prezimena
    if (empty($prezime)) {
        $errorMessage .= "Treba unijeti prezime" . '<br>';
    }

//Provjera korisničkog imena
    if (strlen($korime) < 10) {
        $errorMessage .= "Korisnicko ime moram imati najmanje 10 znakova" . '<br>';
    } elseif ($broj != 1) {
        $errorMessage .= "Korisničko ime mora imati točno jedno veliko slovo" . '<br>';
    } elseif ($brojPZnakova != 2) {
        $errorMessage .= "Korisničko ime mora imati točno dva posebna znaka (-,_,!,?,#,$)" . '<br>';
    } elseif ($korime[0] <= 'a' || $korime[0] >= 'z') {
        $errorMessage .= "Korisničko ime mora početi malim slovom" . '<br>';
    }

//Provjera lozinke
    if (strlen($pass1) < 8) {
        $errorMessage .= "Lozinka mora sadržavati 8 znakova" . '<br>';
    } elseif ($BrojMalih < 1) {
        $errorMessage .= "Lozinka mora sadržavati minimalno jedno malo slovo" . '<br>';
    } elseif ($BrojVelikih < 1) {
        $errorMessage .= "Lozinka mora sadržavati minimalno jedno veliko slovo" . '<br>';
    } elseif ($brojPass < 1) {
        $errorMessage .= "Lozinka mora sadržavati minimalno jedan poseban znak(!,#,?,$)" . '<br>';
    } elseif ($brojBroj < 1) {
        $errorMessage .= "Lozinka mora sadržavati minimalno jedan broj" . '<br>';
    }

//Provjera potvrde lozinke
    if (empty($pass2)) {
        $errorMessage .= "Morate potvrditi lozinku" . '<br>';
    } elseif ($brojacPogodaka !== strlen($pass2)) {
        $errorMessage .= "Potvrdna lozinka se ne podudara sa lozinkom" . '<br>';
    }

//Provjera dana rođenja
    if (empty($dan)) {
        $errorMessage .= "Unesite dan rođenja" . '<br>';
    } elseif ($dan < 0 || $dan > 31) {
        $errorMessage .= "Dan mora biti u rasponu od 1 do 31" . '<br>';
    }

//Provjera mjeseca
    if (empty($mjesec)) {
        $errorMessage .= "Unesite mjesec rođenja" . '<br>';
    } elseif ($mjesec < 1 || $mjesec > 12) {
        $errorMessage .= "Mjesec mora biti u rasponu od 1 do 12(Siječanj-Prosinac)" . '<br>';
    }

//Provjera godina
    if (empty($godina)) {
        $errorMessage .= "Unesite godina rođenja" . '<br>';
    } elseif ($godina < 1930 || $godina > 2015) {
        $errorMessage .= "Godina mora biti u rasponu od 1930 do 2015" . '<br>';
    }

//Provjera telefona
    if (empty($tel)) {
        $errorMessage .= "Morate unijeti telefon" . '<br>';
    } elseif (!preg_match("/[0-9]{3}-[0-9]{7}/", $tel)) {
        $errorMessage .= "Format telefona mora biti xxx-xxxxxxx" . '<br>';
    }

//Provjera emaila
    if (empty($email)) {
        $errorMessage .= "Morate unijeti email" . '<br>';
    } elseif (!preg_match("/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/", $email)) {
        $errorMessage .= "Email mora biti tipa nesto@nesto.nesto" . '<br>';
    }

    if (empty($errorMessage)) {
        $sqlProvjeraEmail = "SELECT email FROM korisnik WHERE email = '$email'";
        $sqlProvjeraKorImena = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = '$korime'";
        $provjeraimena = $baza->selectDB($sqlProvjeraKorImena);
        $provjeraemila = $baza->selectDB($sqlProvjeraEmail);
        //Provjera zauzetosti korisničkog imena
        if ($provjeraimena->num_rows > 0) {
            $errorMessage .="Ovo korisničko ime je zauzeto" . "<br>";
        }

        //Provjera zauzetosti emaila
        if ($provjeraemila->num_rows > 0) {
          $errorMessage .= "Ovaj email je zauzeti" . "<br>";
          } 

         if (empty($errorMessage)) {
          //Salje aktivacijski kod na mail
          $podatakzahash = '' . date('m.d.Y. h:i:s a', time()) . $korime;
          $napraviHash = hash('ripemd160', $podatakzahash);

          $mail_to = $email;
          $mail_from = "From: Knjiznica";
          $mail_subject = "Aktivacijski kod";
          $mail_body = "http://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x045/aktivacija.php?aktkod="."$napraviHash";

          if (mail($mail_to, $mail_subject, $mail_body, $mail_from)) {
          echo("Poslana poruka za: '$mail_to'!");
          } else {
          echo("Problem kod poruke za: '$mail_to'!");
          }

          $vrijeme = date('Y-m-d H:i:s',time());
          //Upis podataka u bazu
          $sqlUpis = "INSERT INTO korisnik(id_korisnik,ime,prezime,korisnicko_ime,lozinka,potvrda_lozinke,dan,mjesec,godina,spol,drzava,telefon,email,datum_vrijeme,aktivacijski,status,blokiran,id_tip)"
          . "VALUES(DEFAULT, '$ime','$prezime','$korime','$pass1','$pass2','$dan','$mjesec','$godina','$spol','$drzava','$tel','$email','$vrijeme','$napraviHash',DEFAULT,DEFAULT,DEFAULT)";
          $baza->updateDB($sqlUpis);
          header("Location:index.php");
          } 
    }
}
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="Matija Lazar">
            <meta name="keywords" content="FOI, WebDiP"> 
            <link href ="css/matlazar.css" rel ="stylesheet" type="text/css">
            <link href="css/matlazar_responsive.css" rel="stylesheet" type="text/css">
            <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
            <script type="text/javascript" src ="js/ajax.js"></script>
            <script type="text/javascript" src ="js/matlazar.js"></script>

            <title>Knjižnica</title>
        </head>
        <body onload="ProvjeraRegistracije()">
            <header>
                <h1>Knjižnica</h1>
                <span id="name_status" style="color: white"></span>
            </header>
            <div id = "navigacija">
                <nav>
                    <label for="show-menu" class="show-menu">☰ Izbornik</label>
                    <input type="checkbox" id="show-menu" role="button">
                    <ul id="menu">
                        <li><a href="index.php">Početna</a></li>
                        <li><a href = "dokumentacija.html">Dokumentacija</a></li>
                        <li><a href = "o_autoru.html" >O autoru</a></li>
                        <li  style="float:right"><a class="active" href ="registracija.php">Registracija</a></li>

                    </ul>
                </nav>
            </div>
            <div class="glavnasekcija">
                <section>
                    <div class="registracija">
                        <form id="form2" method="post" name="form2" onsubmit="ProvjeraRegistracije()"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate="novalidate" >
                        <h4 class = "h4">Registracija</h4>
                        <label for="ime" class="labeleRegistracija">Ime: </label>
                        <input type="text" id="ime" class="unosRegistracija" name="ime"  placeholder="Ime" ><div class ="pogreska"></div><br><br>
                        <label for="prezime" class="labeleRegistracija">Prezime: </label>
                        <input type="text" id="prezime" class="unosRegistracija"   name="prezime" placeholder="Prezime"><div class ="pogreska"></div><br><br>
                        <label for="korime" class="labeleRegistracija">Korisničko ime: </label>
                        <input type="text" id="korime" class="unosRegistracija"   name="korime" placeholder="Korisničko ime"><div id="status" class ="pogreska"></div><br><br>
                        <label for="lozinka" class="labeleRegistracija">Lozinka: </label>
                        <input type="password" id="lozinka" class="unosRegistracija"  name="lozinka" placeholder="Lozinka"><div class ="pogreska"></div><br><br>
                        <label for="potvrda_lozinke" class="labeleRegistracija">Potvrdi lozinku: </label>
                        <input type="password" id="potvrda_lozinke" class="unosRegistracija" name="potvrda_lozinke" placeholder="Potvrda lozinke"><div class ="pogreska"></div><br><br>
                        <label for="dan" class="labeleRegistracija">Dan rođenja: </label>
                        <input type="number" id="dan" name="dan" class="unosRegistracija" placeholder="Dan rođenja"><div class ="pogreska"></div><br><br>
                        <label class="labeleRegistracija">Mjesec rođenja: </label>
                        <select name="mjesec" id ="mjesec" class="unosRegistracija">
                            <option value="0">Mjesec</option>
                            <option value="1">Siječanj</option>
                            <option value="2">Veljača</option>
                            <option value="3">Ožujak</option>
                            <option value="4">Travanj</option>
                            <option value="5">Svibanj</option>
                            <option value="6">Lipanj</option>
                            <option value="7">Srpanj</option>
                            <option value="8">Kolovoz</option>
                            <option value="9">Rujan</option> 
                            <option value="10">Listopad</option> 
                            <option value="11">Studeni</option>
                            <option value="12">Prosinac</option> 
                        </select><div class ="pogreska"></div><br><br>
                        <label for="godina" class="labeleRegistracija">Godina rođenja: </label>
                        <input type="number" id = "godina" name="godina" class ="unosRegistracija" value="1970"><div class ="pogreska"></div><br><br>
                        <label class="labeleRegistracija">Spol: </label>
                        <select class = "unosRegistracija" id="spol" style = "width: 5%;" name = "spol">
                            <option value ='0'>Spol</option>
                            <option value="Ž">Ž</option>
                            <option value="M">M</option>
                        </select><div class ="pogreska"></div><br><br>
                        <label for ="drzava" class="labeleRegistracija">Država: </label>
                        <select name="drzava" id="drzava" class="unosRegistracija">
                            <option value="">Država</option>
                            <option value="Afganistan">Afghanistan</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Armenia">Armenia</option>
                            <option value="Aruba">Aruba</option>
                            <option value="Australia">Australia</option>
                            <option value="Austria">Austria</option>
                            <option value="Azerbaijan">Azerbaijan</option>
                            <option value="Bahamas">Bahamas</option>
                            <option value="Bahrain">Bahrain</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Barbados">Barbados</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Belgium">Belgium</option>
                            <option value="Belize">Belize</option>
                            <option value="Benin">Benin</option>
                            <option value="Bermuda">Bermuda</option>
                            <option value="Bhutan">Bhutan</option>
                            <option value="Bolivia">Bolivia</option>
                            <option value="Bonaire">Bonaire</option>
                            <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
                            <option value="Botswana">Botswana</option>
                            <option value="Brazil">Brazil</option>
                            <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                            <option value="Brunei">Brunei</option>
                            <option value="Bulgaria">Bulgaria</option>
                            <option value="Burkina Faso">Burkina Faso</option>
                            <option value="Burundi">Burundi</option>
                            <option value="Cambodia">Cambodia</option>
                            <option value="Cameroon">Cameroon</option>
                            <option value="Canada">Canada</option>
                            <option value="Canary Islands">Canary Islands</option>
                            <option value="Cape Verde">Cape Verde</option>
                            <option value="Cayman Islands">Cayman Islands</option>
                            <option value="Central African Republic">Central African Republic</option>
                            <option value="Chad">Chad</option>
                            <option value="Channel Islands">Channel Islands</option>
                            <option value="Chile">Chile</option>
                            <option value="China">China</option>
                            <option value="Christmas Island">Christmas Island</option>
                            <option value="Cocos Island">Cocos Island</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Comoros">Comoros</option>
                            <option value="Congo">Congo</option>
                            <option value="Cook Islands">Cook Islands</option>
                            <option value="Costa Rica">Costa Rica</option>
                            <option value="Cote DIvoire">Cote D'Ivoire</option>
                            <option value="Croatia">Croatia</option>
                            <option value="Cuba">Cuba</option>
                            <option value="Curaco">Curacao</option>
                            <option value="Cyprus">Cyprus</option>
                            <option value="Czech Republic">Czech Republic</option>
                            <option value="Denmark">Denmark</option>
                            <option value="Djibouti">Djibouti</option>
                            <option value="Dominica">Dominica</option>
                            <option value="Dominican Republic">Dominican Republic</option>
                            <option value="East Timor">East Timor</option>
                            <option value="Ecuador">Ecuador</option>
                            <option value="Egypt">Egypt</option>
                            <option value="El Salvador">El Salvador</option>
                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                            <option value="Eritrea">Eritrea</option>
                            <option value="Estonia">Estonia</option>
                            <option value="Ethiopia">Ethiopia</option>
                            <option value="Falkland Islands">Falkland Islands</option>
                            <option value="Faroe Islands">Faroe Islands</option>
                            <option value="Fiji">Fiji</option>
                            <option value="Finland">Finland</option>
                            <option value="France">France</option>
                            <option value="French Guiana">French Guiana</option>
                            <option value="French Polynesia">French Polynesia</option>
                            <option value="French Southern Ter">French Southern Ter</option>
                            <option value="Gabon">Gabon</option>
                            <option value="Gambia">Gambia</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Germany">Germany</option>
                            <option value="Ghana">Ghana</option>
                            <option value="Gibraltar">Gibraltar</option>
                            <option value="Great Britain">Great Britain</option>
                            <option value="Greece">Greece</option>
                            <option value="Greenland">Greenland</option>
                            <option value="Grenada">Grenada</option>
                            <option value="Guadeloupe">Guadeloupe</option>
                            <option value="Guam">Guam</option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="Guinea">Guinea</option>
                            <option value="Guyana">Guyana</option>
                            <option value="Haiti">Haiti</option>
                            <option value="Hawaii">Hawaii</option>
                            <option value="Honduras">Honduras</option>
                            <option value="Hong Kong">Hong Kong</option>
                            <option value="Hungary">Hungary</option>
                            <option value="Iceland">Iceland</option>
                            <option value="India">India</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="Iran">Iran</option>
                            <option value="Iraq">Iraq</option>
                            <option value="Ireland">Ireland</option>
                            <option value="Isle of Man">Isle of Man</option>
                            <option value="Israel">Israel</option>
                            <option value="Italy">Italy</option>
                            <option value="Jamaica">Jamaica</option>
                            <option value="Japan">Japan</option>
                            <option value="Jordan">Jordan</option>
                            <option value="Kazakhstan">Kazakhstan</option>
                            <option value="Kenya">Kenya</option>
                            <option value="Kiribati">Kiribati</option>
                            <option value="Korea North">Korea North</option>
                            <option value="Korea Sout">Korea South</option>
                            <option value="Kuwait">Kuwait</option>
                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                            <option value="Laos">Laos</option>
                            <option value="Latvia">Latvia</option>
                            <option value="Lebanon">Lebanon</option>
                            <option value="Lesotho">Lesotho</option>
                            <option value="Liberia">Liberia</option>
                            <option value="Libya">Libya</option>
                            <option value="Liechtenstein">Liechtenstein</option>
                            <option value="Lithuania">Lithuania</option>
                            <option value="Luxembourg">Luxembourg</option>
                            <option value="Macau">Macau</option>
                            <option value="Macedonia">Macedonia</option>
                            <option value="Madagascar">Madagascar</option>
                            <option value="Malaysia">Malaysia</option>
                            <option value="Malawi">Malawi</option>
                            <option value="Maldives">Maldives</option>
                            <option value="Mali">Mali</option>
                            <option value="Malta">Malta</option>
                            <option value="Marshall Islands">Marshall Islands</option>
                            <option value="Martinique">Martinique</option>
                            <option value="Mauritania">Mauritania</option>
                            <option value="Mauritius">Mauritius</option>
                            <option value="Mayotte">Mayotte</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Midway Islands">Midway Islands</option>
                            <option value="Moldova">Moldova</option>
                            <option value="Monaco">Monaco</option>
                            <option value="Mongolia">Mongolia</option>
                            <option value="Montserrat">Montserrat</option>
                            <option value="Morocco">Morocco</option>
                            <option value="Mozambique">Mozambique</option>
                            <option value="Myanmar">Myanmar</option>
                            <option value="Nambia">Nambia</option>
                            <option value="Nauru">Nauru</option>
                            <option value="Nepal">Nepal</option>
                            <option value="Netherland Antilles">Netherland Antilles</option>
                            <option value="Netherlands">Netherlands (Holland, Europe)</option>
                            <option value="Nevis">Nevis</option>
                            <option value="New Caledonia">New Caledonia</option>
                            <option value="New Zealand">New Zealand</option>
                            <option value="Nicaragua">Nicaragua</option>
                            <option value="Niger">Niger</option>
                            <option value="Nigeria">Nigeria</option>
                            <option value="Niue">Niue</option>
                            <option value="Norfolk Island">Norfolk Island</option>
                            <option value="Norway">Norway</option>
                            <option value="Oman">Oman</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="Palau Island">Palau Island</option>
                            <option value="Palestine">Palestine</option>
                            <option value="Panama">Panama</option>
                            <option value="Papua New Guinea">Papua New Guinea</option>
                            <option value="Paraguay">Paraguay</option>
                            <option value="Peru">Peru</option>
                            <option value="Phillipines">Philippines</option>
                            <option value="Pitcairn Island">Pitcairn Island</option>
                            <option value="Poland">Poland</option>
                            <option value="Portugal">Portugal</option>
                            <option value="Puerto Rico">Puerto Rico</option>
                            <option value="Qatar">Qatar</option>
                            <option value="Republic of Montenegro">Republic of Montenegro</option>
                            <option value="Republic of Serbia">Republic of Serbia</option>
                            <option value="Reunion">Reunion</option>
                            <option value="Romania">Romania</option>
                            <option value="Russia">Russia</option>
                            <option value="Rwanda">Rwanda</option>
                            <option value="St Barthelemy">St Barthelemy</option>
                            <option value="St Eustatius">St Eustatius</option>
                            <option value="St Helena">St Helena</option>
                            <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                            <option value="St Lucia">St Lucia</option>
                            <option value="St Maarten">St Maarten</option>
                            <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
                            <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
                            <option value="Saipan">Saipan</option>
                            <option value="Samoa">Samoa</option>
                            <option value="Samoa American">Samoa American</option>
                            <option value="San Marino">San Marino</option>
                            <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                            <option value="Saudi Arabia">Saudi Arabia</option>
                            <option value="Senegal">Senegal</option>
                            <option value="Serbia">Serbia</option>
                            <option value="Seychelles">Seychelles</option>
                            <option value="Sierra Leone">Sierra Leone</option>
                            <option value="Singapore">Singapore</option>
                            <option value="Slovakia">Slovakia</option>
                            <option value="Slovenia">Slovenia</option>
                            <option value="Solomon Islands">Solomon Islands</option>
                            <option value="Somalia">Somalia</option>
                            <option value="South Africa">South Africa</option>
                            <option value="Spain">Spain</option>
                            <option value="Sri Lanka">Sri Lanka</option>
                            <option value="Sudan">Sudan</option>
                            <option value="Suriname">Suriname</option>
                            <option value="Swaziland">Swaziland</option>
                            <option value="Sweden">Sweden</option>
                            <option value="Switzerland">Switzerland</option>
                            <option value="Syria">Syria</option>
                            <option value="Tahiti">Tahiti</option>
                            <option value="Taiwan">Taiwan</option>
                            <option value="Tajikistan">Tajikistan</option>
                            <option value="Tanzania">Tanzania</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Togo">Togo</option>
                            <option value="Tokelau">Tokelau</option>
                            <option value="Tonga">Tonga</option>
                            <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                            <option value="Tunisia">Tunisia</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Turkmenistan">Turkmenistan</option>
                            <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                            <option value="Tuvalu">Tuvalu</option>
                            <option value="Uganda">Uganda</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Erimates">United Arab Emirates</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="United States of America">United States of America</option>
                            <option value="Uraguay">Uruguay</option>
                            <option value="Uzbekistan">Uzbekistan</option>
                            <option value="Vanuatu">Vanuatu</option>
                            <option value="Vatican City State">Vatican City State</option>
                            <option value="Venezuela">Venezuela</option>
                            <option value="Vietnam">Vietnam</option>
                            <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                            <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                            <option value="Wake Island">Wake Island</option>
                            <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
                            <option value="Yemen">Yemen</option>
                            <option value="Zaire">Zaire</option>
                            <option value="Zambia">Zambia</option>
                            <option value="Zimbabwe">Zimbabwe</option>
                        </select><div class ="pogreska"></div><br><br>
                        <label for="telefon" class="labeleRegistracija">Telefon: </label>
                        <input type="tel" id="telefon" name="telefon" placeholder="09x-xxxxxxx" class = "unosRegistracija"><div class ="pogreska"></div><br><br>
                        <label for="email" class="labeleRegistracija">Email adresa: </label>
                        <input type="email" id="email" name="email"  placeholder="ime.prezime@posluzitelj.xxx" class ="unosRegistracija"><div id="status2" class ="pogreska"></div><br><br>
                        <div class="g-recaptcha" data-sitekey="6LevrCETAAAAALUrKPs8OdniD1TMapYa-3O0nZVt" ></div><br><br>
                        <input id="submit1" type="submit" value=" Registriraj se "><br><br><br>
                        <input id="reset1" type="reset" value=" Resetiraj prijavu ">     
                    </form>
                </div>
            </section>
        </div>
        <div class="footer">
            <footer>

            </footer>
        </div>
    </body>
</html>
