<script setup>
import { PlusCircleIcon } from '@heroicons/vue/outline'

defineProps({
  id: Number,
  image: String,
  product: String,
  rate: Number,
  price: Number,
  blur: Boolean,
})

const rateArr = (rate) => {
  const length = Math.round(rate)
  return new Array(length)
}
</script>

<template>
  <div class="relative">
    <div :class="blur ? 'blur-sm brightness-50 cursor-pointer' : ''">
      <div class="max-w-sm bg-gray-100 rounded-lg shadow-md">
        <a>
          <img class="p-8 rounded-t-lg object-contain h-44 w-80" :src="image" alt="product image" />
        </a>
        <div class="px-5 pb-5">
          <a>
            <h5 class="text-xl font-semibold tracking-tight text-gray-900 text-nowrap-ellipsis">
              {{ product }}
            </h5>
          </a>
          <div class="flex items-center mt-2.5 mb-5">
            <svg
              v-for="(rate, index) in rateArr(rate)"
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

            <span
              class="bg-indigo-100 text-indigo-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded"
            >
              {{ rate }}
            </span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-3xl font-bold text-gray-900">${{ price }}</span>
            <a
              :class="blur ? '' : 'hover:bg-indigo-800'"
              class="text-white bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer"
              @click="blur ? null : $emit('add-item', id)"
            >
              Add to cart
            </a>
          </div>
        </div>
      </div>
    </div>
    <div v-if="blur" class="text-white text-2xl font-bold absolute-center cursor-pointer">
      <PlusCircleIcon class="h-40 w-40" aria-hidden="true" />
    </div>
  </div>
</template>

<style scoped>
.absolute-center {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.text-nowrap-ellipsis {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>

