<script setup>
import { ref, onMounted, toRaw } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import Swal from 'sweetalert2'
import AppLayout from '@/Layouts/AppLayout.vue'
import FeatureCard from '@/Jetstream/Commons/FeatureCard.vue'
import Rating from '@/Jetstream/Commons/Rating.vue'

const products = ref([])

const fetchProducts = async () => {
  if (sessionStorage.getItem('sessionProducts')) {
    return JSON.parse(sessionStorage.getItem('sessionProducts'))
  }

  const { data } = await axios.get('https://fakestoreapi.com/products')
  return data
}

onMounted(async () => {
  try {
    products.value = await fetchProducts()
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
  <AppLayout title="Home">
    <template #content>
      <section id="section-home">
        <div class="home-container">
          <div class="home-container__image">
            <div class="home-image">
              <img src="../../../images/brian-lawson-indigo-1968x1968.png" alt="brian-lawson" />
            </div>
          </div>
          <div class="home-container__text">
            <h1 class="font-bold text-white">Life is Fashion</h1>
          </div>
        </div>
      </section>

      <hr class="hr" />

      <section id="section-featured">
        <h1 class="font-bold font-responsive">Featured</h1>
        <div class="featured-container my-4">
          <Link :href="route('categories')" :data="{ category: 'electronics' }">
            <FeatureCard title="Electronics" text="Shop Now">
              <img src="../../../images/hyang-imant-1968x1968.png" alt="brian-lawson" />
            </FeatureCard>
          </Link>

          <Link :href="route('categories')" :data="{ category: 'jewelery' }">
            <FeatureCard title="Jewelery" text="Shop Now">
              <img src="../../../images/andres-vera-1968x1968.png" alt="brian-lawson" />
            </FeatureCard>
          </Link>

          <Link :href="route('categories')" :data="{ category: `men's clothing` }">
            <FeatureCard title="Men's clothing" text="Shop Now">
              <img src="../../../images/mark-west-1968x1968.png" alt="brian-lawson" />
            </FeatureCard>
          </Link>

          <Link :href="route('categories')" :data="{ category: `women's clothing` }">
            <FeatureCard title="Women's clothing" text="Shop Now">
              <img src="../../../images/monica-silva-1968x1968.png" alt="brian-lawson" />
            </FeatureCard>
          </Link>
        </div>
        <Link :href="route('categories')">
          <h3 class="font-bold text-right text-indigo-600">See all</h3>
        </Link>
      </section>

      <section id="section-products">
        <div class="products-container my-4">
          <div class="products-container__title">
            <h1 class="font-bold font-responsive">Trending This Month</h1>
          </div>
          <div class="products-container__content">
            <div class="product" v-for="(product, index) in products" :key="index">
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
        </div>
      </section>
    </template>
  </AppLayout>
</template>

<style scoped>
.hr {
  border: 1px solid transparent;
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
  transition: all 0.5s;
}

.image:hover {
  transform: scale(1.05);
  filter: brightness(1.1);
}

.font-responsive {
  font-size: clamp(2rem, 10vw, 3rem);
}

.home-container {
  background-color: #4338ca;
  position: relative;
  padding: 1rem;
}

.home-container__image {
  display: flex;
  justify-content: flex-end;
}

.home-image {
  border-radius: 50%;
  filter: opacity(0.5);
  max-height: 500px;
  max-width: 500px;
  overflow: hidden;
}

.home-container__text {
  position: absolute;
  top: clamp(4rem, 10vw, 8rem);
  left: 2%;
  font-size: clamp(4rem, 10vw, 8rem);
}

.featured-container {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
  align-items: center;
}

.featured-container img {
  transition: all 0.5s;
}

.featured-container img:hover {
  transform: scale(1.05);
  filter: brightness(1.1);
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

.products-container__content {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
}

@media (min-width: 768px) {
  .featured-container {
    grid-template-columns: repeat(3, 1fr);
  }

  .products-container__content {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .featured-container {
    grid-template-columns: repeat(4, 1fr);
  }

  .products-container__content {
    grid-template-columns: repeat(3, 1fr);
  }
}
</style>

