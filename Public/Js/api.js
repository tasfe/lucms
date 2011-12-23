function mdebug(fid){
    postForm('mform_' + fid, function(data){
        $('#mtext_' + fid).val(data.info + "\n" + dump(data.data));
    });
    return false;
}

function getMd5(fid){
    var auth = $('#mform_' + fid).find("input[name='auth']").val();
    var obj = $('#mform_' + fid).find("input[name='obj']").val();
    var act = $('#mform_' + fid).find("input[name='act']").val();
    var par = '';
    if ($('#mform_' + fid).find("input[name='par']").length > 0) {
        par = $('#mform_' + fid).find("input[name='par']").val();
    }
    if ($('#mform_' + fid).find("textarea[name='par']").length > 0) {
        par = $('#mform_' + fid).find("textarea[name='par']").val();
    }
    var str = '{auth:' + $.trim(auth) + '}' + '{obj:' + $.trim(obj) + '}' + '{act:' + $.trim(act) + '}';
    if (par != '') 
        str = str + '{par:' + $.trim(par) + '}';
    
    $('#mform_' + fid).find("input[name=secret]").val($.md5(str));
}
