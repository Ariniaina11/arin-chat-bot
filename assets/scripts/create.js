$(document).ready(function(){
    let create_btn = $('#creation');
    let pseudo = $('#pseudo');
    let password = $('#password');
    let conf_password = $('#conf_password');

    
    // Clique sur create
    create_btn.on('click', function () {
        let data = {
            'creation' : true,
            'pseudo' : pseudo.val(),
            'password' : password.val(),
            'conf_password' : conf_password.val()
        };

        $.ajax({
            url : 'utils/checking/create.php',
            type : 'POST',
            data : data,
            success : function(result){
                console.log(result);
                switch (result) {
                    case 'success':
                        openPopup("Account created successfully !", true);
                        break;
                    case 'pseudo_err':
                        openPopup('Pseudo already exist !');
                        break;
                    case 'conf_pass_err':
                        openPopup('Password doesn\'t match !');
                        break;
                    case 'empty':
                        openPopup('Sorry ! You can\'t use this pseudo.');
                        break;
                
                    default:
                        openPopup('Sorry ! You can\'t use this pseudo.');
                        break;
                }
            },
            error : function(result) {
                alert('Error ' + result.message);
            }
        });
    });

    // ============================ POPUP ============================ //
    let box = $('.box');
    let popup = $('#popup');
    let popup_text = $('#popup-text');
    let ok_btn = $('#ok-btn');
    let ok_success_btn = $('#ok-success-btn');

    // Clique sur 'OK'
    ok_btn.on('click', function(){
        closePopup();
    })

    // Clique sur 'OK - Success'
    ok_success_btn.on('click', function(){
        closePopup();
        window.location = '/arin-chat-bot/login.php'
    })

    // Clique en dehors du popup
    $('*').on('click', function(event){
        closePopup();
    })

    // Afficher le popup
    function openPopup(txt, success = false) {
        if(success){
            ok_success_btn.show();
            ok_btn.hide();
        }
        else {
            ok_btn.show();                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
            ok_success_btn.hide();
        }

        box.fadeTo(100, 0.3);
        popup_text.text(txt);
        popup.show();
    }
      
    // Fermer le popup
    function closePopup() {
        box.fadeTo(100, 1);
        popup.hide();
    }
});