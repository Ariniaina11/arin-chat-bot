$(document).ready(function(){
    let msg = $('#msg');
    let vocal_hidden = $('#vocalHidden')
    let send_btn = $('#send-btn');
    let conversation = $('#conversation')
    let loading = $('.loading')

    init();

    // Clique sur le bouton "send"
    send_btn.on('click', function(){
        let data = {
            'msg' : msg.val()
        };

        // Message de l'utilisateur
        let value = '<div class="talk right" style="justify-content: flex-end;">' +
                        '<p>' + htmlEntities(msg.val()) + '</p>' +
                        '<img src="assets/images/user.png">' +
                    '</div>';

        msg.val('');
        conversation.append(value); // Ajouter le message sur la conversation
        scrollDown();

        waittingResponse();

        $.ajax({
            url : 'utils/checking/message.php',
            type : 'POST',
            dataType: 'json',
            data : data,
            success : function(result){
                if(result.response != ''){
                    // La réponse du bot
                    value = '<div class="talk left">' +
                                '<img src="assets/images/arin-bot.png">' +
                                '<p>' + result.response + '</p>' +
                            '</div>'

                    conversation.append(value); // Ajouter la réponse sur la conversation
                    //

                    scrollDown();

                    // Vocal
                    if(vocal_hidden.val() == '1'){
                        let lang_codes = Object.keys(result.lang)
                        let high_probability = lang_codes[0];
                        speak(result.response, high_probability);
                    }

                    responseReceived();
                }
                else{
                    responseReceived();
                    openPopupError("Erreur de serveur !")
                }
            },
            error : function(result) {
                responseReceived();
                openPopupError('Une érreur s\'est produite : ' + result['statusText']);
            }
        });
    });

    // ====================== FUNCTIONS ======================

    // Initialisation
    function init() {
        scrollDown();
        loading.hide();
    }

    // Attendre la réponse du bot
    function waittingResponse() {
        send_btn.prop('disabled', true);
        msg.prop('disabled', true);
        loading.show();
    }

    // Une réponse réçue
    function responseReceived() {
        send_btn.prop('disabled', false);
        msg.prop('disabled', false);
        loading.hide();
        vocal_hidden.val('0');
    }

    // Clique sur "Entrée"
    msg.keypress(function(event) {
        if (event.keyCode === 13 && !send_btn.prop('disabled')){
            event.preventDefault()
            send_btn.click();
        }
    });

    // Parler
    function speak(text, lang) {
        let speech = new SpeechSynthesisUtterance(text);
        speech.lang = lang;
        speechSynthesis.speak(speech);
    }

    // Scroll vers le bas
    function scrollDown() {
        let div = $('#conversation');

        div.scrollTop(div.prop("scrollHeight"));
    }

    // Pour formatter le texte de l'utilisateur
    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
    }

    // ====================================== LOGOUT ======================================

    let logout = $('#logout');
    let popup = $('#popup');
    let chat_global = $('.chat-global');
    let yes_btn = $('#yes-btn');
    let no_btn = $('#no-btn');

    // Clique sur 'Logout'
    logout.on('click', function(){
        openPopup();
    });

    // Clique sur 'Yes'
    yes_btn.on('click', function(){
        let data = {
            'logout' : true
        };

        $.ajax({
            url : 'utils/checking/logout.php',
            type : 'POST',
            data : data,
            success : function(result){
                window.location = result;
            },
            error : function(result){
                alert('Error : ' + result);
            }
        })
    })

    // Clique sur 'No'
    no_btn.on('click', function () {
        closePopup();
    })

    // Afficher le popup
    function openPopup() {
        chat_global.fadeTo(400, 0.3);
        popup.show();
    }
      
    // Fermer le popup
    function closePopup() {
        chat_global.fadeTo(400, 1);
        popup.hide();
    }

    // ================================= API - CHOICE =================================
    let apiBtn = $('.api-choice');
    let popup_infos = $('#popup-infos');
    let okBtn = $('#ok-btn');

    apiBtn.on('click', function(){
        openPopupInfos()
    })

    okBtn.on('click', function(){
        closePopupInfos();
    })

     // Afficher le popup-infos
     function openPopupInfos() {
        chat_global.fadeTo(400, 0.3);
        popup_infos.show();
    }
      
    // Fermer le popup-infos
    function closePopupInfos() {
        chat_global.fadeTo(400, 1);
        popup_infos.hide();
    }

    // ================================= ERROR - POPUP =================================
    let popup_error = $('#popup-error');
    let popup_error_text = $('#popup-error-text');
    let okErrBtn = $('#ok-error-btn');

    okErrBtn.on('click', function(){
        closePopupError();
    })

     // Afficher le popup-error
     function openPopupError(errText) {
        chat_global.fadeTo(400, 0.3)
        popup_error_text.text(errText)
        popup_error.show()
    }
      
    // Fermer le popup-error
    function closePopupError() {
        chat_global.fadeTo(400, 1)
        popup_error.hide()
    }
});