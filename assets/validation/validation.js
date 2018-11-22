function disabledMsg(fieldId, submitId, msg=null){
    if(msg){ alert(msg); }
    submitId.prop('disabled', true);
    fieldId.css("background-color", "red");
}
function enabledMsg(fieldId, submitId){
    submitId.prop('disabled', false);
    fieldId.css("background-color", "");
}

function requiredAttr(fieldId, trueFalse){ 
    document.getElementById(fieldId).required = trueFalse;
}