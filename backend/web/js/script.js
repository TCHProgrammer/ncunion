
checkType(Number($('#object-type_id').val()));
$("#landPricesRow").hide();

$('#object-type_id').change(function(){
    var value = Number($(this).val());
    checkType(value);
    if (value === 2) {
        $("#landPricesRow").show();
    } else {
        $("#landPricesRow").hide();
    }
});

function checkType(j) {
    for(var i = 1; i <= 3; i++){
        if(i == j){
            $('.form-attribute-' + i).attr('style', "display:block");
        }else{
            $('.form-attribute-' + i).attr('style', "display:none");
        }
    }
}
