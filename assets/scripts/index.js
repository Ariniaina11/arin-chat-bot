$(document).ready(function(){
    let msg = $('#msg');
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
                        '<p>' + msg.val() + '</p>' +
                        '<img src="assets/images/user.png">' +
                    '</div>';

        msg.val('');
        conversation.append(value); // Ajouter le message sur la conversation
        scrollDown();

        waittingResponse();

        $.ajax({
            url : 'utils/checking/message.php',
            type : 'POST',
            data : data,
            success : function(result){
                if(result != ''){
                    // La réponse du bot
                    value = '<div class="talk left">' +
                                '<img src="assets/images/arin-bot.png">' +
                                '<p>' + result + '</p>' +
                                '<button type="button" class="listen">LISTEN</button>' +
                            '</div>'

                    conversation.append(value); // Ajouter la réponse sur la conversation
                    //

                    scrollDown();

                    // speak(result);

                    // 
                    $('.listen').on('click', function(){
                        let p = this.previousElementSibling;
                        speak(p.textContent)
                    })

                    responseReceived();
                }
                else{
                    responseReceived();
                    alert('Erreur de serveur !')
                }
                
            },
            error : function(result) {
                alert('Une érreur s\'est produite : ' + result['statusText']);
                console.log(result);
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
    }

    // Clique sur "Entrée"
    msg.keypress(function(event) {
        if (event.keyCode === 13 && !send_btn.prop('disabled')){
            event.preventDefault()
            send_btn.click();
        }
    });

    // Parler
    function speak(text) {
        const array = divideText(text)

        array.forEach(element => {
            let speech = new SpeechSynthesisUtterance(element);
            speechSynthesis.speak(speech);
        });

        console.log(array)
    }

    // Diviser le texte
    function divideText(text) {
        let array_divided = [];
        let array = text.split(" ")

        let str = array[0]; // Premier mot
        let punctuations = ".:!?"; // Qqs ponctuations (Il faut arrêter de dire à chaque ponctuation)
        let stack = true;
        for (let i = 1; i < array.length; i++) {
            let get_str = str + " " + array[i]
            let last_char = get_str.charAt(get_str.length - 1);

            if (get_str.length <= 210 && !punctuations.includes(last_char)){
                str = (str + " " + array[i]);
                stack = false;
            } else {
                array_divided.push(get_str);
                str = ""
                stack= true;
            }
        }

        if(!stack)
            array_divided.push(str);

        return array_divided;
    }

    // Scroll vers le bas
    function scrollDown() {
        let div = $('#conversation');

        div.scrollTop(div.prop("scrollHeight"));
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
        chat_global.fadeTo(400, 1);
        closePopup();
    })

    chat_global.on('click', function(){
        // alert('chat !');
    })

    // Afficher le popup
    function openPopup() {
        chat_global.fadeTo(400, 0.3);
        popup.show();
    }
      
    // Fermer le popup
    function closePopup() {
        popup.hide();
    }

});