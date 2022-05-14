<template>
  <div v-if="items" class="m-material-filter">
    <div
      v-for="(item, index) in items"
      :key="index"
      class="m-material-filter__item"
    >
      <div>
        <i :class="item.icon"></i>
      </div>
      <div>
        <a :href="item.url">{{ item.label }}</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "m-material-filter",
  props: {
    items: Array,
  },
};
</script>

<style scoped lang="scss" src="./m-material-filter.scss" />
