<script setup>
import { ref, onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const isloading = ref(false)

const apiData = ref([])

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

onMounted(async () => {
  isloading.value = true

  const [cat, prod] = await Promise.all([categories(), products()])

  apiData.value = await handleApi(cat, prod)

  isloading.value = false

  return {
    isloading,
    apiData,
  }
})
</script>
<template>
  <AppLayout title="Home" :isloading="isloading">
    <template #content>
      <div class="test-container">lorem</div>
    </template>
  </AppLayout>
</template>

