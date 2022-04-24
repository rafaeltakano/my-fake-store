<script setup>
import { ref } from 'vue'
import { ElCard } from 'element-plus'

const props = defineProps({
  title: String,
  text: String,
})
</script>

<template>
  <el-card :body-style="{ padding: '0px' }">
    <slot></slot>
    <div style="padding: 14px">
      <h3 class="font-bold text-sm sm:text-base">{{ title }}</h3>
      <div class="bottom">
        <p class="font-normal text-sm sm:text-base">{{ text }}</p>
      </div>
    </div>
  </el-card>
</template>

<style>
.time {
  font-size: 12px;
  color: #999;
}

.bottom {
  margin-top: 13px;
  line-height: 12px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.button {
  padding: 0;
  min-height: auto;
}

.image {
  width: 100%;
  display: block;
}
</style>

