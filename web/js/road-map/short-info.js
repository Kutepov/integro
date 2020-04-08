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