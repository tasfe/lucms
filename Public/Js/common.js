/*
 * 输出数组对象结构
 */
function dump(arr, level){
    var dumped_text = "";
    if (!level) 
        level = 0;
    
    //The padding given at the beginning of the line.
    var level_padding = "";
    for (var j = 0; j < level + 1; j++) 
        level_padding += "    ";
    
    if (typeof(arr) == 'object') { //Array/Hashes/Objects 
        for (var item in arr) {
            var value = arr[item];
            
            if (typeof(value) == 'object') { //If it is an array,
                dumped_text += level_padding + "'" + item + "' ...\n";
                dumped_text += dump(value, level + 1);
            }
            else {
                dumped_text += level_padding + "'" + item + "'=>\"" + value + "\"\n";
            }
        }
    }
    else { //Stings/Chars/Numbers etc.
        dumped_text = "<" + arr + ">(" + typeof(arr) + ")";
    }
    return dumped_text;
}

/*
 * ******************************************************
 * 页面跳转
 * ******************************************************
 */
function go2(url){
    if (typeof(url) == 'undefined' || url == 0) {
        window.location.reload();
    }
    else {
        window.location.href = url;
    }
}

/*
 * ******************************************************
 * post数据
 * ******************************************************
 */
function postData(url, mdata, callback){
    var $callback = callback || ajaxDone;
    if (!$.isFunction(callback)) 
        $callback = eval('(' + callback + ')');
    $.ajax({
        type: 'POST',
        url: url,
        data: mdata,
        dataType: "json",
        cache: false,
        success: callback,
        error: ajaxError
    });
}

/*
 * ******************************************************
 * post表单
 * ******************************************************
 */
function postForm(form_id, callback){
    var $form = $('#' + form_id);
    $.ajax({
        type: 'POST',
        url: $form.attr("action"),
        data: $form.serializeArray(),
        dataType: "json",
        cache: false,
        success: callback || ajaxDone,
        error: ajaxError
    });
    return false;
}

function ajaxError(data){
    alert(data.info);
}


