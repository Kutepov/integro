$(document).ready(function() {
  
  $(document).ajaxSend(function(event, request, settings) {
    $('#loading-indicator').show();
    $('#loading-indicator').css('display','flex');
  });
  $(document).ajaxComplete(function(event, request, settings) {
    $('#loading-indicator').hide();
  });
});

$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {  $('#loading-indicator').hide(); }
});