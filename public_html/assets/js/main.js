var SPLITPATHNAME = location.pathname.split('/');
var FROM = SPLITPATHNAME.length > 2 ? parseInt(SPLITPATHNAME[2]) : 0;
var XLST = '';
var LOADBUTTON = $('#load-button');
var lang = $('html').attr('lang');

$(function () {
    loadVoting('meme-container', 'meme');

    $(document).on('click tap', '.not-loaded-video a', function (event) {
        event.preventDefault();
    });

    $(document).on('click tap', '.not-loaded-video', function () {
        var element = $(this);
        var iframe = $('<iframe class="embed-responsive-item" allowfullscreen></iframe>');
        iframe.attr('src', 'https://www.youtube.com/embed/' + element.attr('data-id') + '?autoplay=1');
        ga('send', {
             hitType: 'event',
             eventCategory: 'Video',
             eventAction: 'play',
             eventLabel: element.attr('data-id')
         });
        element.removeClass('not-loaded-video');
        element.html(iframe);

    });

    if (LOADBUTTON.length === 0) {
        return;
    }

    $.ajax({
        method: "GET",
        url: location.protocol + '//' + location.hostname + "/assets/xlst/meme_" + lang + ".xsl",
        dataType: 'xml'
    }).done(function (xlst) {
        XLST = xlst;
        window.onscroll = yHandler;
    });

    LOADBUTTON.text(LOADBUTTON.attr('data-text-loading'));
});

function yHandler() {
    var body = document.getElementById('memebody');
    var contentHeight = body.offsetHeight;
    var y = window.pageYOffset + window.innerHeight;
    if (y + 400 >= contentHeight) {
        window.onscroll = null;
        if ($('.meme').length < 50) {
            loadMore();
        } else {
            LOADBUTTON.text(LOADBUTTON.attr('data-text-morespice'));
        }
    }
}

function addFromXML(data, xlst, selector, fn) {
    var parsedXML = jQuery.parseXML(data);
    var xsltProcessor = new XSLTProcessor();
    xsltProcessor.importStylesheet(xlst);
    $(selector)[fn](xsltProcessor.transformToFragment(parsedXML, document));
}

function loadMore() {
    var from = LOADBUTTON.attr('data-load-from');
    var amount = LOADBUTTON.attr('data-load-amount');
    var type = LOADBUTTON.attr('data-load-type');
    var params = "type=" + type + "&from=" + from + "&amount=" + amount;

    $.ajax({
        method: "GET",
        url: location.protocol + '//' + location.hostname + "/main/getMemesXML?" + params,
        error: function (xhr, status, error) {
            $("#load-button").hide();
        }
    }).done(function (result) {
        if (result === 'null') {
            window.onscroll = null;
            LOADBUTTON.hide();
            $('#memebody').append(
                '<div class="container-fluid">' +
                '<div class="row col-centered col-custom-frontpage">' +
                '<p>' + LOADBUTTON.attr('data-text-reachedend') + '</p>' +
                '</div>' +
                '</div>'
            );
        } else {
            addFromXML(result, XLST, '#load-more', 'append');
            var nextFrom = parseInt(from) + parseInt(amount);
            LOADBUTTON.attr('data-load-from', nextFrom);
            LOADBUTTON.attr('href', "/" + type + "?from" + nextFrom + "&amount=" + amount);
            window.onscroll = yHandler;

            var memeCount = $('.meme').length;
            history.replaceState({}, '', '/' + type + '?from=' + FROM + '&amount=' + memeCount);
        }
    });
}
