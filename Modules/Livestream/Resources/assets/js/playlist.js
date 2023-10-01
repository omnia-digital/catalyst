window.omnia = (function () {
    var omniaScript = document.currentScript || document.querySelector('script[src*="playlist.js"][site]') || document.querySelector("script[data-site]") || document.querySelector("script[site]"),
        embedUrl = omniaScript.getAttribute('data-embed');

    var loadPlaylist = function (params) {
        xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('omnia-playlist').innerHTML = xhr.responseText;
            }
        };
        xhr.open('GET', embedUrl + '?' + buildQueryString(params ? params : {}), true);
        xhr.send();
    }

    var buildQueryString = function (params) {
        var esc = encodeURIComponent;

        return Object.keys(params)
            .map(k => esc(k) + '=' + esc(params[k]))
            .join('&');
    }

    var getBaseUrl = function () {
        var a = document.createElement('a');
        a.href = embedUrl;

        return a.protocol + '//' + a.hostname;
    }

    var includeScript = function (URL, isDefer = false, callback) {
        let documentTag = document, tag = 'script',
            object = documentTag.createElement(tag),
            scriptTag = documentTag.getElementsByTagName(tag)[0];

        object.src = '//' + URL;

        if (isDefer) {
            scriptTag.setAttribute('defer', 'defer');
        }

        if (callback) {
            object.addEventListener('load', function (e) {
                callback(null, e);
            }, false);
        }

        scriptTag.parentNode.insertBefore(object, scriptTag);
    }

    var includeCss = function (cssFile) {
        var head = document.head;
        var link = document.createElement('link');

        link.type = "text/css";
        link.rel = "stylesheet";
        link.href = cssFile;

        head.appendChild(link);
    }

    return {
        loadPlaylist: loadPlaylist,
        includeScript: includeScript,
        includeCss: includeCss,
        getBaseUrl: getBaseUrl,
    }
})();

// Font Awesome Playlist Kit
omnia.includeScript("kit.fontawesome.com/f85c0aecfb.js")

// Include TW Elements
omnia.includeCss("https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css")
omnia.includeScript("cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js")

omnia.includeCss(omnia.getBaseUrl() + '/css/playlist.css')

if (typeof window.Alpine === 'undefined') {
    omnia.includeScript('unpkg.com/alpinejs@3.x.x/dist/cdn.min.js', true)
}

omnia.includeScript('content.jwplatform.com/libraries/Wq6HOAmw.js', false, function () {
    let queryParams = {};

    for (const [key, value] of (new URL(window.location.href)).searchParams.entries()) {
        queryParams[key] = value;
    }

    omnia.loadPlaylist(queryParams)
})

