<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Primary Meta Tags --}}
    <title>Truth or Lie – Play the Ultimate Fact-Checking Game</title>
    <meta name="title" content="Truth or Lie – Play the Ultimate Fact-Checking Game">
    <meta name="description" content="Can you spot the truth from the lies? Test your brain with our quick, fun, and AI-powered trivia game. No login required.">
    <meta name="google-adsense-account" content="ca-pub-3574329224038401">
    <meta http-equiv="Cross-Origin-Opener-Policy" content="same-origin">
    <meta http-equiv="Permissions-Policy" content="interest-cohort=(), geolocation=(), microphone=(), camera=(), payment=(), usb=(), vr=(), accelerometer=(), ambient-light-sensor=(), autoplay=(), battery=(), bluetooth=(), clipboard-write=(), cross-origin-isolated=(), display-capture=(), document-domain=(), encrypted-media=(), fullscreen=(), gamepad=(), gyroscope=(), magnetometer=(), midi=(), picture-in-picture=(), publickey-credentials-get=(), screen-wake-lock=(), sync-xhr=(), web-share=(), xr-spatial-tracking=()">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://trueorlie.fun/">
    <meta property="og:title" content="Truth or Lie – Play the Ultimate Fact-Checking Game">
    <meta property="og:description" content="Play the viral truth vs lie trivia game. Powered by AI. Prove you can't be fooled!">
    <meta property="og:image" content="/favicon_io/android-chrome-512x512.png">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://trueorlie.fun/">
    <meta property="twitter:title" content="Truth or Lie – Play the Ultimate Fact-Checking Game">
    <meta property="twitter:description" content="Play the viral truth vs lie trivia game. Powered by AI. Prove you can't be fooled!">
    <meta property="twitter:image" content="/favicon_io/android-chrome-512x512.png">

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="/favicon_io/site.webmanifest">
    <link rel="shortcut icon" href="/favicon_io/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">


    @vite('resources/js/app.js')
    @inertiaHead
    <!-- Inline critical font CSS to avoid render-blocking -->
    <style>
      @font-face {
        font-family: 'Instrument Sans';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url('https://fonts.bunny.net/woff2?family=instrument-sans:400') format('woff2');
      }
      @font-face {
        font-family: 'Instrument Sans';
        font-style: normal;
        font-weight: 500;
        font-display: swap;
        src: url('https://fonts.bunny.net/woff2?family=instrument-sans:500') format('woff2');
      }
      @font-face {
        font-family: 'Instrument Sans';
        font-style: normal;
        font-weight: 600;
        font-display: swap;
        src: url('https://fonts.bunny.net/woff2?family=instrument-sans:600') format('woff2');
      }
      html, body {
        font-family: 'Instrument Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif;
      }
    </style>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-SCQ11YJVEY"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-SCQ11YJVEY');
    </script>
  </head>
  <body>
    @inertia
  </body>
</html>