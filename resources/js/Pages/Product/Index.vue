<script setup>
import { ref, onMounted, toRaw } from 'vue'
import Swal from 'sweetalert2'
import { ShoppingCartIcon, ShieldCheckIcon } from '@heroicons/vue/outline'
import AppLayout from '@/Layouts/AppLayout.vue'
import ColorPicker from '@/Jetstream/Commons/ColorPicker.vue'
import FmInputNumber from '@/Jetstream/Commons/FmInputNumber.vue'
import ImagePicker from '@/Jetstream/Commons/ImagePicker.vue'
import Rating from '@/Jetstream/Commons/Rating.vue'
import SizePicker from '@/Jetstream/Commons/SizePicker.vue'
import Comments from '@/Pages/Product/Comments.vue'

const product = ref({ quantity: 0 })

const productsById = async (productID) => {
  const { data } = await axios.get(`https://fakestoreapi.com/products/${productID}`)
  return data
}

const clearFilters = (product) => {
  product.quantity = 0
}

const customers = [
  { name: 'Alan Turing' },
  { name: 'Grace Hopper' },
  { name: 'Dennis Ritchie' },
  { name: 'Margaret Hamilton' },
]

onMounted(async () => {
  try {
    product.value = await productsById(toRaw(props.id))
    product.value.quantity = 0
  } catch (exception) {
    Swal.fire(
      'Oops...',
      'Please, refresh the page, sometimes fakestoreapi blocks localhost and this happens 😅',
      'info'
    )
  }
})

const props = defineProps({
  id: [String, Number],
})
</script>

<template>
  <AppLayout :title="product?.title || 'Product'" :storeProduct="toRaw(product)">
    <template #content="{ addProduct }">
      <section :id="`section-product-${product?.id}`">
        <div class="product-container">
          <div class="product-container__image my-4">
            <div class="product-image">
              <img class="image" :src="product?.image" :alt="product?.title" />
            </div>
            <div class="product-image-picker my-4">
              <ImagePicker :customUrl="product?.image" />
            </div>
          </div>

          <div class="product-container--wrapper">
            <div class="product-container__header my-4">
              <h1 class="font-bold">{{ product?.title }}</h1>
            </div>

            <div class="product-container__rating my-4">
              <div class="rate">
                <Rating :rate="product?.rating?.rate" />
              </div>
              <a class="count"> ({{ product?.rating?.count }} ratings) </a>
            </div>

            <div class="product-container__colors my-4">
              <h3 class="font-bold">Colors: <span class="font-normal">(display only)</span></h3>
              <div class="colors px-4 py-2">
                <ColorPicker />
              </div>
            </div>

            <div class="product-container__sizes my-4">
              <h3 class="font-bold">Sizes: <span class="font-normal">(display only)</span></h3>
              <div class="sizes px-4 py-2">
                <SizePicker />
              </div>
            </div>

            <div class="product-container__description my-4">
              <h3 class="font-bold"> Description: </h3>
              <p class="font-normal text-gray-500">#{{ product.category }}</p>
              <p class="font-normal">{{ product.description }}</p>
            </div>

            <div class="product-container__checkout my-4">
              <h3 class="font-bold"> Checkout: </h3>
              <div class="quantity">
                <label class="font-normal mr-4">Quantity</label>
                <FmInputNumber v-model="product.quantity" />
              </div>
              <div class="add-to-cart">
                <button
                  class="text-white bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer w-full mt-4"
                  @click=";[addProduct(product), clearFilters(product)]"
                  :disabled="product?.quantity > 0 ? false : true"
                >
                  Add to cart
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="section-shipping">
        <div class="shipping-wrapper">
          <div class="shipping-container">
            <div class="shipping-container-icon">
              <ShoppingCartIcon class="h-6 w-6 text-green-500" aria-hidden="true" />
            </div>
            <div class="shipping-container-text">
              <h3 class="font-bold">Free Shipping!</h3>
              <p class="font-normal">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet laborum, assumenda
                soluta rem beatae perspiciatis!
              </p>
            </div>
          </div>

          <div class="shipping-container">
            <div class="shipping-container-icon">
              <ShieldCheckIcon class="h-6 w-6 text-green-500" aria-hidden="true" />
            </div>
            <div class="shipping-container-text">
              <h3 class="font-bold">Free Returns!</h3>
              <p class="font-normal">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet laborum, assumenda
                soluta rem beatae perspiciatis!
              </p>
            </div>
          </div>
        </div>
      </section>

      <section id="section-comments">
        <div class="comments-container my-4">
          <h1 class="font-bold">Comments:</h1>
          <hr class="hr" />
          <Comments v-for="(customer, index) in customers" :key="index" :customer="customer" />
        </div>
      </section>
    </template>
  </AppLayout>
</template>

<style scoped>
.hr {
  border: 1px solid lightgray;
  margin: 1rem 0;
  width: 100%;
}

.image {
  max-height: 350px;
  width: auto;
}

.button-wrapper {
  text-align: center;
}

.product-container {
  margin-top: 4rem;
}

.product-image {
  display: flex;
  justify-content: center;
  overflow: hidden;
}

.product-container__rating {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.shipping-wrapper {
  background-color: #f5f5f5;
  padding: 2rem 4rem;
}

.shipping-container {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin: 1rem 0;
}

@media (min-width: 1024px) {
  .product-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    align-items: center;
  }
}
</style>

