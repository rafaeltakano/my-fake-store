<script setup>
import { ElRow, ElButton } from 'element-plus'
</script>

<template>
  <el-row>
    <el-button type="primary" circle />
    <el-button type="success" circle />
    <el-button type="info" circle />
    <el-button type="warning" circle />
    <el-button type="danger" circle />
  </el-row>
</template>

<style scoped>
::v-deep .el-button.is-circle {
  padding: 1rem;
}
</style>

