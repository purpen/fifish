/**
 * fifish base js
 */


var fi = {};

/**
 * 允许多附件上传
 */
fi.record_asset_id = function(class_id, id){
    var ids = $('#'+class_id).val();
    if (ids.length == 0){
        ids = id;
    }else{
        if (ids.indexOf(id) == -1){
            ids += ','+id;
        }
    }
    $('#'+class_id).val(ids);
};

//移除附件id
fi.remove_asset_id = function(class_id, id){
    var ids = $('#'+class_id).val();
    var ids_arr = ids.split(',');
    var is_index_key = phenix.in_array(ids_arr,id);
    ids_arr.splice(is_index_key,1);
    ids = ids_arr.join(',');
    $('#'+class_id).val(ids);
};

//查看字符串是否在数组中存在
fi.in_array = function(arr, val) {
    var i;
    for (i = 0; i < arr.length; i++) {
        if (val === arr[i]) {
            return i;
        }
    }
    return -1;
}; // 返回-1表示没找到，返回其他值表示找到的索引
