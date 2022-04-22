<script setup>
import { ref, onMounted, isProxy, toRaw } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Rating from '@/Jetstream/Commons/Rating.vue'
import FmInputNumber from '@/Jetstream/Commons/FmInputNumber.vue'

const isloading = ref(false)

const apiData = ref([])

const apiErrors = ref('')

const product = ref({ quantity: 0 })

const options = ref([])

const categories = async () => {
  const { data } = await axios.get('https://fakestoreapi.com/products/categories')
  return data
}

const products = async () => {
  const { data } = await axios.get('https://fakestoreapi.com/products')
  return data
}

const productsById = async (productID) => {
  const { data } = await axios.get(`https://fakestoreapi.com/products/${productID}`)
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

onMounted(async () => {
  try {
    isloading.value = true

    const [cat, prod] = await Promise.all([categories(), products()])

    apiData.value = await handleApi(cat, prod)

    product.value = await productsById(toRaw(props.id))

    options.value = prod

    isloading.value = false
  } catch (exception) {
    apiErrors.value = exception
  } finally {
    return {
      isloading,
      apiData,
      apiErrors,
    }
  }
})

const props = defineProps({
  id: [String, Number],
})
</script>

<template>
  <AppLayout
    :title="product?.title || 'Product'"
    :isloading="isloading"
    :apiData="apiData"
    :apiErrors="apiErrors"
    :options="options"
  >
    <template #content>
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
                @click="$emit('add-item', product.id)"
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

