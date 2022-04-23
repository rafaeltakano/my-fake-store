<script setup>
import { ref, onMounted, toRaw } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Rating from '@/Jetstream/Commons/Rating.vue'
import FmInputNumber from '@/Jetstream/Commons/FmInputNumber.vue'
import Swal from 'sweetalert2'

const product = ref({ quantity: 0 })

const productsById = async (productID) => {
  const { data } = await axios.get(`https://fakestoreapi.com/products/${productID}`)
  return data
}

const clearFilters = (product) => {
  product.quantity = 0
}

onMounted(async () => {
  try {
    product.value = await productsById(toRaw(props.id))
  } catch (exception) {
    Swal.fire(exception, 'Please, refresh the page, somethimes this happens 😅', 'warning')
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
          <div class="product-img-container">
            <img class="img" :src="product?.image" :alt="product?.title" />
          </div>

          <div class="product-desc-container">
            <h1 class="font-bold">{{ product?.title }}</h1>
            <Rating :rate="product?.rating?.rate" />
            <p class="font-normal"> Price: ${{ product.price }} </p>
            <hr class="hr" />
            <h3 class="font-normal">{{ product.description }}</h3>
          </div>

          <div class="product-shopping-container">
            <hr class="hr hr--checkout" />
            <h1 class="font-bold checkout-text">Checkout</h1>
            <br />
            <div class="checkout-container">
              <div>
                <label class="font-normal mr-4">Quantity</label>
                <FmInputNumber v-model="product.quantity" />
              </div>
              <button
                class="button text-white bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer w-full"
                @click=";[addProduct(product), clearFilters(product)]"
                :disabled="product?.quantity > 0 ? false : true"
              >
                Add to cart
              </button>
            </div>
          </div>
        </div>
      </section>
    </template>
  </AppLayout>
</template>

<style scoped>
.product-img-container {
  display: flex;
  justify-content: center;
  overflow: hidden;
  padding: 1rem;
}

.product-img-container .img {
  border: 1px solid lightgray;
  border-radius: 1rem;
  height: 350px;
}

.product-desc-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 1rem;
}

.product-shopping-container {
  padding: 1rem;
}

.checkout-container {
  display: grid;
  justify-items: center;
  gap: 1rem;
}

.hr {
  border: 1px solid lightgray;
  margin: 1rem 0;
  width: 100%;
}

@media (min-width: 768px) {
  .product-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
  }

  .product-shopping-container {
    grid-column: 1/3;
  }
}

@media (min-width: 1280px) {
  .product-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
  }

  .product-shopping-container {
    grid-column: auto;
  }

  .checkout-text {
    text-align: center;
  }

  .button {
    width: 80%;
  }

  .hr--checkout {
    display: none;
  }
}
</style>

