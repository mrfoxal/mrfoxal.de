<template>
  <component :is="tag" :class="classes" class="e-headline">
    <i v-if="icon" :class="icon"></i> {{ title }}
    <slot />
  </component>
</template>

<script>
export default {
  name: "e-headline",
  props: {
    title: {
      type: String,
      default: "",
    },
    level: {
      type: Number,
      default: 1,
    },
    icon: {
      type: String,
    }
  },
  computed: {
    tag() {
      return `h${this.level}`;
    },
    classes() {
      return `e-headline--h${this.level}`;
    },
  },
};
</script>


<style scoped lang="scss" src="./e-headline.scss" />
