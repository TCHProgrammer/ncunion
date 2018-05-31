
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