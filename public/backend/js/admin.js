var element_column = document.querySelectorAll('.element_column');
var filter_button = document.querySelectorAll('#filter_button .btnbtn');
var search_item = document.getElementById('search_item');

Array.from(filter_button).forEach(function(element){
    element.addEventListener('click', function(event){
        for(let i=0; i<filter_button.length; i++){
            filter_button[i].classList.remove('active');
        }
        this.classList.add('active');


        // var name_filter = element.dataset.filter;

        // Array.from(element_column).forEach(function(ele){
        //     if(ele.dataset.item === name_filter || name_filter === 'all'){
        //         ele.style.display = 'flex';
        //     }
        //     else{
        //         ele.style.display = 'none';
        //     }
        // })
    })
    

   
})

function checkEmpty(element){
    let count = 0;
    for(let i=0; i<element.length; i++){
        if(element[i].style.display === 'flex'){
            count++;
        }
    }
    if(count === 0 ){
        document,querySelector('#showtext').textContent = 'không có sản phảm';
    }
    else{
        document,querySelector('#showtext').textContent = '';

    }
}

// tìm kiếm bằng giọng nói
    let recognition;
    let microphoneIcon;
    if ('webkitSpeechRecognition' in window) {
        recognition = new webkitSpeechRecognition();
        recognition.continuous = false;
        recognition.interimResults = false;
        recognition.lang = 'vi-VN';
        recognition.onstart = function() {
            microphoneIcon.classList.add('microphone-active');
        };
        recognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            document.querySelector('.header-with-search-input-discount').value = transcript;
            document.querySelector('.header-with-search-form').submit();
        };
        recognition.onerror = function(event) {
            console.error('Lỗi nhận dạng giọng nói:', event.error);
        };
        recognition.onend = function() {
            microphoneIcon.classList.remove('microphone-active');
        };
        function startRecognition() {
            recognition.start();
        }
    } else {
        console.error('Lỗi');
    }
    document.addEventListener('DOMContentLoaded', function() {
        microphoneIcon = document.getElementById('microphone-icon');
    });
