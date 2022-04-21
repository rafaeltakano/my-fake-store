<script setup>
defineProps({
  error: String,
})
</script>

<template>
  <div
    id="alert-additional-content-1"
    class="p-4 mb-4 bg-blue-100 rounded-lg dark:bg-blue-200"
    role="alert"
  >
    <div class="flex items-center">
      <svg
        class="mr-2 w-5 h-5 text-blue-700 dark:text-blue-800"
        fill="currentColor"
        viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          fill-rule="evenodd"
          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
          clip-rule="evenodd"
        ></path>
      </svg>
      <p class="text-lg font-medium text-blue-700 dark:text-blue-800">
        {{ error }}
      </p>
    </div>
    <div class="mt-2 mb-4 text-sm text-blue-700 dark:text-blue-800">
      <p>
        Please, refresh your browser, sometimes the fakestoreapi refuses the conection, this is a
        normal behavior.</p
      >
    </div>
  </div>
</template>

