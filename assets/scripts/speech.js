$(document).ready(function(){
    let inputMsg = $("#msg")
    let vocal_hidden = $('#vocalHidden')
    let vocal_btn = $('#vocal-btn')
    let send_btn = $('#send-btn');
    let loading = $('.loading')
    let msg = $('#msg');

    let SpeechRecognition =
        window.SpeechRecognition || window.webkitSpeechRecognition,
    recognition,
    recording = false;

    // Toutes les langues (languages.js)
    function populateLanguages() {
        languages.forEach((lang) => {
            console.log(lang.code + " : " + lang.name)
        });
    }

    // 
    function speechToText() {
        try {
            console.log('Recording...')

            recognition = new SpeechRecognition();
            recognition.lang = 'en';
            recognition.interimResults = true;
            recognition.start();
            
            recognition.onresult = (event) => {
                const speechResult = event.results[0][0].transcript;
                //detect when intrim results
                if (event.results[0].isFinal) {
                    // result.innerHTML += " " + speechResult;
                    // inputMsg.val(speechResult)
                    inputMsg.val(speechResult)

                    send_btn.click();
                    stopRecording();
                } else {
                    waittingResponse();
                    inputMsg.val(speechResult)
                }
            };

            recognition.onspeechend = () => {
                speechToText();
            };

            recognition.onerror = (event) => {
                stopRecording();
                if (event.error === "no-speech") {
                    console.log("No speech was detected. Stopping...");
                } else if (event.error === "audio-capture") {
                    console.log(
                    "No microphone was found. Ensure that a microphone is installed."
                    );
                } else if (event.error === "not-allowed") {
                    console.log("Permission to use microphone is blocked.");
                } else if (event.error === "aborted") {
                    console.log("Listening Stopped.");
                } else {
                    console.log("Error occurred in recognition: " + event.error);
                }
            };
        } catch (error) {
            recording = false;

            console.log(error);
        }
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

    // Stopper l'enregistrement
    function stopRecording() {
        recognition.stop();
        recording = false;

        responseReceived();
    }

    // Clique sur vocal
    vocal_btn.on('click', function () {
        vocal_hidden.val('1');

        if (!recording) {
            waittingResponse();
            speechToText();
            recording = true;
        } else {
            stopRecording();
        }
    })
})