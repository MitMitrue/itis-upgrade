// $( document ).ready(function() {
//
//
//     $( "#logs" ).submit(function( event ) {
//         $('#answer').text( 'Логи получены.');
//         event.preventDefault();
//     });
//
//     $( ".ajax" ).on( "click", function() {
//
//         $('#result').text( $(this).text());
//         /* $.ajax({
//
//         url: "reports.php",
//         data: {
//         id: $(this).attr("id")
//         },
//         type: "GET",
//
//         dataType : "json",
//         })
//         .done(function( text ) {
//         $('#result').text(text);
//         }); */
//     });
// });
function setCookie (url, offset,count){
    var ws=new Date();
    if (!offset && !url) {
        ws.setMinutes(10-ws.getMinutes());
    } else {
        ws.setMinutes(10+ws.getMinutes());
    }
    document.cookie="scriptOffsetUrl="+url+";expires="+ws.toGMTString();
    document.cookie="scriptOffsetOffset="+offset+";expires="+ws.toGMTString();
    document.cookie="scriptOffsetCount="+count+";expires="+ws.toGMTString();
}

function getCookie(name) {
    var cookie = " " + document.cookie;
    var search = " " + name + "=";
    var setStr = null;
    var offset = 0;
    var end = 0;
    if (cookie.length > 0) {
        offset = cookie.indexOf(search);
        if (offset != -1) {
            offset += search.length;
            end = cookie.indexOf(";", offset)
            if (end == -1) {
                end = cookie.length;
            }
            setStr = unescape(cookie.substring(offset, end));
        }
    }
    return(setStr);
}

function showProcess (url, sucsess, offset, count) {
    $('#submit').attr('disabled','disabled');
    $('.bar').css('width', sucsess * 100 + '%');
    $('.bar').text( offset +" из "+ count);
    setCookie(url, offset, count);
    scriptOffset(url, offset,count);
}

function scriptOffset (url, offset, count) {
    $.ajax({
        url: "../../ajax/parse_txt.php",
        type: "POST",
        data: {
            "offset":offset,
            "count":count,
            "path": url
        },
        success: function(data){
            data = $.parseJSON(data);
            if(data.offset != data.count) {
                showProcess(url, data.success, data.offset,data.count);
            } else {
                setCookie();
                $('.bar').css('width','100%');
                $('.bar').css('background-color','lightskyblue');
                $('.bar').text('Логи загружены: '+data.offset);
                $('#submit').removeAttr('disabled');
            }
        }
    });
}

$(document).ready(function() {

    var url = getCookie("scriptOffsetUrl");
    var offset = getCookie("scriptOffsetOffset");
    var count = getCookie("scriptOffsetCount");

    if (url && url != 'undefined') {
        $('#path').val(url);
        $('#offset').val(offset);
        $('#count').val(count);
    }

    $('#submit').click(function() {
        $('.progress').show();
        $('.bar').css('width', '1%');
        $('.bar').css('background-color','#0E90D2');
        $('.bar').text('');
        var offset = $('#offset').val();
        var url = $('#path').val();
        var count = $('#count').val();

        if ($('#path').val() != getCookie("scriptOffsetUrl")) {
            setCookie();
            scriptOffset(url, 0,count);
        } else {
            scriptOffset(url, offset,count);
        }
        return false;
    });
});
