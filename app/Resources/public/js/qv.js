var qv = {
    ui: {
        root: function(){
            if(!qv.ui.rootTarget){
                qv.ui.rootTarget = $('#qv-root');
                qv.ui.rootTarget.find('.prev').click(qv.prev);
                qv.ui.rootTarget.find('.next').click(qv.next);
            }
            return qv.ui.rootTarget;
        },
        imageBase : '<img alt="wczytywanie..." />',
        image: function(){
            return qv.ui.root().find('.thumb img');
        },
        iframe : function(){
            return qv.ui.root().find('.iframeplayer-wrapper iframe');
        },
        minimap : {
            image : function(){return  $('#qv-zoom-minimap > img');},
            zoom : function(){return  $('#qv-zoom-minimap-zoom');},
            init : function (){
                qv.ui.root().find('#qv-zoom-minus').click(qv.zoomOut);
                qv.ui.root().find('#qv-zoom-plus').click(qv.zoomIn)
                qv.ui.root().find('#qv-zoom-100').click(qv.zoomClear);
                var dragStartData = {};
                qv.ui.root().find('#qv-zoom-minimap-zoom').draggable({
                    start: function(){
                        var root = qv.ui.root();
                        var rp = root.offset();
                        var mmapi = qv.ui.minimap.image();
                        var i = qv.ui.image();
                        var it =  - (
                                qv.ui.minimap.zoom().position().top /
                                qv.ui.minimap.zoom().parent().height()
                            ) * i.height();
                        var il =  - (
                                qv.ui.minimap.zoom().position().left /
                                qv.ui.minimap.zoom().parent().width()
                            ) * i.width();
                        i.attr('do-left',i.css('left'));
                        i.attr('do-top',i.css('top'));
                        dragStartData = {top:it,left:il};
                        console.log(dragStartData);
                    },
                    drag:function(){
                        var root = qv.ui.root();
                        var rp = root.offset();
                        var mmapi = qv.ui.minimap.image();
                        var i = qv.ui.image();
                        var it =  - (
                                qv.ui.minimap.zoom().position().top /
                                qv.ui.minimap.zoom().parent().height()
                            ) * i.height();
                        var il =  - (
                                qv.ui.minimap.zoom().position().left /
                                qv.ui.minimap.zoom().parent().width()
                            ) * i.width();
                        var deltaT = dragStartData.top - it;
                        var deltaL = dragStartData.left - il;
                        i.css('left',-deltaL+parseInt(i.attr('do-left')));
                        i.css('top',-deltaT+parseInt(i.attr('do-top')));
                    }
                });
            }
        },
        init : function (){
            var qvRootStr = '<div id="qv-root">' +
                '<div id="qv-zoom-info">'+
                    'Zoom: <span id="qv-zoom-level">100</span>%'+
                    '<div id="qv-zoom-tools">'+
                        '<div class="btn-group">'+
                            '<button id="qv-zoom-minus" type="button" class="btn btn-default">-</button>'+
                            '<button id="qv-zoom-100" type="button" class="btn btn-default">100%</button>'+
                            '<button id="qv-zoom-plus" type="button" class="btn btn-default">+</button>'+
                        '</div>'+
                        '<div id="qv-zoom-minimap"><div id="qv-zoom-minimap-zoom"></div><img style="max-width:100%;" /></div>'+
                    '</div>'+
                '</div>'+
                '<div class="iframeplayer-wrapper">'+
                    '<span></span>'+
                    '<iframe class="iframeplayer" type="text/html" '+
                    'src="about:blank" '+
                    'frameborder="0" allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>'+
                '</div>'+
                '<div class="thumb">'+
                    '<span></span>'+ qv.ui.imageBase +
                '</div>' +
                '<button class="btn btn-default prev"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></button>' +
                '<button class="btn btn-default next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>' +
                '<button class="btn btn-default qv-close" onclick="qv.close();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>' +
                '<nav class="info navbar navbar-inverse navbar-fixed-bottom">' +
                    '<div class="container">' +
                        '<div class="navbar-header">' +
                            '<a class="navbar-brand qv-name" href="#"><i class="fa fa-external-link-square" aria-hidden="true"></i>Nazwa eksponatu</a>' +
                        '</div>' +
                        '<div class="navbar-text hidden-xs hidden-sm desc">Wczytywanie opisu...</div>' +
                        '<ul class="nav navbar-nav navbar-right">' +
                            '<li class="dropdown">' +
                                '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' +
                                    'Więcej <span class="caret"></span>' +
                                '</a>' +
                                '<ul class="dropdown-menu">' +
                                    '<li class="dropdown-header">Informacje</li>' +
                                    '<li><a class="qv-name" href="#"><i class="fa fa-external-link-square" aria-hidden="true"></i>Nazwa eksponatu</a></li>' +
                                    '<li role="separator" class="divider"></li>' +
                                    '<li class="dropdown-header">Inne</li>' +
                                    '<li><a href="" onclick="void(qv.close());return false"><i class="fa fa-close fa-x1" aria-hidden="true"></i> Zamknij przeglądarkę</a></li>' +
                                '</ul>' +
                            '</li>' +
                        '</ul>' +
                        '<div class="navbar-form navbar-right"></div>' +
                    '</div>' +
                '</nav>' +
            '</div>';
            var qvRoot = $(qvRootStr);
            $('body').append(qvRoot);
            qv.ui.minimap.init();
        }
    },
    prev:function(){
        var t = qv.target.parent().prev().find('*[qv-id]');
        if(t.length > 0)
            qv.load(t);
        else
            qv.ui.root().find('.prev').hide();
    },
    next:function(){
        var t = qv.target.parent().next().find('*[qv-id]');
        if(t.length > 0)
            qv.load(t);
        else
            qv.ui.root().find('.next').hide();
    },
    close: function(element){
        var fr = qv.ui.iframe();
        fr.attr('src','about:blank');
        qv.zoomClear();
        qv.ui.root().fadeOut(300);
        $('body').css('overflow','auto');
    },
    open: function(element){
        qv.ui.root().fadeIn(300);
        qv.load(element);
        $('body').css('overflow','none');
    },
    target : false,
    zoomAllow : false,
    showIframe : function(url){
        qv.zoomAllow = false;
        qv.zoomClear();
        var i = qv.ui.image();
        i.parent().hide();
        var fr = qv.ui.iframe();
        fr.parent().show();
        fr.attr('src',url);
    },
    showThumb : function(thumbUrl,fullSize){
        qv.zoomAllow = true;
        qv.zoomClear();
        var i = qv.ui.image();
        i.parent().show();
        var fr = qv.ui.iframe();
        fr.parent().hide();
        var l = $('<i class="loading-indactor fa fa-spinner fa-pulse fa-5x fa-fw" aria-hidden="true"></i>');
        fullSize = !fullSize ? 'none' : fullSize;
        i.hide();
        var top = i.parent();
        i.remove();
        qv.ui.root().find('#qv-zoom-info').hide();
        i = $(qv.ui.imageBase);
        top.append(i);
        i.parent().append(l);
        i.attr('fullSize',fullSize);
        i.on('load',function(){
            qv.ui.minimap.image().attr('src',i.attr('src'));
            i.show();
            l.remove();
        });
        i.attr('src',thumbUrl);
    },
    load : function(element){
        $element = $(element);
        qv.target = $element;
        var thumbUrl = $element.attr('qv-thumb');
        var name = $element.attr('qv-name');
        var type = $element.attr('qv-type');
        var id = $element.attr('qv-id');
        var href = $element.attr('qv-href');
        var desc = $element.attr('qv-details-url');
        var fullSize = $element.attr('qv-full-size');
        var remoteId = $element.attr('qv-remote-id');
        var remoteType = $element.attr('qv-remote-type');
        var single = $element.attr('qv-single') == 'yes';
        if(remoteType=='youtube'){
            var remoteUrl = 'https://www.youtube.com/embed/'+remoteId+'?enablejsapi=1&modestbranding=1&rel=0&showinfo=0&color=white&iv_load_policy=3';
            qv.showIframe(remoteUrl);
        } else if(remoteType=='vimeo'){
            var remoteUrl = 'https://player.vimeo.com/video/'+remoteId;
            qv.showIframe(remoteUrl);
        } else {
            qv.showThumb(thumbUrl,fullSize);
        }
        qv.ui.root().find('.qv-name').attr('href',href).html('<i class="fa fa-external-link-square" aria-hidden="true"></i> '+name);
        var next = $element.parent().next();
        var prev = $element.parent().prev();
        if(next.length > 0 && !single)
            qv.ui.root().find('.next').show();
        else
            qv.ui.root().find('.next').hide();
        if(prev.length > 0 && !single)
            qv.ui.root().find('.prev').show();
        else
            qv.ui.root().find('.prev').hide();
        if(desc)
            $('.desc').html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw" aria-hidden="true"></i>').load($element.attr('qv-details-url'));
        else
            $('.desc').html('');
    },
    bindItems : function(){
        $('.qv-item[qv-binded!=yes]').click(function(event){
            event.preventDefault();
            qv.open(this);
        }).attr('qv-binded','yes');
    },
    keyDownListener : function(e){
        if($('#qv-root:visible').length > 0){ // is closed
            switch (e.keyCode) {
                case 27: // ESC
                    qv.close();
                    e.preventDefault();
                    return false;
                case 37: // Left
                    qv.prev();
                    e.preventDefault();
                    return false;
                case 39: // Right
                case 13: // Space
                    qv.next();
                    e.preventDefault();
                    return false;
                default:
                    //console.log('Unknown keyCode: '+e.keyCode);
            }
        }
        return true;
    },
    updateMinimap : function(){
        var i = qv.ui.image();
        var root = qv.ui.root();
        var mmapi = qv.ui.minimap.image();
        var h = parseFloat(mmapi.height());
        var w = parseFloat(mmapi.width());
        var ih = parseFloat(i.height());
        var iw = parseFloat(i.width());
        var mh = h * parseFloat(root.height()) / ih;
        var mw = w * parseFloat(root.width())  / iw;
        var ip = i.offset();
        var rp = root.offset();
        var l = ( ip.left - rp.left  ) / iw;
        var t = ( ip.top  - rp.top ) /   ih;
        l *= -100;
        t *= -100;
        qv.ui.minimap.zoom().height(mh);
        qv.ui.minimap.zoom().width(mw);
        qv.ui.minimap.zoom().css('top', t+'%');
        qv.ui.minimap.zoom().css('left',l+'%');
    },
    zoomTo : function(m){
        if(qv.zoomAllow == false)return ;
        var i = qv.ui.image();
        m = m > 0.03? m : 0.03;
        $('nav').addClass('fade30');
        if(i.prop('zooming') != true){
            i.prop('zooming',true);
            i.css('position','absolute');
            var w = i.width();
            var h = i.height();
            i.attr('org-width',w);
            i.attr('org-height',h);

            i.css('margin-top',-h/2);
            i.css('margin-left',-w/2);
            i.css('top','50%');
            i.css('left','50%');

            i.css('max-width','none');
            i.css('max-height','none');
            i.draggable({
                drag: function(e,ui) {
                    qv.updateMinimap();
                }
            });
            var fullSizeUrl = i.attr('fullSize');
            if(fullSize != 'none'){
                var fullSize = $('<img />');
                fullSize.on('load',function(){
                    i.attr('src',$(this).attr('src'));
                }).attr('src',fullSizeUrl);
            }
        }
        i.attr('zoom-level',m);
        var nw = m*parseInt(i.attr('org-width'));
        var nh = m*parseInt(i.attr('org-height'));
        i.width(nw);
        i.height(nh);
        i.css('margin-top',-nh/2);
        i.css('margin-left',-nw/2);
        qv.updateMinimap();
        qv.ui.root().find('#qv-zoom-level').text(Math.round(m*100));
        qv.ui.root().find('#qv-zoom-info').fadeIn();

    },
    zoomClear : function(){
        var old_state = qv.zoomAllow;
        qv.zoomTo(1);
        qv.ui.root().find('#qv-zoom-info').fadeOut();
        var i = qv.ui.image();
        i.css('top','50%');
        i.css('left','50%');
        $('nav').removeClass('fade30');
        qv.zoomAllow = old_state;
    },
    zoomIn : function(){
        var zoomNow = qv.ui.image().attr('zoom-level');
        if(typeof zoomNow == "undefined" )zoomNow = 1;
        else zoomNow = parseFloat(zoomNow);
        zoomNow += 0.05;
        qv.zoomTo(zoomNow);
    },
    zoomOut : function(){
        var zoomNow = qv.ui.image().attr('zoom-level');
        if(typeof zoomNow == "undefined" )zoomNow = 1;
        else zoomNow = parseFloat(zoomNow);
        zoomNow -= 0.05;
        qv.zoomTo(zoomNow);
    },
    scrollListener : function(e){
        if($('#qv-root:visible').length > 0){ // is closed
            //console.log(e);
            if (e.deltaY > 0){
                qv.zoomIn();
                e.preventDefault();
                return false;
            } else if (e.deltaY < 0){
                qv.zoomOut();
                e.preventDefault();
                return false;
            }
            // } else if(e.deltaX > 0){
            //     qv.prev();
            //     e.preventDefault();
            //     return false;
            // } else if (e.deltaX < 0) {
            //     qv.next()
            //     e.preventDefault();
            //     return false;
            // };
        }
        return true;
    },
    init : function(){
        qv.ui.init();
        // Events
        $('body').on('keypress',qv.keyDownListener);
        $('body').on('mousewheel',qv.scrollListener);
        var ham = new Hammer( qv.ui.root()[ 0 ], {
          domEvents: true
        } );
        ham.get('pinch').set({threshold: 0.3,enable: true });
        var zoomBase = 1;
        qv.ui.root().on( "pinchstart", function( e ) {
            var zoomNow = qv.ui.image().attr('zoom-level');
            if(typeof zoomNow == "undefined" )zoomNow = 1;
            else zoomNow = parseFloat(zoomNow);
            zoomBase = zoomNow;
        } );
        qv.ui.root().on( "pinch", function( e ) {
            qv.zoomTo(zoomBase * e.originalEvent.gesture.scale);
        } );
        // bindItems on dom elements
        qv.bindItems();
    }
};
$().ready(qv.init);
