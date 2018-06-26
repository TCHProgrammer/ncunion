function checkType(j) {
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

    /* фильтрв в каталоге */
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
    });

    $('#area-slider').slider({ tooltip: false });
    $("#area-slider").on("slide slideStop", function(slideEvt) {
        var value = slideEvt.value;
        $("#objectsearch-area_min").val(value[0]);
        $("#objectsearch-area_max").val(value[1]);
    });

    $('#rooms-slider').slider({ tooltip: false });
    $("#rooms-slider").on("slide slideStop", function(slideEvt) {
        var value = slideEvt.value;
        $("#objectsearch-rooms_min").val(value[0]);
        $("#objectsearch-rooms_max").val(value[1]);
    });

    $('#price-slider').slider({ tooltip: false });
    $("#price-slider").on("slide slideStop", function(slideEvt) {
        var value = slideEvt.value;
        $("#userpassport-amount_min").val(value[0]);
        $("#userpassport-amount_max").val(value[1]);
    });

    $('#area-slider').slider({ tooltip: false });
    $("#area-slider").on("slide slideStop", function(slideEvt) {
        var value = slideEvt.value;
        $("#userpassport-area_min").val(value[0]);
        $("#userpassport-area_max").val(value[1]);
    });

    $('#rooms-slider').slider({ tooltip: false });
    $("#rooms-slider").on("slide slideStop", function(slideEvt) {
        var value = slideEvt.value;
        $("#userpassport-rooms_min").val(value[0]);
        $("#userpassport-rooms_max").val(value[1]);
    });

    /* при загрузке сохраняет сзнение со слайдера(ползунка) в input */
    var resPriceSlide = $("#price-slider").data('slider-value');
    if (!(resPriceSlide === undefined)){
        $("#objectsearch-amount_min").val(resPriceSlide[0]);
        $("#objectsearch-amount_max").val(resPriceSlide[1]);
        $("#userpassport-amount_min").val(resPriceSlide[0]);
        $("#userpassport-amount_max").val(resPriceSlide[1]);
    }

    var resAreaSlide = $("#area-slider").data('slider-value');
    if (!(resAreaSlide === undefined)){
        $("#objectsearch-area_min").val(resAreaSlide[0]);
        $("#objectsearch-area_max").val(resAreaSlide[1]);
        $("#userpassport-area_min").val(resAreaSlide[0]);
        $("#userpassport-area_max").val(resAreaSlide[1]);
    }

    var resRoomsSlide = $("#rooms-slider").data('slider-value');
    if (!(resRoomsSlide === undefined)){
        $("#objectsearch-rooms_min").val(resRoomsSlide[0]);
        $("#objectsearch-rooms_max").val(resRoomsSlide[1]);
        $("#userpassport-rooms_min").val(resRoomsSlide[0]);
        $("#userpassport-rooms_max").val(resRoomsSlide[1]);
    }

    /* !!! сделай плиз что бы при изменение филтра в input менялась полоса(slider) !!! */

    /* ползунок в подписке на объект */
    $('#user-slider').slider({ tooltip: false });
    $("#user-slider").on("slide slideStop", function(slideEvt) {
        var value = slideEvt.value;
        $("#roomobjectuser-sum").val(value);
    });

    /* в каталоге применяет все параметры из паспорта к фильтру */
    $('#filter-passport').on('click', function () {
        var value;

        /* очищаем все лишник поля */
        $('#objectsearch-title').val('');
        $('#objectsearch-price_cadastral').val('');
        $('#objectsearch-price_tian').val('');
        $('#objectsearch-price_market').val('');
        $('#objectsearch-price_liquidation').val('');

        /* тип объекта */
        /*$('#objectsearch-type_id').each(function(){
            value = $(this).data('value');
            $(this).val(value);
            checkType(value);
        });*/

        /* 3 филтра с ползунками */
        $('#filter-slider *').each(function(){
            value = $(this).data('value');
            $(this).val(value);
        });
        /* !!! обязательно настроить так же ползунки !!! */

        /* четбоксы, названия идут: тип_объекта-атрибут-груп  */
        $('.checkbox input').each(function(){
            value = $(this).data('value');
            if (value === 1){
                $(this).prop('checked', true);
            }else{
                $(this).prop('checked', false);
            }
        });

        /* четбоксы, названия идут: тип_объекта-атрибут-груп  */
        $('.radio input').each(function(){
            value = $(this).data('value');
            if (value === 1){
                $(this).prop('checked', true);
            }else{
                $(this).prop('checked', false);
            }
        });
    });


    /* Отправка смс */ /* можно будет переделать */
    var second = 30;
    $('#push-phone-cmc').on('click', function(){

        $.ajax({
            type: 'POST',
            url: '/check-user/push-phone',
            data: {},
            cache: false,
            dataType: 'json',
            success: function(res) {
                console.log(res);

                $('#push-phone-cmc').attr('disabled','disable');

                setTimeout(btnDisabled, (second * 1000));

                function timer(_time, _call){
                    timer.lastCall = _call;
                    timer.lastTime = _time;
                    timer.timerInterval = setInterval(function(){
                        _call(_time[0],_time[1],_time[2]);
                        _time[2]--;
                        if(_time[0]==0 && _time[1]==0 && _time[2]==0){
                            timer.pause();
                            _call(0,0,0);
                        }
                        if(_time[2]==0){
                            _time[2] = 59;
                            _time[1]--;
                            if(_time[1]==0){
                                _time[1] = 59;
                                _time[0]--;
                            }
                        }
                        timer.lastTime = _time
                    }, 1000)
                }
                timer.pause = function(){
                    clearInterval(timer.timerInterval)
                };
                timer.start = function(){
                    timer(timer.lastTime, timer.lastCall)
                };

                timer([0,0,second], function(h,m,s){
                    $('#time-phone').html('Для повторной отправки осталось <span id="time-phone-cmc"></span> секунд');
                    $('#res-phone-cmc').html('Код выслан, проверьте свой телефон');
                    $('#time-phone-cmc').html(s);
                    $('#time-phone').css("display", "block");
                    if (s == 0){
                        $('#time-phone').css("display", "none");
                    }
                })

            },
            error: function(XHR, textStatus, errorThrown) {
                var text = "Произошла ошибка при отправке смс";
                $('#time-phone').html(text);
                $('#time-phone').css("display", "block");
                console.log(text);
            }
        });

    });
    function btnDisabled() {
        $('#push-phone-cmc').removeAttr('disabled');
    }
});
