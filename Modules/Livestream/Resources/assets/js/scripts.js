window.omnia = (function () {
    var omniaScript = document.currentScript || document.querySelector('script[src*="script.js"][site]') || document.querySelector("script[data-site]") || document.querySelector("script[site]"),
        embedUrl = omniaScript.getAttribute('data-embed'),
        embedGalleryUrl = embedUrl + '/gallery';

    var loadEmbed = function (params) {
        xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('omnia-app-player').innerHTML = xhr.responseText;
            }
        };
        xhr.open('GET', embedUrl + '?' + buildQueryString(params ? params : {}), true);
        xhr.send();
    }

    var loadGallery = function (params) {
        xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('omnia-embed-gallery').innerHTML = xhr.responseText;
            }
        };
        xhr.open('GET', embedGalleryUrl + '?' + buildQueryString(params ? params : {}), true);
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
        loadEmbed: loadEmbed,
        loadGallery: loadGallery,
        includeScript: includeScript,
        includeCss: includeCss,
        getBaseUrl: getBaseUrl,
    }
})();

omnia.includeCss(omnia.getBaseUrl() + '/css/embed.css')

if (typeof window.Alpine === 'undefined') {
    omnia.includeScript('unpkg.com/alpinejs@3.x.x/dist/cdn.min.js', true)
}

omnia.includeScript('cdn.jwplayer.com/libraries/Wq6HOAmw.js', false, function () {
    omnia.loadEmbed()
})

omnia.includeScript('src.litix.io/jwplayer/4/jwplayer-mux.js', false)
