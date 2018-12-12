jQuery(document).ready(function(){

    var $tariffPrice = jQuery('#tariffPrice'),
        $textPrice   = jQuery('#text-price');

    $tariffPrice.ionRangeSlider({
        extra_classes: "calc-irs",
        postfix: " Р",
        onStart: function(data) {
            checkForm(data.from);
            getData();
            $textPrice.val(data.from);
        },
        onChange: function(data) {
            checkForm(data.from);
            getData();
            $textPrice.val(data.from);
        },
    });

    $tariffPrice.on("change", function(){
        jQuery("#tariffForm").attr('data-tariff', changeTariff());
    });

    $textPrice.on("change keyup paste", function(){
        var $this = jQuery(this);
        console.log(jQuery(this).val());
        $tariffPrice.data("ionRangeSlider").update({
            from: parseInt($this.val())
        });
    });

    getData();
});

/*
* Калькулятор
*/

jQuery('input', "#tariffForm").on('change', getData);

function getData(){
    var price               = getPrice(),
        priceName           = ' Р',
        tariff              = getTariff(),
        tariffName          = getTariffName(),
        month               = getMonth(),
        monthName           = getMonthName(),
        stage               = getStage(),
        pay                 = getPay(),
        payName             = getPayName(),
        additionalArray     = getAdditional(),
        additional          = getAdditionalPercent(),
        keyRate             = getKeyRate(),
        difference          = getDifference(),
        percentModification = getPercentModification(),
        percent             = getPercent(),
        revenue             = getRevenue();
        stageBlock          = '.tariff-' + tariff + ' .item-' + (stage + 1);
        fullPrice           = price + revenue;

    jQuery('.tariffs .item', '#calculator').each(function(){
       jQuery(this)
           .removeClass('active')
           .find('.item-condition .value').text('---');
       jQuery(this)
           .find('.item-additional')
           .each(function(){
                jQuery(this).removeClass('active');
           });
    });

    jQuery(stageBlock, '#calculator')
        .addClass('active')
        .find('.item-condition').each(function(){
            if (jQuery(this).hasClass('full-price')) {
                jQuery(this).find('.value').text(fullPrice + priceName);
            } else if (jQuery(this).hasClass('item-price')) {
                jQuery(this).find('.value').text(price + priceName);
            } else if (jQuery(this).hasClass('item-month')) {
                jQuery(this).find('.value').text(month + monthName);
            } else if (jQuery(this).hasClass('item-pay')) {
                jQuery(this).find('.value').text(payName);
            }
        });

    jQuery(stageBlock, '#calculator')
        .find('.item-additional')
        .each(function(){
            // console.log(additionalArray);
            var $this = jQuery(this);
            additionalArray.forEach(function(item){
                $this
                    .filter('.additional-' + item)
                    .addClass('active');
            });
        });
    /*
    console.log('----------------');
    console.log('Цена (в рублях): ' + price);
    console.log('Тариф: ' + tariff + ' - ' + tariffName);
    console.log('Месяцев: ' + month);
    console.log('Строка суммы взноса: ' + stage);
    console.log('Выплата ежемесячно или в конце года: ' + pay + ' - ' + payName);
    console.log('Количество дополнительно вычитаемых процентов: ' + additional);
    console.log('Ключевая ставка (в процентах): ' + keyRate);
    console.log('Изменения в зависимости от выбора срока (в процентах): ' + difference);
    console.log('Проценты изменятся на: ' + percentModification);
    console.log('Окончательные проценты: ' + percent);
    console.log('Доход: ' + revenue);
    console.log('----------------');
    */

    return price;
}

function changeTariff() {

    var tariff,
        price = getPrice();

    if (price >= 1500000) {
        tariff = 2;
    } else {
        tariff = 1;
    }

    return tariff;

}

