
checkType(Number($('#object-type_id').val()));

$('#object-type_id').change(function(){
    checkType(Number($(this).val()));
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

$(document).ready(function () {
    $("#object-place_km").val(0);
    $("#object-place_km").parent().hide();

    $(document).on('change', '#object-city_id', function () {
        var mkad = $("#object-city_id option:selected").data("mkad");
        if (mkad) {
          $("#object-place_km").parent().show();
        } else {
          $("#object-place_km").parent().hide();
          $("#object-place_km").val(0);
        }
    })
})
