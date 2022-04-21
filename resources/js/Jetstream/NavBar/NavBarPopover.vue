<script setup>
import { PopoverGroup, Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
import CommerceCard from '@/Jetstream/Commons/CommerceCard.vue'

defineProps({
  apiData: Object,
  open: Boolean,
})
</script>

<template>
  <PopoverGroup class="hidden lg:ml-8 lg:block lg:self-stretch">
    <div class="h-full flex space-x-8">
      <Popover
        v-for="(products, category) in apiData"
        :key="category"
        class="flex"
        v-slot="{ open }"
      >
        <div class="relative flex">
          <PopoverButton
            :class="[
              open
                ? 'border-indigo-600 text-indigo-600'
                : 'border-transparent text-gray-700 hover:text-gray-800',
              'relative z-10 flex items-center transition-colors ease-out duration-200 text-sm font-medium border-b-2 -mb-px pt-px',
            ]"
          >
            <span class="first-letter:uppercase">{{ category }}</span>
          </PopoverButton>
        </div>

        <transition
          enter-active-class="transition ease-out duration-200"
          enter-from-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="transition ease-in duration-150"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <PopoverPanel class="absolute top-full inset-x-0 text-sm text-gray-500">
            <!-- Presentational element used to render the bottom shadow, if we put the shadow on the actual panel it pokes out the top, so we use this shorter element to hide the top of the shadow -->
            <div class="absolute inset-0 top-1/2 bg-white shadow" aria-hidden="true" />

            <div class="relative bg-white">
              <div class="max-w-7xl mx-auto px-8">
                <div class="grid grid-cols-3 gap-4 p-4">
                  <div v-for="(product, index) in products" :key="index">
                    <CommerceCard
                      v-if="index < 3"
                      :id="product.id"
                      :image="product.image"
                      :product="product.title"
                      :rate="product.rating.rate"
                      :price="product.price"
                      :blur="index < 2 ? false : true"
                    />
                  </div>
                </div>
              </div>
            </div>
          </PopoverPanel>
        </transition>
      </Popover>
    </div>
  </PopoverGroup>
</template>

