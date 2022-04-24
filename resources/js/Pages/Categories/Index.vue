<script setup>
import { ref, onMounted, toRaw } from 'vue'
import Swal from 'sweetalert2'
import AppLayout from '@/Layouts/AppLayout.vue'
import FmInputRadio from '@/Jetstream/Commons/FmInputRadio.vue'
import FmSelect from '@/Jetstream/Commons/FmSelect.vue'
import Rating from '@/Jetstream/Commons/Rating.vue'
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
  category: String,
})

const products = ref([])

const productsView = ref([])

const radio = ref('all')

const select = ref('')

const categoriesArr = ref(['all', 'electronics', 'jewelery', "men's clothing", "women's clothing"])

const options = ref([
  { label: 'none', value: '' },
  { label: 'name', value: 'name' },
  { label: 'price', value: 'price' },
  { label: 'rating', value: 'rating' },
])

const fetchProducts = async () => {
  const { data } = await axios.get('https://fakestoreapi.com/products')
  return data
}

const sortByCategories = () => {
  if (toRaw(radio.value) == 'all') {
    productsView.value = [...toRaw(products.value)]
    return true
  }

  productsView.value = toRaw(products.value).filter((item) => item.category == toRaw(radio.value))

  sortByOptions()
}

const sortByOptions = () => {
  switch (toRaw(select.value)) {
    case '':
      toRaw(productsView.value).sort(function (a, b) {
        return a.id - b.id
      })
      break
    case 'name':
      toRaw(productsView.value).sort((a, b) => a.title.localeCompare(b.title))
      break
    case 'price':
      toRaw(productsView.value).sort(function (a, b) {
        return a.price - b.price
      })
      break
    case 'rating':
      toRaw(productsView.value).sort(function (a, b) {
        return a.rating.rate - b.rating.rate
      })
      break
  }
}

onMounted(async () => {
  try {
    products.value = await fetchProducts()

    productsView.value = [...toRaw(products.value)]

    radio.value = props.category ?? 'all'

    sortByCategories()
  } catch (exception) {
    console.log(exception)
    Swal.fire(
      'Oops...',
      'Please, refresh the page, sometimes fakestoreapi blocks localhost and this happens 😅',
      'info'
    )
  }
})
</script>

<template>
  <AppLayout :title="radio">
    <template #content>
      <section id="section-categories">
        <div class="categories-container__breadcrumbs my-4">
          <h1 class="font-normal">
            home/categories/<span class="font-bold">{{ radio }}</span>
          </h1>
        </div>

        <div class="categories-container--wrapper">
          <div class="categories-filter">
            <div class="input-group">
              <p class="font-bold">Categories:</p>
              <FmInputRadio
                v-for="(cat, index) in categoriesArr"
                v-model="radio"
                :key="index"
                :label="cat"
                @input-change="sortByCategories"
              >
                <span>{{ cat }}</span>
              </FmInputRadio>
            </div>
            <div class="sort-group">
              <p class="font-bold">Sort by:</p>
              <FmSelect v-model="select" :options="options" @select-change="sortByOptions" />
            </div>
          </div>
        </div>
      </section>

      <section id="section-products">
        <div class="products-container my-4">
          <div class="product" v-for="(product, index) in productsView" :key="index">
            <Link :href="route('product')" :data="{ id: product.id }">
              <div class="product-image">
                <div class="circular--landscape">
                  <img class="image" :src="product?.image" :alt="product?.title" />
                </div>
              </div>
              <hr class="hr" />
              <div class="product-name">
                <p class="font-bold">{{ product?.title }}</p>
              </div>
              <br />
              <div class="product-price">
                <p class="font-normal">${{ product?.price }}</p>
                <Rating :rate="product?.rating?.rate" />
              </div>
            </Link>
          </div>
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

.circular--landscape {
  border-radius: 50%;
  height: 200px;
  width: 200px;
  overflow: hidden;
}

.image {
  height: 200px;
  width: 200px;
  background-color: #ffffff;
}

.img-wrapper {
  width: fit-content;
  height: fit-content;
}

.input-group {
  display: flex;
  flex-direction: column;
}

.categories-container--wrapper {
  background-color: #f5f5f5;
  padding: 2rem;
}

.categories-filter {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
}

.product {
  background-color: #f5f5f5;
  padding: 1rem;
}

.product-image {
  border-radius: 1rem;
  min-height: 200px;
  min-width: 200px;
  overflow: hidden;
  display: flex;
  justify-content: center;
}

.product-price {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
}

.products-container {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
}

@media (min-width: 768px) {
  .products-container {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .products-container {
    grid-template-columns: repeat(3, 1fr);
  }
}
</style>

