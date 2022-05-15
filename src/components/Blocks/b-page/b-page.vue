<template>
  <div class="b-page" :class="classes">
    <e-headline v-if="headline" v-bind="headline" />
    <div v-if="text">
      {{ text }}
    </div>
    <slot />
  </div>
</template>

<script>
import eHeadline from "../../Elements/e-headline/e-headline.vue";

export default {
  name: "b-page",
  components: {
    eHeadline,
  },
  props: {
    headline: Object,
    text: String,
    transparent: {
      type: Boolean,
      default: false,
    },
    listView: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    classes() {
      return {
        'b-page--transparent': this.transparent,
        'b-page--list-view': this.listView,
      };
    },
  },
};
</script>

<style scoped lang="scss" src="./b-page.scss" />
