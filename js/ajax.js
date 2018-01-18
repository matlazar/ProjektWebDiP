$(document).ready(function (){
    $("#korime").focusout(function () {
        var korisnickoIme = $("#korime").val();
        $.ajax({
            type: 'post',
            url: 'korime_mail_provjera.php',
            data: {
                "korisnik": korisnickoIme
            },
            success: function (reakcija) {
                if (reakcija == 0) {
                    $("#status").html("*Korisinčko ime je zauzeto");
                } else {
                    $("#status").html("");
                }
            }
        });
    });
    
    $("#email").focusout(function () {
        var email = $("#email").val();
        $.ajax({
            type: 'post',
            url: 'korime_mail_provjera.php',
            data: {
                "email": email
            },
            success: function (reakcija) {
                if (reakcija == 0) {
                    $("#status2").html("*Email je zauzeti");
                } else {
                    $("#status2").html("");
                }
            }
        });
    });
    
    $("#moderator").click(function(){
        var korisninik = $("#cmbBox1").val();
        $.ajax({
            type: 'post',
            url: 'blokiraj.php',
            data:{
                "id":korisninik
            },
            success: function () {
                location.reload();
            }
            
        });
    });
    
    $("#korisnik").click(function(){
        var korisnik2 = $("#cmbBox2").val();
        $.ajax({
            type: 'post',
            url: 'blokiraj.php',
            data: {
                "odblokiraj":korisnik2
            },
            success: function () {
                location.reload();
            }
        });
    });
    
});