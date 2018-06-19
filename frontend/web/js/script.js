function checkType(j) {
    console.log('dd');
    for(var i = 1; i <= 3; i++){
        if(i == j){
            $('.form-attribute-' + i).attr('style', "display:block");
        }else{
            $('.form-attribute-' + i).attr('style', "display:none");
        }
    }
}

/* комментарии */
function openAnswer(id, lvl) {
    var newLvl = lvl + 1;
    $('#btn-comment-open-'+id).css('display', 'none');
    $('#commentobject-level').val(newLvl);
    $('#commentobject-comment_id').val(id);
    $('.answer-form-'+id).html($('.form-push').html());
}
/* по хорошему их можно бы по другому реализовать, так сказать более разумнее */

$(document).ready(function () {
    /* паспорт */
    $('#userpassport-type_id').change(function(){
        console.log('kk');

        checkType(Number($(this).val()));
    });

    /* фильтрв вв каталоге */
    $('#objectsearch-type_id').change(function(){
        checkType(Number($(this).val()));
    });

    $('#btn-close-comment').html('<button class="btn btn-link" onclick="openAnswer()">Ответить</button>');


    /* фильтр в каталоге */
    $('#price-slider').slider({ tooltip: false });
    $("#price-slider").on("slide slideStop", function(slideEvt) {
        var value = slideEvt.value;
        $("#objectsearch-amount_min").val(value[0]);
        $("#objectsearch-amount_max").val(value[1]);
    }).on("click", function (slideEvt) {
        var value = slideEvt.value;
        $("#objectsearch-amount_min").val(value[0]);
        $("#objectsearch-amount_max").val(value[1]);
    });

    $('#area-slider').slider({ tooltip: false });
    $("#area-slider").on("slide slideStop", function(slideEvt) {
        var value = slideEvt.value;
        $("#objectsearch-area_min").val(value[0]);
        $("#objectsearch-area_max").val(value[1]);
    }).on("click", function (slideEvt) {
        var value = slideEvt.value;
        $("#objectsearch-area_min").val(value[0]);
        $("#objectsearch-area_max").val(value[1]);
    });

    $('#rooms-slider').slider({ tooltip: false });
    $("#rooms-slider").on("slide slideStop", function(slideEvt) {
        var value = slideEvt.value;
        $("#objectsearch-rooms_min").val(value[0]);
        $("#objectsearch-rooms_max").val(value[1]);
    }).on("click", function (slideEvt) {
        var value = slideEvt.value;
        $("#objectsearch-rooms_min").val(value[0]);
        $("#objectsearch-rooms_max").val(value[1]);
    });
    /* !!! сделай плиз что бы при изменение филтра в input менялась полоса(slider) !!! */

    /* фильтр в каталоге */
    $('#price-slider').slider({ tooltip: false });
    $("#price-slider").on("slide slideStop", function(slideEvt) {
        var value = slideEvt.value;
        $("#userpassport-amount_min").val(value[0]);
        $("#userpassport-amount_max").val(value[1]);
    }).on("click", function (slideEvt) {
        var value = slideEvt.value;
        $("#userpassport-amount_min").val(value[0]);
        $("#userpassport-amount_max").val(value[1]);
    });

    $('#area-slider').slider({ tooltip: false });
    $("#area-slider").on("slide slideStop", function(slideEvt) {
        var value = slideEvt.value;
        $("#userpassport-area_min").val(value[0]);
        $("#userpassport-area_max").val(value[1]);
    }).on("click", function (slideEvt) {
        var value = slideEvt.value;
        $("#userpassport-area_min").val(value[0]);
        $("#userpassport-area_max").val(value[1]);
    });

    $('#rooms-slider').slider({ tooltip: false });
    $("#rooms-slider").on("slide slideStop", function(slideEvt) {
        var value = slideEvt.value;
        $("#userpassport-rooms_min").val(value[0]);
        $("#userpassport-rooms_max").val(value[1]);
    }).on("click", function (slideEvt) {
        var value = slideEvt.value;
        $("#userpassport-rooms_min").val(value[0]);
        $("#userpassport-rooms_max").val(value[1]);
    });
});
