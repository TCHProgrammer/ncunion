
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
    $('#btn-comment-open-'+id).css('display', 'none');
    $('#commentobject-level').val(lvl + 1);
    $('#commentobject-comment_id').val(id);
    $('.answer-form-'+id).html($('.form-push').html());
}

$('#btn-close-comment').html('<button class="btn btn-link" onclick="openAnswer()">Ответить</button>');

function closeAnswer(id, lvl) {
    $('.answer-form-'+id).html('<button class="btn btn-link" onclick="openAnswer(' + id + ', ' + lvl + ')">Ответить</button>')
}
