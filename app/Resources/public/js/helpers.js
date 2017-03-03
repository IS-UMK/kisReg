function copyTextToClipboard(text) {
    var textArea = document.createElement("textarea");

    //
    // *** This styling is an extra step which is likely not required. ***
    //
    // Why is it here? To ensure:
    // 1. the element is able to have focus and selection.
    // 2. if element was to flash render it has minimal visual impact.
    // 3. less flakyness with selection and copying which **might** occur if
    //    the textarea element is not visible.
    //
    // The likelihood is the element won't even render, not even a flash,
    // so some of these are just precautions. However in IE the element
    // is visible whilst the popup box asking the user for permission for
    // the web page to copy to the clipboard.
    //

    // Place in top-left corner of screen regardless of scroll position.
    textArea.style.position = 'fixed';
    textArea.style.top = 0;
    textArea.style.left = 0;

    // Ensure it has a small width and height. Setting to 1px / 1em
    // doesn't work as this gives a negative w/h on some browsers.
    textArea.style.width = '2em';
    textArea.style.height = '2em';

    // We don't need padding, reducing the size if it does flash render.
    textArea.style.padding = 0;

    // Clean up any borders.
    textArea.style.border = 'none';
    textArea.style.outline = 'none';
    textArea.style.boxShadow = 'none';

    // Avoid flash of white box if rendered for any reason.
    textArea.style.background = 'transparent';


    textArea.value = text;

    document.body.appendChild(textArea);

    textArea.select();

    try {
        var successful = document.execCommand('copy');
        // console.log('Copying text command was ' + msg);
        if(successful)
            popup('Skopiowano do schowka');
        else
            popup('Błąd kopiowania schowka','danger');
    } catch (err) {
        // console.log('Oops, unable to copy');
        popup('Błąd kopiowania schowka','danger');
    }
    document.body.removeChild(textArea);
}
function popup(text,type,timeout){
    type = type?type:'success';
    timeout = timeout?timeout:3000;
    var p = $('<div class="alert alert-'+type+'" style="position: fixed; bottom: 30px; right: 30px; z-index:999;"></div>');
    p.html(text);
    $('body').append(p);
    p.hide().fadeIn(100).delay(timeout).fadeOut(500);
}
function loadingIndactor(newState){
    var ind = $('#loading-indactor-wrapper');
    if(ind.length == 0){
        var ind = $('<div id="loading-indactor-wrapper" style="position: fixed; bottom: 10%; left: 0px; width: 100%; margin: 0px; padding: 0px; background: rgba(0,0,0,0.5); text-align: center; color: white; display: none;"><h3><i class="fa fa-spinner fa-pulse fa-1x fa-fw" aria-hidden="true"></i></h3></div>');
        $('body').append(ind);
    }
    if(newState){
        ind.fadeTo(300,1);
    } else {
        ind.fadeTo(300,0);
    }
}
function cloneObj(obj) {
    if (null == obj || "object" != typeof obj) return obj;
    var copy = obj.constructor();
    for (var attr in obj) {
        if (obj.hasOwnProperty(attr)) copy[attr] = obj[attr];
    }
    return copy;
}
