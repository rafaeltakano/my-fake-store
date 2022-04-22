<template>
  <div class="nav-bar-search">
    <el-select class="select" v-model="value" filterable placeholder="Select">
      <el-option v-for="item in options" :key="item.id" :label="item.title" :value="item.id" />
    </el-select>
    <Link v-if="value" :href="'#'" :data="{ value }">
      <SearchIcon class="w-6 h-6 text-gray-400 hover:text-gray-500" aria-hidden="true" />
    </Link>
    <div v-else>
      <SearchIcon class="w-6 h-6 text-gray-400 hover:text-gray-500" aria-hidden="true" />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import { ElSelect, ElOption } from 'element-plus'
import { SearchIcon } from '@heroicons/vue/outline'

const value = ref('')

defineProps({
  options: Array,
})
</script>

<style scoped>
.nav-bar-search {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

::v-deep .el-input__inner {
  box-shadow: none;
}
</style>

