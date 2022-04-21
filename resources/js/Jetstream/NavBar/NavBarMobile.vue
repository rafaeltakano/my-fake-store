<script setup>
import {
  Dialog,
  DialogOverlay,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { XIcon } from '@heroicons/vue/outline'

const featured = [
  {
    name: 'New Arrivals',
    href: '#',
    imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-category-01.jpg',
    imageAlt: 'Models sitting back to back, wearing Basic Tee in black and bone.',
  },
  {
    name: 'Basic Tees',
    href: '#',
    imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-category-02.jpg',
    imageAlt: 'Close up of Basic Tee fall bundle with off-white, ochre, olive, and black tees.',
  },
]

defineProps({
  apiData: Object,
  open: Boolean,
})
</script>

<template>
  <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="fixed inset-0 flex z-40 lg:hidden" @close="$emit('close')">
      <TransitionChild
        as="template"
        enter="transition-opacity ease-linear duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="transition-opacity ease-linear duration-300"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <DialogOverlay class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <TransitionChild
        as="template"
        enter="transition ease-in-out duration-300 transform"
        enter-from="-translate-x-full"
        enter-to="translate-x-0"
        leave="transition ease-in-out duration-300 transform"
        leave-from="translate-x-0"
        leave-to="-translate-x-full"
      >
        <div
          class="relative max-w-xs w-full bg-white shadow-xl pb-12 flex flex-col overflow-y-auto"
        >
          <div class="px-4 pt-5 pb-2 flex">
            <button
              type="button"
              class="-m-2 p-2 rounded-md inline-flex items-center justify-center text-gray-400"
              @click="$emit('close')"
            >
              <span class="sr-only">Close menu</span>
              <XIcon class="h-6 w-6" aria-hidden="true" />
            </button>
          </div>

          <!-- Links -->
          <div class="pt-10 pb-8 px-4 space-y-10">
            <div class="grid grid-cols-2 gap-x-4">
              <!-- Featured -->
              <div v-for="(feature, index) in featured" :key="index" class="group relative text-sm">
                <div
                  class="aspect-w-1 aspect-h-1 rounded-lg bg-gray-100 overflow-hidden group-hover:opacity-75"
                >
                  <img
                    :src="feature.imageSrc"
                    :alt="feature.imageAlt"
                    class="object-center object-cover"
                  />
                </div>
                <a :href="feature.href" class="mt-6 block font-medium text-gray-900">
                  <span class="absolute z-10 inset-0" aria-hidden="true" />
                  {{ feature.name }}
                </a>
                <p aria-hidden="true" class="mt-1">Shop now</p>
              </div>
            </div>

            <!-- Categories -->
            <div v-for="(category, index) in apiData" :key="index">
              <p
                :id="`${index}-heading-mobile`"
                class="font-medium text-gray-900 first-letter:uppercase"
              >
                {{ index }}
              </p>
              <ul
                role="list"
                :aria-labelledby="`${index}-heading-mobile`"
                class="mt-6 flex flex-col space-y-6"
              >
                <li v-for="(product, index) in category" :key="index" class="flow-root">
                  <a :href="'#'" class="-m-2 p-2 block text-gray-500">
                    {{ product.title }}
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </TransitionChild>
    </Dialog>
  </TransitionRoot>
</template>

