<template>
  <div v-if="image && href" class="b-logo">
    <a :href="href">
      <img :src="image.src" :alt="image.alt" class="b-logo__image" />
    </a>
  </div>
</template>

<script>
export default {
  name: "b-logo",
  props: {
    image: {
      type: Object,
    },
    href: String,
  },
};
</script>

<style scoped lang="scss" src="./b-logo.scss" />
