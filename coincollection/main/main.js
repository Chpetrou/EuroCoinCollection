$(function() {
    getCoinCollection();
});

function getCoinCollection() {
    $.get( "getCoinDetails.php", function( data ) {
        // var data = data.substring(1);
            var coinarray = JSON.parse(data);

             $('input[type="text"]').each(function(){
                 for (var i = 0; i < coinarray.length; i++) {
                     var id = $(this).attr('id');
                     if (id == coinarray[i]['coinid']) {
                         $(this).val(coinarray[i]['year']);
                         $("input[type='checkbox'][id=" + id + "]").prop( "checked", true );
                     }
                 }
             });
    });
}

function saveCoinSelection(checkbox) {
    var id = $(checkbox).attr('id');
    var textfield = $("input[type=text][id=" + id + "]");
    if(checkbox.checked) {
        if (textfield.val().length === 0) {
            checkbox.checked = false;
            alert("You must fill the textbox");
        }
        else {
            $.post('saveCoinData.php', { date: textfield.val(), coinid: id }, function(result) {
                alert(result);
            });
        }
    }
    else {
        $.post('deleteCoinData.php', { coinid: id }, function(result) {
            alert(result);
        });
    }
}

function login() {
    var email = $("#email_field");
    var password = $("#password_field");

    $.post('login.php', { email: email.val(), password: password.val() }, function(result) {
        window.location.href = "home.php";
        alert("You are logged in!");
    });
}

function logout() {
    $.post('logout.php');
    window.location.href = "index.php";
    alert("You are logged out!");
}
