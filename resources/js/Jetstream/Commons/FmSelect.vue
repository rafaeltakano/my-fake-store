<script setup>
import { ref } from 'vue'
import { ElSelect, ElOption } from 'element-plus'

const props = defineProps({
  options: Object,
})

const value = ref('')
</script>

<template>
  <el-select v-model="value" placeholder="Select" @change="$emit('select-change')">
    <el-option
      v-for="item in options"
      :key="item.value"
      :label="item.label"
      :value="item.value"
      :disabled="item.disabled"
    />
  </el-select>
</template>

<style scoped>
.nav-bar-search {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

::v-deep .el-input__inner {
  box-shadow: none;
}

::v-deep .el-select .el-input .el-select__caret.el-icon {
  z-index: 0;
}
</style>
