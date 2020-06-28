window.addEventListener('load', function(event) {
    document.getElementsByClassName('spinner-wrapper')[0].style.display = 'none';
 }, false);

window.onscroll = function() {
  scrollFunction();
};

function scrollFunction() {
  if (screen.width>768) {
      if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        document.getElementById("header").style.fontSize = "28px";
      } else {
        document.getElementById("header").style.fontSize = "35px";
      }
    } else {
      if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        document.getElementById("header").style.fontSize = "20px";
      } else {
        document.getElementById("header").style.fontSize = "25px";
      }
    }
}

//


window.onpageshow = function(event) {
    if($('#want15').is(':checked')) {
      $('#notice15').show();
      $('#course15').show();
  }
  else {
      $('#notice15').hide();
      $('#course15').hide();
  }
}

/*
$(function(){
    $('#want12').prop("checked", false);
});
*/
