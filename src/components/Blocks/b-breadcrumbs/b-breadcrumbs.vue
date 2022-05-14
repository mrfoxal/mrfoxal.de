<template>
  <div v-if="links.length" class="b-breadcrumbs">
    <template v-for="(link, index) in links" v-bind:key="index">
      <span v-if="index !== 0"> / </span>
      <e-link v-if="link.url" :href="link.url" class="b-breadcrumbs__item">
        {{ link.label }}
      </e-link>
      <span v-else class="b-breadcrumbs__item--no-link">
        {{ link.label }}
      </span>
    </template>
  </div>
</template>

<script>
import eLink from "../../Elements/e-link/e-link.vue";

export default {
  name: "b-breadcrumbs",
  components: {
    eLink,
  },
  props: {
    links: {
      type: Object,
    },
  },
};
</script>

<style scoped lang="scss" src="./b-breadcrumbs.scss" />
