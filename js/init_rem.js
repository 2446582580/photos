(function () {
    const reset = function () {
        // const max_width = Math.min(window.innerWidth, 1440);
        // const width = Math.max(max_width, 960);
        const $elem = window.document.documentElement;
        const width = window.innerWidth;
        $elem.style.fontSize = width / 7.5 + 'px';
        // const $body = window.document.body;
        // $body && $body.style.setProperty('--v', '0.1');
    };
    reset();
    window.addEventListener('resize', reset, false);
})();