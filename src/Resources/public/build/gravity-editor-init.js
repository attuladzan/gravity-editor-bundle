/**
 * Gravity UI Markdown Editor - iframe bootstrap.
 * Finds [data-gravity-editor] elements and creates iframes.
 */
(function () {
  var IFRAME_HEIGHT = 520;
  var IFRAME_STYLE = 'width:100%;height:' + IFRAME_HEIGHT + 'px;min-height:' + IFRAME_HEIGHT + 'px;border:1px solid #ccc;border-radius:4px;box-sizing:border-box;display:block;overflow:hidden';

  function init() {
    var wrappers = document.querySelectorAll('[data-gravity-editor="true"]');
    wrappers.forEach(function (wrapper) {
      if (wrapper.dataset.gravityInitialized) return;
      wrapper.dataset.gravityInitialized = '1';

      var mount = wrapper.querySelector('[id$="-mount"]');
      var textareaId = wrapper.dataset.gravityTextareaId;
      var textarea = document.getElementById(textareaId);
      if (!mount || !textarea) return;

      var cfg;
      try {
        cfg = JSON.parse(wrapper.dataset.gravityCfg || '{}');
      } catch (e) {
        cfg = {};
      }
      cfg.initial = cfg.initial || {};
      cfg.initial.markup = String(textarea.value || '');

      var frameUrl = wrapper.dataset.gravityFrame || '';
      if (!frameUrl) return;

      var iframe = document.createElement('iframe');
      iframe.setAttribute('scrolling', 'no');
      iframe.style.cssText = IFRAME_STYLE;
      iframe.src = frameUrl;
      mount.appendChild(iframe);

      function sendInit() {
        try {
          var win = iframe.contentWindow;
          if (win) win.postMessage({ type: 'gmd-init', cfg: cfg, tid: textareaId }, '*');
        } catch (e) {}
      }

      iframe.onload = function () {
        sendInit();
        setTimeout(sendInit, 150);
      };

      iframe.dataset.gravityTextareaId = textareaId;

      var form = wrapper.closest('form');
      if (form && !form.dataset.gravitySubmitPatched) {
        form.dataset.gravitySubmitPatched = '1';
        form.addEventListener('submit', function (e) {
          var iframes = form.querySelectorAll('iframe[data-gravity-textarea-id]');
          if (iframes.length === 0) return;
          e.preventDefault();
          iframes.forEach(function (ifr) {
            try {
              if (ifr.contentWindow && ifr.contentWindow.__GMD_SYNC__) ifr.contentWindow.__GMD_SYNC__();
            } catch (err) {}
          });
          form.submit();
        });
      }
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