function checkForm(price) {
    if (price == 50000) {
        jQuery('.heading h2 span', '#calculator').text('Оптимальный');
        jQuery('.tariff-1', '#calculator').show();
        jQuery('.tariff-2', '#calculator').hide();

        jQuery('input[name="month"]', '#tariffForm').each(function(){
            jQuery(this).prop('disabled', false);
            jQuery(this).prop('checked', false);
            if (parseInt(jQuery(this).val()) == 3) {
                jQuery(this).prop('checked', true);
            } else {
                jQuery(this).prop('disabled', true);
            }
        });
        jQuery('input[name="percent-payment"]', '#tariffForm').each(function(){
            jQuery(this).prop('disabled', false);
            jQuery(this).prop('checked', false);
            if (parseInt(jQuery(this).val()) == 1) {
                jQuery(this).prop('checked', true);
            } else {
                jQuery(this).prop('disabled', true);
            }
        });
        jQuery('input[name="additional"]', '#tariffForm').each(function(){
            jQuery(this).prop('disabled', false);
            jQuery(this).prop('checked', false);
            if (parseInt(jQuery(this).val()) != 1) {
                jQuery(this).prop('disabled', true);
            }
        });
    } else if ((price >= 51000) && (price <= 1500000)) {
        jQuery('.heading h2 span', '#calculator').text('Оптимальный');
        jQuery('.tariff-1', '#calculator').show();
        jQuery('.tariff-2', '#calculator').hide();

        jQuery('input[name="month"]', '#tariffForm').each(function(){
            jQuery(this).prop('disabled', false);
            jQuery(this).prop('checked', false);
            if (parseInt(jQuery(this).val()) == 12) {
                jQuery(this).prop('checked', true);
            } else {
                jQuery(this).prop('disabled', true);
            }
        });
        jQuery('input[name="percent-payment"]', '#tariffForm').each(function(){
            jQuery(this).prop('disabled', false);
            jQuery(this).prop('checked', false);
            if (parseInt(jQuery(this).val()) == 2) {
                jQuery(this).prop('checked', true);
            } else {
                jQuery(this).prop('disabled', true);
            }
        });
        jQuery('input[name="additional"]', '#tariffForm').each(function(){
            jQuery(this).prop('disabled', false);
            jQuery(this).prop('checked', false);
            if (parseInt(jQuery(this).val()) != 1) {
                jQuery(this).prop('disabled', true);
            }
        });
    } else if (price >= 1500001) {
        jQuery('.heading h2 span', '#calculator').text('Универсальный');
        jQuery('.tariff-2', '#calculator').show();
        jQuery('.tariff-1', '#calculator').hide();

        jQuery('input[name="month"]', '#tariffForm').each(function(){
            jQuery(this).prop('disabled', false);
            jQuery(this).prop('checked', false);
            if (parseInt(jQuery(this).val()) == 3) {
                jQuery(this).prop('disabled', true);
            } else if (parseInt(jQuery(this).val()) == 12) {
                jQuery(this).prop('checked', true);
            }
        });
        jQuery('input[name="percent-payment"]', '#tariffForm').each(function(){
            jQuery(this).prop('disabled', false);
            jQuery(this).prop('checked', false);
            if (parseInt(jQuery(this).val()) == 2) {
                jQuery(this).prop('checked', true);
            }
        });
        jQuery('input[name="additional"]', '#tariffForm').each(function(){
            jQuery(this).prop('disabled', false);
            jQuery(this).prop('checked', false);
        });
    }
}

function getPrice() {
    var price = parseInt(jQuery('input[name="price"]', "#tariffForm").val());
    return price;
}

function getTariff() {
    var tariff = parseInt(jQuery("#tariffForm").attr('data-tariff'));
    return tariff;
}

function getTariffName() {
    var tariff = getTariff(),
        tariffNames = {
            1: "Оптимальный",
            2: "Универсальный"
        };
    return tariffNames[tariff];
}

function getMonth() {
    var month = parseInt(jQuery('input[name="month"]:checked', "#tariffForm").val());
    return month;
}

