<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import MainLayout from './Layout/MainLayout.vue'

const route = usePage().props?.ziggy?.route ?? window.route // fallback for route helper

const games = [
  {
    title: 'Truth or Lie',
    emoji: '🕵️',
    description: 'Test your friends with tricky truths and clever lies.',
    link: '/truth-or-lie'
  },
  {
    title: 'Would You Rather',
    emoji: '🔥',
    description: 'Choose between two fun and challenging scenarios.',
    link: '/would-you-rather'
  },
  {
    title: 'Two Truths & One Lie',
    emoji: '🥸',
    description: 'Can you spot the lie among the truths?',
    link: '/two-truths-one-lie'
  },
  {
    title: 'Fake News or Real?',
    emoji: '📰',
    description: 'Detect what’s real and what’s fake in the news.',
    link: '/fake-news'
  }
]
</script>

<template>
  <MainLayout>
    <section class="container mx-auto px-2 sm:px-4 py-8 sm:py-16">
      <div class="flex flex-col items-center justify-center mb-8">
        <h1 class="font-bold text-2xl sm:text-3xl text-lime-400 z-10 relative">Games</h1>
        <p
          class="mt-2 text-gray-900 dark:text-gray-100 text-base sm:text-lg max-w-xs sm:max-w-2xl text-center font-medium"
          style="min-height:2.5rem;"
          aria-label="Game introduction"
        >
          Discover, play, and enjoy games that bring people together!
        </p>
      </div>
      <div class="grid grid-cols-1 gap-6 sm:gap-8 md:grid-cols-2 xl:grid-cols-4 mt-8 sm:mt-12">
        <Link
          v-for="game in games"
          :key="game.title"
          :href="game.link"
          class="flex flex-col h-full bg-gray-800 rounded-xl shadow-lg border border-gray-200 transition hover:shadow-2xl hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-sky-500 group"
          style="text-decoration: none;"
          aria-label="Play {{ game.title }}"
        >
          <div class="flex flex-col flex-1 justify-between p-4 sm:p-6">
            <div>
              <span class="text-lime-400 uppercase tracking-wider flex items-center gap-2">
                <span class="text-2xl">{{ game.emoji }}</span>
                <span class="font-bold text-base sm:text-lg">{{ game.title }}</span>
              </span>
              <p
                class="mt-2 text-gray-400 text-sm sm:text-base"
                style="min-height:2.5rem;"
                aria-label="Game description"
              >
                {{ game.description }}
              </p>
            </div>
          </div>
        </Link>
      </div>
    </section>
  </MainLayout>
</template>
