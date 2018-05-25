
checkType(Number($('#userpassport-type_id').val()));

$('#userpassport-type_id').change(function(){
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


function openAnswer(id, lvl) {
    $('.answer-form-'+id).html($('.form-push').html());
    console.log(lvl+1);
    $('#commentobject-level').val(lvl+1);

}

function closeAnswer(id) {
    $('.answer-form-'+id).html('<button class="btn btn-link" onclick="openAnswer(' + id + ')">Ответить</button>')
}
