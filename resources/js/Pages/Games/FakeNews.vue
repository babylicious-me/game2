<script setup>
import MainLayout from '../Layout/MainLayout.vue'
import { ref, onMounted } from 'vue'
import axios from 'axios'

const question = ref(null)
const nextQuestion = ref(null)
const result = ref(null)
const score = ref({ correct: 0, answered: 0 })
const loading = ref(true)
const preloading = ref(false)

async function fetchQuestionAndPreload() {
  loading.value = true
  result.value = null
  const res = await axios.get('/api/fake-news/random')
  question.value = res.data.question
  score.value = res.data.score
  loading.value = false
  preloadNextQuestion()
}

async function preloadNextQuestion() {
  preloading.value = true
  try {
    const res = await axios.get('/api/fake-news/random')
    nextQuestion.value = res.data.question
  } finally {
    preloading.value = false
  }
}

async function answer(choice) {
  if (!question.value) return
  loading.value = true
  try {
    const res = await axios.post('/api/fake-news/answer', {
      id: question.value.id,
      answer: choice,
    })
    result.value = res.data.result
    score.value = res.data.score
  } finally {
    loading.value = false
  }
}

function next() {
  if (nextQuestion.value) {
    question.value = nextQuestion.value
    result.value = null
    nextQuestion.value = null
    preloadNextQuestion()
  } else {
    fetchQuestionAndPreload()
  }
}

onMounted(fetchQuestionAndPreload)
</script>

<template>
  <MainLayout>
    <div class="flex items-center justify-center py-8 px-2 min-h-[60vh]">
      <div class="w-full max-w-xl bg-gray-900 p-4 sm:p-8 text-center flex flex-col justify-center items-center">
        <div class="mb-6 flex flex-col items-center">
          <h1 class="text-3xl font-bold text-pink-400 mb-4">Fake News or Real?</h1>
          <div class="text-gray-200 text-sm mb-2">
            Score: <span class="font-bold text-pink-400">{{ score.correct }}</span> / <span class="font-bold">{{ score.answered }}</span>
          </div>
        </div>
        <div v-if="question" class="mb-8 text-2xl text-gray-200 font-medium min-h-[3rem]">
          <span>{{ question.headline }}</span>
        </div>
        <div v-if="!result && question" class="flex justify-center gap-6 mb-8">
          <button
            class="px-6 py-2 rounded bg-green-500 text-white font-bold hover:bg-green-600 transition text-lg"
            :disabled="loading"
            @click="answer('real')"
          >Real</button>
          <button
            class="px-6 py-2 rounded bg-red-500 text-white font-bold hover:bg-red-600 transition text-lg"
            :disabled="loading"
            @click="answer('fake')"
          >Fake</button>
        </div>
        <div v-if="result" class="mt-6">
          <div v-if="result.correct" class="text-green-400 font-bold text-lg mb-2">Correct!</div>
          <div v-else class="text-red-400 font-bold text-lg mb-2">Wrong!</div>
          <div class="text-gray-200 mb-4">
            <span class="font-semibold">Source:</span>
            <br>
            <span class="italic">{{ result.source || 'Unknown' }}</span>
          </div>
          <button
            class="mt-6 px-6 py-2 rounded bg-blue-600 text-white font-semibold hover:bg-blue-900 transition"
            :disabled="preloading"
            @click="next"
          >
            Next Question
          </button>
        </div>
      </div>
    </div>
  </MainLayout>
</template>
