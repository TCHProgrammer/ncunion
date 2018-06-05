
/* паспорт */
//checkType(Number($('#userpassport-type_id').val()));
$('#userpassport-type_id').change(function(){
    console.log('kk');

    checkType(Number($(this).val()));
});

/* фильтрв вв каталоге */
//checkType(Number($('#objectsearch-type_id').val()));
$('#objectsearch-type_id').change(function(){
    checkType(Number($(this).val()));
});

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

$('#btn-close-comment').html('<button class="btn btn-link" onclick="openAnswer()">Ответить</button>');

function closeAnswer(id, lvl) {
    $('.answer-form-'+id).html('<button class="btn btn-link" onclick="openAnswer(' + id + ', ' + lvl + ')">Ответить</button>')
}
//альтернативный способ
/*$('#btn-close-comment').on('click', function(){
});*/
// $('.any-selector').data('id')
