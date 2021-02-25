
function getDataForDepandantField(parentf, childf, type) {
    
    if (type == 1) {
        var val = jQuery("select#" + parentf).val();
    } else if (type == 2) {
        var val = jQuery("input[name=" + parentf + "]:checked").val();
    }
    var link = "index.php?option=com_jsjobs&c=customfields&task=datafordepandantfield";
    jQuery.post(link, {fvalue: val, child: childf}, function (data) {
        if (data) {
            console.log(data);
            var d = jQuery.parseJSON(data);
            jQuery("select#" + childf).replaceWith(d);
        }
    });
}

function deleteCutomUploadedFile(field , isrequired) {
    var message = Joomla.JText._('Are you sure ?');
    var field_1 = field+"_1";
    var result = confirm(message);
    if(result){
        jQuery("input#"+field_1).val(1);
        jQuery("span."+field_1).hide();
        if(isrequired == 1){
            jQuery("input#"+field).addClass('required');
        }        
    }
}

function uploadfile(fileobj, filesizeallow, fileextensionallow) {
    var file = fileobj.files[0];
    var name = file.name;
    var size = (file.size) / 1024; //kb
    var type = file.type;
    var fileext = getExtension(name);
    if (size > filesizeallow) {
        alert(jQuery('span#filesize').html());
        return false;
    }
    var f_e_a = fileextensionallow.split(','); // file extension allow array
    var isfileextensionallow = checkExtension(f_e_a, fileext);
    if (isfileextensionallow == 'N') {
        alert(jQuery('span#fileext').html());
        return false;
    }
    return true;
}


function  checkExtension(f_e_a, fileext) {
    var match = 'N';
    for (var i = 0; i < f_e_a.length; i++) {
        if (f_e_a[i].toLowerCase() === fileext.toLowerCase()) {
            match = 'Y';
            break;
        }
    }
    return match;
}
function getExtension(filename) {
    return filename.split('.').pop().toLowerCase();
}
