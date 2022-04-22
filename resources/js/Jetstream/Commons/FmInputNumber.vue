<script setup>
import { ref } from 'vue'
import { ElInputNumber } from 'element-plus'

const num = ref(1)
const handleChange = (value) => {
  console.log(value)
}
</script>

<template>
  <el-input-number v-model="num" :min="1" :max="10" @change="handleChange" />
</template>

