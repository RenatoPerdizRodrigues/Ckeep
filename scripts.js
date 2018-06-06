document.addEventListener("DOMContentLoaded", function() {
  var hamburger = document.querySelector('.hamburger');
  var navigation = document.querySelector('.navigationDesktop');

  hamburger.addEventListener('click', function(e) {
    e.preventDefault;
    if(hamburger.classList.contains('isActive')) {
      hamburger.classList.remove('isActive');
      navigation.classList.remove('isOpen');
    }else {
      hamburger.classList.add('isActive');
      navigation.classList.add('isOpen');
    }
  });
});