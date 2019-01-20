$("[name='AuthAssignment[item_name]']").change(function(){
    var button = $(this).parent().parent().find("[type = 'submit']");
    var value = $(this).val();
    if (value === 'unknown') {
        $(button).attr('disabled', true);
    } else {
        $(button).attr('disabled', false);
    }
    $(this).parent().parent().find("[name = 'UserModel[item_name]']").val(value);
});