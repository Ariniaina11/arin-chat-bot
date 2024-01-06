$(document).ready(function(){
    let login_btn = $('#connexion');
    let pseudo = $('#pseudo');
    let password = $('#password');

    // Clique sur connexion
    login_btn.on('click', function () {
        let data = {
            'connexion' : true,
            'pseudo' : pseudo.val(),
            'password' : password.val()
        };

        $.ajax({
            url : 'utils/checking/login.php',
            type : 'POST',
            data : data,
            success : function(result){
                if(result == "success"){
                    window.location = "/arin-chat-bot/"
                    // alert('Success !');
                }
                else{
                    // alert('Authentification failed !');
                    openPopup('Authentification failed !');
                }
            },
            error : function(result) {
                alert('Error ' + result.message);
            }

        });
    });

    // Clique sur 'Entrée'
    pseudo.keypress(function(event) {
        if (event.keyCode === 13)
            login_btn.click();
    });

    password.keypress(function(event) {
        if (event.keyCode === 13)
            login_btn.click();
    });

    // ============================ POPUP ============================ //
    let box = $('.box');
    let popup = $('#popup');
    let popup_text = $('#popup-text');
    let ok_btn = $('#ok-btn');

    // Clique sur 'OK'
    ok_btn.on('click', function(){
        closePopup();
    })

    // Clique en dehors du popup
    $('body').on('click', function(event){
        // alert('Body !' + event.target);
        if(
            event.target.id != "ok-btn" &&
            event.target.id != "popup" &&
            event.target.id != "popup-text"
        ){
            closePopup();
        }
    })

    // Afficher le popup
    function openPopup(txt) {
        box.fadeTo(400, 0.3);
        popup_text.text(txt);
        popup.show();
    }
      
    // Fermer le popup
    function closePopup() {
        box.fadeTo(400, 1);
        popup.hide();
    }

});