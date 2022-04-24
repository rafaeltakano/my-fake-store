<template>
  <div>
    <Head :title="title" />

    <div class="viewport-loading" v-if="isloading">
      <div class="text-center">
        <Spinner />
      </div>
    </div>

    <div class="viewport" v-else>
      <div class="viewport__navbar flex flex-col">
        <NavBar>
          <template #nav-mobile>
            <NavBarMobile :apiData="apiData" :open="open" @close="open = false" />
          </template>

          <template #nav-mobile-sandwich>
            <button
              type="button"
              class="bg-white p-2 rounded-md text-gray-400 lg:hidden"
              @click="open = true"
            >
              <span class="sr-only">Open menu</span>
              <MenuIcon class="h-6 w-6" aria-hidden="true" />
            </button>
          </template>

          <template #nav-popover>
            <NavBarPopover :apiData="apiData" :open="open" @add-item="addToCart" />
          </template>

          <template #nav-search-input>
            <NavBarSearch :options="options" />
          </template>

          <template #nav-shopping-bag>
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
              @checkout="checkout"
            />
            <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">
              {{ cartTrackNumber }}
            </span>
            <span class="sr-only">items in cart, view bag</span>
          </template>
        </NavBar>
      </div>

      <div class="viewport__content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <slot name="content" :addProduct="addToCart"> </slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, toRaw } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
import Alert from '@/Jetstream/Commons/Alert.vue'
import Spinner from '@/Jetstream/Commons/Spinner.vue'
import NavBar from '@/Jetstream/NavBar/NavBar.vue'
import NavBarMobile from '@/Jetstream/NavBar/NavBarMobile.vue'
import NavBarPopover from '@/Jetstream/NavBar/NavBarPopover.vue'
import NavBarSearch from '@/Jetstream/NavBar/NavBarSearch.vue'
import NavBarBag from '@/Jetstream/NavBar/NavBarBag.vue'
import { MenuIcon, SearchIcon, ShoppingBagIcon } from '@heroicons/vue/outline'
import Swal from 'sweetalert2'

const apiData = ref([])
const isloading = ref(false)
const options = ref([])

const open = ref(false)
const cart = ref(false)
const cartProducts = ref([])
const cartTrackNumber = ref(0)

const categories = async () => {
  const { data } = await axios.get('https://fakestoreapi.com/products/categories')
  return data
}

const products = async () => {
  const { data } = await axios.get('https://fakestoreapi.com/products')
  return data
}

const handleApi = async (categories, products) => {
  let treatedApi = new Object()

  categories.filter((item) => {
    treatedApi[item] = new Array()
  })

  Object.values(products).filter((item) => {
    treatedApi[item.category].push(item)
  })

  return treatedApi
}

const handleCart = () => {
  if (sessionStorage.getItem('sessionCart')) {
    cartProducts.value = JSON.parse(sessionStorage.getItem('sessionCart'))
    cartTrackNumber.value = JSON.parse(sessionStorage.getItem('sessionCartTrackNumber'))
    return true
  }

  sessionStorage.setItem('sessionCart', '')
  sessionStorage.setItem('sessionCartTrackNumber', 0)
  return false
}

const pushFromNavToCart = (exists, product, productIdx) => {
  if (!exists) {
    product.quantity = 1
    cartProducts.value.push(product)
    cartTrackNumber.value++
  } else {
    cartProducts.value[productIdx].quantity++
    cartTrackNumber.value++
  }
}

const pushFromProductToCart = (exists, product, productIdx) => {
  if (!exists) {
    cartProducts.value.push(product)
    cartTrackNumber.value += product.quantity
  } else {
    cartProducts.value[productIdx].quantity += product.quantity
    cartTrackNumber.value += product.quantity
  }
}

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 1500,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  },
})

const addToCart = (item) => {
  const cart = cartProducts.value
  const product = { ...item }
  let exists = false
  let productIdx = null

  Object.entries(cart).filter(([index, value]) => {
    Object.keys(value).filter((item) => {
      if (value[item] !== product.id) return item
      productIdx = index
      exists = true
    })
  })

  if (!('quantity' in product)) {
    pushFromNavToCart(exists, product, productIdx)
  } else {
    pushFromProductToCart(exists, product, productIdx)
  }

  sessionStorage.setItem('sessionCart', JSON.stringify(cartProducts.value))
  sessionStorage.setItem('sessionCartTrackNumber', JSON.stringify(cartTrackNumber.value))

  Toast.fire({
    icon: 'success',
    title: 'your item has been successfully added',
  })
}

const removeFromCart = (item) => {
  const cart = cartProducts.value
  const product = { ...item }

  cartProducts.value = Object.values(cart).filter((value) => {
    if (value.id !== product.id) return value
  })

  cartTrackNumber.value = cartTrackNumber.value - product.quantity

  if (cartTrackNumber.value < 0) cartTrackNumber.value = 0
}

const checkout = () => {
  if (cartProducts.value.length < 1)
    return Swal.fire(
      'Oops...',
      'there should be at least one item in the bag to checkout 😅',
      'warning'
    )

  cartProducts.value = []
  cartTrackNumber.value = 0
  sessionStorage.setItem('sessionCart', '')
  sessionStorage.setItem('sessionCartTrackNumber', 0)

  Swal.fire(
    'Checkout successfully!',
    'please, try this demo out as much as you want! 😁',
    'success'
  )
}

onMounted(async () => {
  try {
    isloading.value = true

    const [cat, prod] = await Promise.all([categories(), products()])

    apiData.value = await handleApi(cat, prod)

    options.value = prod

    handleCart()

    isloading.value = false
  } catch (exception) {
    Swal.fire(
      'Oops...',
      'Please, refresh the page, sometimes fakestoreapi blocks localhost and this happens 😅',
      'info'
    )
  } finally {
    return {
      isloading,
      apiData,
    }
  }
})

const props = defineProps({
  title: [String, Number],
  storeProduct: Object,
})
</script>

<style scoped>
.viewport-loading {
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>

