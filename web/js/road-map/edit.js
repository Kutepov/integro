//Показать кнопки добавления
$('.js-step-hover').mouseover(function () {
    $(this).find('.js-step-create').find('span').css('display', 'inline');
});

//Скрыть кнопки добавления
$('.js-step-hover').mouseout(function () {
    $(this).find('.js-step-create').find('span').css('display', 'none');
});
