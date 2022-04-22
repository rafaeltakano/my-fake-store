<script setup>
import { PlusCircleIcon } from '@heroicons/vue/outline'
import Rating from '@/Jetstream/Commons/Rating.vue'

defineProps({
  id: Number,
  image: String,
  product: String,
  rate: Number,
  price: Number,
  blur: Boolean,
})
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
          <Rating :rate="rate" />
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

