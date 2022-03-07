$(document).ready(function () {
    $('.branches').on('click', function () {
        $(this).toggleClass('marginTop');
        $('.fa-arrow-up').toggleClass('rotate');
    })
    $('.fa-times').on('click', function () {
        $('.branches').hide();
    })

    $(window).on('load', function () {
        $('#popUpad').modal('show');
    });
})
$('img').on('click', function () {
    var src = $(this).attr('src');
    console.log(src)
    $('#targetImage').attr('src', src);
})
$('.close').on('click', function () {
    $('#TopAdss').slideUp();
})

$('.close_ar').on('click', function () {
    $('#TopAdss_ar').slideUp();
})