function getMonthName() {
    var month = getMonth(),
        monthNames = {
            3:  " месяца",
            12: " месяцев",
            36: " месяцев"
        };
    return monthNames[month];
}

function getPay() {
    var pay = parseInt(jQuery('input[name="percent-payment"]:checked', "#tariffForm").val());
    return pay;
}

function getPayName() {
    var pay = getPay(),
        payNames = {
            1: "ежемесячно",
            2: "в конце срока"
        };
    return payNames[pay];
}

function getAdditional() {
    var additional = [];

    jQuery('input[name="additional"]:checked', "#tariffForm").each(function(){
        additional.push(parseInt(jQuery(this).val()));
    });

    return additional;
}

function getAdditionalPercentsInArray() {
    var percents   = {
            1: [1.75, 0.25],
            2: [3, 2.25],
            3: [3.75, 2.75]
        },
        additional = getAdditional(),
        additionalPercents = [];

    additional.forEach(function(item){
        additionalPercents.push(percents[item]);
    })

    return additionalPercents;

}

function getAdditionalPercent() {
    var pay               = getPay(),
        additional        = getAdditionalPercentsInArray(),
        additionalPercent = 0;

    additional.forEach(function(item) {
        item.forEach(function(item, i) {
            if (i == pay - 1) {
                additionalPercent += item;
            }
        });
    });

    return additionalPercent;
}

function getKeyRate() {
    var keyRate = parseFloat(jQuery("#tariffForm").data('keyrate'));
    return keyRate;
}

function getDifference() {
    var difference = parseFloat(jQuery("#tariffForm").data('difference'));
    return difference;
}

function getPercentModification() {
    var additional = getAdditionalPercent(),
        pay = getPay(),
        keyRate = getKeyRate(),
        difference = getDifference(),
        percentModification = keyRate - additional;

    // console.log(difference);
    // console.log(percentModification);

    if (pay == 1) {
        percentModification -= difference;
        return percentModification;
    } else if (pay == 2) {
        return percentModification;
    }

}

function getPercent() {

    var tariff              = getTariff(),
        month               = getMonth(),
        stage               = getStage(),
        optimal             = {
            3: [3, 0, 0, 0],
            12: [0, 4, 6, 7.5]
        },
        universal           = {
            12: [8.5, 9.5, 10.5, 11.5],
            36: [11.5, 12.5, 13.5, 14.5]
        },
        percent             = 0,
        percentModification = getPercentModification();

    if (tariff == 1) {
        percent = optimal[month][stage] + percentModification;
    } else if (tariff == 2) {
        percent = universal[month][stage] + percentModification;
    }

    return percent;

}

function getRevenue() {
    var price = getPrice(),
        percent = getPercent(),
        month = getMonth(),
        revenue = Math.round((price / 12) * (percent / 100)) * month;

    return revenue;
}

function getStage() {

    var tariff = getTariff(),
        price = getPrice(),
        optimal = [],
        universal = [],
        stageIndex = -1;

    jQuery('.tariff-1 .item', '#calculator').each(function(){
        var optimalArray = [];
        optimalArray[0] = parseInt(jQuery(this).data('from'));
        optimalArray[1] = parseInt(jQuery(this).data('to'));
        optimal.push(optimalArray);
    });

    jQuery('.tariff-2 .item', '#calculator').each(function(){
        var universalArray = [];
        universalArray[0] = parseInt(jQuery(this).data('from'));
        universalArray[1] = parseInt(jQuery(this).data('to'));
        universal.push(universalArray);
    });

    if (tariff == 1) {
        optimal.forEach(function(item, i) {
            if(filterPrice(item, price)) {
                stageIndex = i;
            };
        });
    } else if (tariff == 2) {
        universal.forEach(function(item, i) {
            if(filterPrice(item, price)) {
                stageIndex = i;
            };
        });
    }

    return stageIndex;

}

function filterPrice(array, price) {

    var from = array[0],
        to   = array[1];

    if ((price >= from) && (price <= to)) {
        return true;
    } else {
        return false;
    }

}