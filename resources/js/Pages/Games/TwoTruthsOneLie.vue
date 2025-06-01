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
  const res = await axios.get('/api/two-truths-one-lie/random')
  question.value = res.data.question
  score.value = res.data.score
  loading.value = false
  preloadNextQuestion()
}

async function preloadNextQuestion() {
  preloading.value = true
  try {
    const res = await axios.get('/api/two-truths-one-lie/random')
    nextQuestion.value = res.data.question
  } finally {
    preloading.value = false
  }
}

async function answer(index) {
  if (!question.value) return
  loading.value = true
  try {
    const res = await axios.post('/api/two-truths-one-lie/answer', {
      id: question.value.id,
      answer: index,
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
          <h1 class="text-3xl font-bold text-lime-400 mb-4">Two Truths & One Lie</h1>
          <div class="text-gray-200 text-sm mb-2">
            Score: <span class="font-bold text-yellow-400">{{ score.correct }}</span> / <span class="font-bold">{{ score.answered }}</span>
          </div>
        </div>
        <div v-if="question" class="mb-8 flex flex-col gap-4">
          <button
            v-for="(statement, idx) in [question.statement_1, question.statement_2, question.statement_3]"
            :key="idx"
            class="px-6 py-4 rounded bg-gray-800 text-white font-bold hover:bg-lime-600 transition text-lg"
            :disabled="loading || !!result"
            @click="answer(idx + 1)"
          >
            {{ statement }}
          </button>
        </div>
        <div v-if="result" class="mt-6">
          <div v-if="result.correct" class="text-green-400 font-bold text-lg mb-2">Correct! You found the lie.</div>
          <div v-else class="text-red-400 font-bold text-lg mb-2">Wrong! That was not the lie.</div>
          <div class="text-gray-200 mb-4">
            <span class="font-semibold">The lie was:</span>
            <br>
            <span class="italic">{{ result.lie }}</span>
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
