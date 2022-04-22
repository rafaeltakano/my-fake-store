<script setup>
import { toRaw } from 'vue'

const rateArr = (rate) => {
  const rateValue = toRaw(rate)
  const length = Math.round(rateValue)
  return new Array(length)
}

const props = defineProps({
  rate: Number,
})
</script>

<template>
  <div class="flex items-center mt-2.5 mb-5">
    <svg
      v-for="(stars, index) in rateArr(rate ?? 0)"
      :key="index"
      class="w-5 h-5 text-yellow-300"
      fill="currentColor"
      viewBox="0 0 20 20"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
      ></path>
    </svg>

    <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
      {{ rate }}
    </span>
  </div>
</template>

