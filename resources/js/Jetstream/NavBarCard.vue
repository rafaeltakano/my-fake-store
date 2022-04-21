<script setup>
defineProps({
  category: String,
  description: String,
  id: Number,
  image: String,
  price: Number,
  rating: Object,
  title: String,
})
</script>

<template>
  <div class="flex flex-col gap-2 items-center">
    <img :src="image" :alt="title" class="object-contain h-44 w-80" />
    <p class="font-bold">{{ title }}</p>
    <p>Shop Now</p>
  </div>
</template>

