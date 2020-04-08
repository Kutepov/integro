//Подсветить взаимосвязанные этапы
$('.outer-circle').mouseover(function () {
    $('.outer-circle[data-step-id="'+$(this).data('winId')+'"]').css('background', 'green');
    $('.outer-circle[data-step-id="'+$(this).data('loseId')+'"]').css('background', 'red');
});

//Убрать подсветку взаимосвязанных этапов
$('.outer-circle').mouseout(function () {
    $('.outer-circle').removeAttr('style');
});
