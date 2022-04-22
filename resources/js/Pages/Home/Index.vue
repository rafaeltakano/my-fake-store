<script setup>
import { ref, onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const isloading = ref(false)

const apiData = ref([])

const apiErrors = ref('')

const options = ref([])

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
  try {
    isloading.value = true

    const [cat, prod] = await Promise.all([categories(), products()])

    apiData.value = await handleApi(cat, prod)

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
</script>
<template>
  <AppLayout
    title="Home"
    :isloading="isloading"
    :apiData="apiData"
    :apiErrors="apiErrors"
    :options="options"
  >
    <template #content>
      <h1>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsa, quaerat.</h1>
    </template>
  </AppLayout>
</template>

