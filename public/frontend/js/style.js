
var element_columns = document.querySelectorAll('.element_columns');
var filter_button = document.querySelectorAll('#filter_button .btnbtn');


Array.from(filter_button).forEach(function(element){
    element.addEventListener('click', function(event){
        for(let i=0; i<filter_button.length; i++){
            filter_button[i].classList.remove('actives');
        }
        this.classList.add('actives');


        var name_filter = element.dataset.filter;

        Array.from(element_columns).forEach(function(ele){
            if(ele.dataset.item === name_filter || name_filter === 'all'){
                ele.style.display = 'flex';
            }
            else{
                ele.style.display = 'none';
            }
        })
    })
})

var cardHeaders = document.querySelectorAll('.card-header-name-change');
    window.addEventListener('scroll', function() {
        var windowHeight = window.innerHeight;
        cardHeaders.forEach(function(cardHeader) {
        var elementPosition = cardHeader.getBoundingClientRect().top;
            if (elementPosition < windowHeight) {
                cardHeader.style.transform = 'rotate(360deg)';
            }
        });
});


// hiệu ứng hướng dẫn
var supportItems = document.querySelectorAll('.support-oder-product-list');
var currentIndex = 0;
function showNextItem() {
    if (currentIndex < supportItems.length) {
        supportItems[currentIndex].classList.add('animate');
        currentIndex++;
        setTimeout(showNextItem, 500);
    }
}
function animateSupportItems() {
    var windowHeight = window.innerHeight;
    var supportPosition = document.querySelector('.support-oder-product').getBoundingClientRect().top;
  
    if (supportPosition < windowHeight) {
        showNextItem();
        window.removeEventListener('scroll', animateSupportItems);
    }
}
window.addEventListener('scroll', animateSupportItems);


// hiệu ứng footer
var footerItems = document.querySelectorAll('.home-row-column-footer');
    var currentIndexs = 0;
    function showNextItems() {
        if (currentIndexs < footerItems.length) {
            footerItems[currentIndexs].classList.add('animates');
            currentIndexs++;
            setTimeout(showNextItems, 500);
        }
    }
    function animatefooterItems() {
        var windowHeight = window.innerHeight;
        var footerPosition = document.querySelector('.grid-row-footer').getBoundingClientRect().top;
        if (footerPosition < windowHeight) {
            showNextItems();
            window.removeEventListener('scroll', animatefooterItems);
        }
    }
window.addEventListener('scroll', animatefooterItems);
