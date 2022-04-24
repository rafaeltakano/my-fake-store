<script setup>
import Rating from '@/Jetstream/Commons/Rating.vue'

const props = defineProps({
  customer: Object,
})
</script>

<template>
  <div class="comment my-4">
    <div class="customer">
      <h3 class="font-bold">{{ customer?.name }}</h3>
    </div>
    <div class="review">
      <Rating :rate="Math.round(Math.random() * (5 - 1) + 1)" />
      <p class="font-normal">
        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ab itaque, explicabo ullam
        incidunt suscipit beatae unde expedita possimus quisquam porro a similique architecto fugiat
        molestias reiciendis earum officia! Error, molestias.
      </p>
    </div>
  </div>
</template>

