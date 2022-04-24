<script setup>
import { ref } from 'vue'
import { ElRadio } from 'element-plus'

const props = defineProps({
  label: [Boolean, Number, String],
})

const radio = ref('')
</script>

<template>
  <el-radio v-model="radio" :label="label" size="large" @change="$emit('input-change')">
    <slot></slot>
  </el-radio>
</template>

