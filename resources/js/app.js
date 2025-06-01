window.addEventListener("error", (e) => {
  console.error("Caught global error:", e.message, e);
});

window.addEventListener("unhandledrejection", (e) => {
  console.error("Unhandled promise rejection:", e.reason);
});

import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },
})

window.toggleDarkMode = function () {
  if (document.documentElement.classList.contains('dark')) {
    document.documentElement.classList.remove('dark');
    localStorage.setItem('theme', 'light');
  } else {
    document.documentElement.classList.add('dark');
    localStorage.setItem('theme', 'dark');
  }
  window.dispatchEvent(new Event('themechange'));
};

// Optionally, set initial theme on load
if (
  localStorage.getItem('theme') === 'dark' ||
  (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
) {
  document.documentElement.classList.add('dark');
} else {
  document.documentElement.classList.remove('dark');
}

// The error is because you are trying to load a CSS file as a font-face src.
// In your CSS, make sure your @font-face src points to a .woff2 or .woff file, not a CSS file.
// Remove or fix the following in your app.css (not in this JS file):
// src: url('https://fonts.bunny.net/css?family=instrument-sans:400,500,600') format('woff2');

// Instead, use the <link> tag in your Blade template to load the font CSS, as you already do.
// No changes are needed in app.js for this warning.

// Dynamically load Google Analytics after page load for non-blocking LCP
window.addEventListener('load', () => {
  // Google Analytics
  const gaScript = document.createElement('script');
  gaScript.src = 'https://www.googletagmanager.com/gtag/js?id=G-SCQ11YJVEY';
  gaScript.async = true;
  document.head.appendChild(gaScript);

  gaScript.onload = () => {
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    window.gtag = gtag;
    gtag('js', new Date());
    gtag('config', 'G-SCQ11YJVEY');
  };

  // Google AdSense
  const adsScript = document.createElement('script');
  adsScript.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3574329224038401';
  adsScript.async = true;
  adsScript.crossOrigin = 'anonymous';
  document.head.appendChild(adsScript);
});