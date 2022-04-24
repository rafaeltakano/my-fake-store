<script setup>
import { reactive, toRefs } from 'vue'
import { ElAvatar } from 'element-plus'

const props = defineProps({
  customUrl: String,
})

const state = reactive({
  fits: ['fill', 'fill', 'fill', 'fill', 'fill'],
  url: props.customUrl,
})

const { fits, url } = toRefs(state)
</script>

<template>
  <div class="demo-fit">
    <div v-for="fit in fits" :key="fit" class="block">
      <el-avatar shape="square" :size="50" :fit="fit" :src="url" />
    </div>
  </div>
</template>

<style scoped>
.demo-fit {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
}

.demo-fit .block {
  flex: 1;
  display: flex;
  flex-direction: column;
  flex-grow: 0;
}

::v-deep .el-avatar--square {
  background-color: transparent;
  border: 1px solid #4338ca;
  cursor: pointer;
}
</style>

