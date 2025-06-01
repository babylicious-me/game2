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
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
  </head>
  <body>
    @inertia
    <!-- 
      LCP (Largest Contentful Paint) for <p class="mt-2 text-gray-400"> in Home.vue means:
      - This <p> is the largest visible element when the page loads.
      - To improve LCP:
        1. Optimize images above/before this <p> (compress, use correct size).
        2. Minimize layout shift: set explicit width/height on images/cards.
        3. Reduce JS/CSS blocking time (keep only critical CSS/JS in <head>).
        4. Move this <p> higher in the DOM if possible, or reduce content above it.
        5. Avoid large banners or slow-loading elements above this <p>.
      - The font is already optimized.
      - For best results, keep your hero/game cards and this <p> as high and simple as possible in your Vue template.
    -->
  </body>
</html>