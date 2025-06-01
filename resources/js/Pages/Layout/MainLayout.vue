<template>
  <div class="flex flex-col min-h-screen">
    <nav class="relative bg-white shadow dark:bg-gray-900">
      <div class="container px-6 py-4 mx-auto">
        <div class="lg:flex lg:items-center lg:justify-between">
          <div class="flex items-center justify-between">
            <Link href="/" class="flex items-center space-x-2">
              <img :src="logoUrl" alt="brand logo" class="w-10 h-10 rounded-full">
              <h1 class="text-xl font-bold text-white">True Or Lie</h1>
            </Link>
            <!-- Mobile menu button -->
            <!--<div class="flex lg:hidden">
              <button
                type="button"
                class="text-gray-500 dark:text-gray-200 hover:text-gray-600 dark:hover:text-gray-400 focus:outline-none focus:text-gray-600 dark:focus:text-gray-400"
                aria-label="toggle menu"
                @click="isOpen = !isOpen"
              >
                <svg v-if="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>-->
          </div>
          <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
           <!--
          <div
            :class=" [
              isOpen ? 'block opacity-100 translate-x-0' : 'hidden opacity-0 -translate-x-full',
              'absolute inset-x-0 z-20 w-full px-6 py-4 transition-all duration-300 ease-in-out bg-white dark:bg-gray-900 lg:mt-0 lg:p-0 lg:top-0 lg:relative lg:bg-transparent lg:w-auto lg:opacity-100 lg:translate-x-0 lg:flex lg:items-center'
            ]"
          >
            <div class="flex flex-col -mx-6 lg:flex-row lg:items-center lg:mx-8">
              <Link href="/" class="px-3 py-2 mx-3 mt-2 text-gray-700 transition-colors duration-300 transform rounded-md lg:mt-0 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Home</Link>

            </div>
            <div class="flex items-center mt-4 lg:mt-0">
            Profile dropdown 
              <button type="button" class="flex items-center focus:outline-none" aria-label="toggle profile dropdown">
                <div class="w-8 h-8 overflow-hidden border-2 border-gray-400 rounded-full">
                  <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80" class="object-cover w-full h-full" alt="avatar">
                </div>
                <h3 class="mx-2 text-gray-700 dark:text-gray-200 lg:hidden">Khatab wedaa</h3>
              </button>
             
            </div>
          </div>
 -->

        </div>
      </div>
    </nav>
    <div class="flex-1 flex flex-row">
      <!-- Left Ad -->
      <div class="hidden lg:block w-0 lg:w-24 xl:w-32 flex-shrink-0">
        <div class="sticky top-8 flex flex-col items-center">
          <div id="left-adsense" class="w-full">
            <!-- Google AdSense vertical ad will be injected here -->
          </div>
        </div>
      </div>
      <!-- Main Content -->
      <main class="flex-1">
        <slot />
      </main>
      <!-- Right Ad -->
      <div class="hidden lg:block w-0 lg:w-24 xl:w-32 flex-shrink-0">
        <div class="sticky top-8 flex flex-col items-center">
          <div id="right-adsense" class="w-full">
            <!-- Google AdSense vertical ad will be injected here -->
          </div>
        </div>
      </div>
    </div>
    <footer class="bg-white dark:bg-gray-900">
      <div class="container flex flex-col items-center justify-between px-6 py-8 mx-auto lg:flex-row">
        <Link href="/" class="flex items-center text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400">
          Home
        </Link>
        <div class="flex flex-wrap items-center justify-center gap-4 mt-6 lg:gap-6 lg:mt-0">
            <Link href="/about" class="text-sm text-gray-600 transition-colors duration-300 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400">
                About
          </Link>
          <Link href="/privacy" class="text-sm text-gray-600 transition-colors duration-300 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400">
            Privacy
          </Link>
        </div>
        <p class="mt-6 text-sm text-gray-500 lg:mt-0 dark:text-gray-400">© Copyright 2023 Meraki UI. </p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'

const logoUrl = '/favicon_io/android-chrome-192x192.png'

onMounted(() => {
  // Inject AdSense script only once
  if (!document.querySelector('script[src*="adsbygoogle.js"]')) {
    const script = document.createElement('script')
    script.async = true
    script.src = "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3574329224038401"
    script.crossOrigin = "anonymous"
    document.head.appendChild(script)
  }
  // Insert ad containers
  const adHtml = `
    <ins class="adsbygoogle"
      style="display:block"
      data-ad-client="ca-pub-3574329224038401"
      data-ad-slot="5373666439"
      data-ad-format="auto"
      data-full-width-responsive="true"></ins>
  `
  const left = document.getElementById('left-adsense')
  const right = document.getElementById('right-adsense')
  if (left && !left.innerHTML) left.innerHTML = adHtml
  if (right && !right.innerHTML) right.innerHTML = adHtml
  // Trigger adsbygoogle
  setTimeout(() => {
    if (window.adsbygoogle) {
      try { (window.adsbygoogle = window.adsbygoogle || []).push({}); } catch (e) {}
    }
  }, 500)
})
</script>
