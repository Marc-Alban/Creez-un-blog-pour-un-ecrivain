$(document).ready(function () {
  /**
   * Anime le menu de droite à gauche
   * lors du click sur le boutton menu
   */
  $(function () {
    $('.nav-controller').on('click', function (event) {
      $('.animate').toggleClass('focus');
    });
  })

});