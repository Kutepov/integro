//Подсветить взаимосвязанные этапы
$('.outer-circle').mouseover(function () {
    $('.outer-circle[data-step-id="'+$(this).data('winId')+'"]').css('background', 'green');
    $('.outer-circle[data-step-id="'+$(this).data('loseId')+'"]').css('background', 'red');
});

//Убрать подсветку взаимосвязанных этапов
$('.outer-circle').mouseout(function () {
    $('.outer-circle').removeAttr('style');
});

$('.outer-circle').click(function () {
    var stepId = $(this).data('stepId');

    $.ajax({
        type: 'GET',
        url: "/project-step/get-short-info",
        data: {id: stepId},
        async: false,
        success: function (data) {
            $('#modalHintBox').html(data);
        }
    });

    $('#modalHint').arcticmodal();
    $('.arcticmodal-container').offset({top:(event.clientY),left:event.clientX});

});
