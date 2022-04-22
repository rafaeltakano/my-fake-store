<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Alert from '@/Jetstream/Commons/Alert.vue'
import Spinner from '@/Jetstream/Commons/Spinner.vue'
import NavBar from '@/Jetstream/NavBar/NavBar.vue'

defineProps({
  title: String,
  isloading: Boolean,
  apiData: Object,
  apiErrors: String,
  options: Array,
})
</script>

<template>
  <div>
    <Head :title="title" />

    <div class="viewport-errors" v-if="apiErrors">
      <Alert :error="apiErrors" />
    </div>

    <div class="viewport-loading" v-if="isloading">
      <div class="text-center">
        <Spinner />
      </div>
    </div>

    <div class="flex flex-col" v-else>
      <NavBar :apiData="apiData" :options="options"/>

      <slot name="content"></slot>
    </div>
  </div>
</template>

<style scoped>
.viewport-loading {
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>

