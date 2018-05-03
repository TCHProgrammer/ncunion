
checkType(Number($('#object-type_id').val()));

$('#object-type_id').change(function(){
    checkType(Number($(this).val()));
});

/*function checkType(type) {
    switch(type){
        case 1:
            console.log(1);
            $('.form-attribute-1').attr('style', "display:block");
            $('.form-attribute-2').attr('style', "display:none");
            $('.form-attribute-3').attr('style', "display:none");
            break;

        case 2:
            console.log(2);
            $('.form-attribute-1').attr('style', "display:none");
            $('.form-attribute-2').attr('style', "display:block");
            $('.form-attribute-3').attr('style', "display:none");

            break;

        case 3:
            $('.form-attribute-1').attr('style', "display:none");
            $('.form-attribute-2').attr('style', "display:none");
            $('.form-attribute-3').attr('style', "display:block");
            break;

        default:
            console.log(0);
            break;
    }
}*/

function checkType(j) {
    for(var i = 1; i <= 3; i++){
        if(i == j){
            $('.form-attribute-' + i).attr('style', "display:block");
        }else{
            $('.form-attribute-' + i).attr('style', "display:none");
        }
    }
}