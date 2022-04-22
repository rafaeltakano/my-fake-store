<script setup>
import { ref, onMounted } from 'vue'
import { MenuIcon, SearchIcon, ShoppingBagIcon } from '@heroicons/vue/outline'
import NavBarMobile from '@/Jetstream/NavBar/NavBarMobile.vue'
import NavBarPopover from '@/Jetstream/NavBar/NavBarPopover.vue'
import NavBarBag from '@/Jetstream/NavBar/NavBarBag.vue'
import { createToast } from 'mosha-vue-toastify'
import 'mosha-vue-toastify/dist/style.css'

const open = ref(false)

const cart = ref(false)

const cartProducts = ref([])

const cartTrackNumber = ref(0)

const addToCart = (item) => {
  const cart = cartProducts.value
  const product = { ...item }
  let exists = false

  Object.entries(cart).filter(([index, value]) => {
    Object.keys(value).filter((item) => {
      if (value[item] !== product.id) return item
      cartProducts.value[index].quantity++
      exists = true
    })
  })

  if (!exists) {
    product.quantity = 1
    cartProducts.value.push(product)
  }

  cartTrackNumber.value++

  createToast(
    {
      title: 'Success!',
      description: 'your item has been successfully added',
    },
    {
      timeout: 1500,
      position: 'top-center',
      toastBackgroundColor: '#28a745',
    }
  )
}

const removeFromCart = (item) => {
  const cart = cartProducts.value
  const product = { ...item }

  cartProducts.value = Object.values(cart).filter((value) => {
    if (value.id !== product.id) {
      return value
    }
  })

  if (product.quantity > cartTrackNumber.value) {
    cartTrackNumber.value = 0
  } else {
    cartTrackNumber.value = cartTrackNumber.value - product.quantity
  }
}

defineProps({
  apiData: Object,
})

onMounted(() => {
  return {
    open,
    cart,
    cartProducts,
    cartTrackNumber,
  }
})
</script>

<template>
  <div class="bg-white">
    <!-- Mobile menu -->
    <NavBarMobile :apiData="apiData" :open="open" @close="open = false" />

    <header class="relative bg-white">
      <nav aria-label="Top" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="border-b border-gray-200">
          <div class="h-16 flex items-center">
            <button
              type="button"
              class="bg-white p-2 rounded-md text-gray-400 lg:hidden"
              @click="open = true"
            >
              <span class="sr-only">Open menu</span>
              <MenuIcon class="h-6 w-6" aria-hidden="true" />
            </button>

            <!-- Logo -->
            <div class="ml-4 flex lg:ml-0">
              <a href="#">
                <span class="sr-only">Workflow</span>
                <img
                  class="h-8 w-auto"
                  src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&shade=600"
                  alt=""
                />
              </a>
            </div>

            <!-- Flyout menus -->
            <NavBarPopover :apiData="apiData" :open="open" @add-item="addToCart" />

            <div class="ml-auto flex items-center">
              <!-- Search -->
              <div class="flex lg:ml-6">
                <a href="#" class="p-2 text-gray-400 hover:text-gray-500">
                  <span class="sr-only">Search</span>
                  <SearchIcon class="w-6 h-6" aria-hidden="true" />
                </a>
              </div>

              <!-- Cart -->
              <div class="ml-4 flow-root lg:ml-6">
                <a href="#" class="group -m-2 p-2 flex items-center">
                  <ShoppingBagIcon
                    class="flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                    aria-hidden="true"
                    @click="cart = true"
                  />
                  <NavBarBag
                    :cartProducts="cartProducts"
                    :open="cart"
                    @close="cart = false"
                    @remove-item="removeFromCart"
                  />
                  <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">
                    {{ cartTrackNumber }}
                  </span>
                  <span class="sr-only">items in cart, view bag</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </header>
  </div>
</template>

