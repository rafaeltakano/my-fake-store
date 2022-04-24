<script setup>
import { PlusCircleIcon } from '@heroicons/vue/outline'
import Rating from '@/Jetstream/Commons/Rating.vue'
import { Link } from '@inertiajs/inertia-vue3'

defineProps({
  id: Number,
  image: String,
  product: String,
  rate: Number,
  price: Number,
  category: String,
  blur: Boolean,
})
</script>

<template>
  <Link v-if="blur" :href="route('categories')" :data="{ category: category }">
    <div class="relative">
      <div class="blur-sm brightness-50 cursor-pointer">
        <div class="max-w-sm bg-gray-100 rounded-lg shadow-md">
          <Link class="product-image" :href="route('categories')" :data="{ category: category }">
            <div class="circular--landscape">
              <img class="image" :src="image" alt="product image" />
            </div>
          </Link>
          <div class="px-5 pb-5">
            <Link :href="route('categories')" :data="{ category: category }">
              <h5 class="text-xl font-semibold tracking-tight text-gray-900 text-nowrap-ellipsis">
                {{ product }}
              </h5>
            </Link>
            <Rating :rate="rate" />
            <div class="flex justify-between items-center">
              <span class="text-3xl font-bold text-gray-900">${{ price }}</span>
              <a
                class="text-white bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer"
              >
                Add to cart
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="text-white text-2xl font-bold absolute-center cursor-pointer">
        <PlusCircleIcon class="h-40 w-40" aria-hidden="true" />
      </div>
    </div>
  </Link>
  <!-- -->
  <div class="relative" v-else>
    <div>
      <div class="max-w-sm bg-gray-100 rounded-lg shadow-md">
        <Link class="product-image" :href="route('product')" :data="{ id: id }">
          <div class="circular--landscape">
            <img class="image" :src="image" alt="product image" />
          </div>
        </Link>
        <div class="px-5 pb-5">
          <Link :href="route('product')" :data="{ id: id }">
            <h5 class="text-xl font-semibold tracking-tight text-gray-900 text-nowrap-ellipsis">
              {{ product }}
            </h5>
          </Link>
          <Rating :rate="rate" />
          <div class="flex justify-between items-center">
            <span class="text-3xl font-bold text-gray-900">${{ price }}</span>
            <a
              class="text-white hover:bg-indigo-800 bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer"
              @click="$emit('add-item', id)"
            >
              Add to cart
            </a>
          </div>
        </div>
      </div>
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

.product-image {
  border-radius: 1rem;
  min-height: 150px;
  min-width: 150px;
  overflow: hidden;
  display: flex;
  justify-content: center;
  padding-top: 0.5rem;
}

.circular--landscape {
  border-radius: 50%;
  height: 150px;
  width: 150px;
  overflow: hidden;
}

.image {
  height: 150px;
  width: 150px;
  background-color: #ffffff;
}
</style>

