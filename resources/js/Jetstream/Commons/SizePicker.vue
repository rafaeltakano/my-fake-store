<script setup>
import { ElRow, ElButton } from 'element-plus'
</script>

<template>
  <el-row>
    <el-button round>XS (PP)</el-button>
    <el-button round>S (P)</el-button>
    <el-button round>M (M)</el-button>
    <el-button round>L (G)</el-button>
    <el-button round>XL (GG)</el-button>
  </el-row>
</template>

<style scoped>
.el-button:focus,
.el-button:hover {
  color: #4338ca;
  border-color: #4338ca;
  background-color: #dfdcff;
}
</style>

