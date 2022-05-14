<template>
  <footer>
    <div class="b-footer">
      <div v-if="projectName">
        &copy; {{ currentYear }} Alle Rechte vorbehalten. {{ projectName }}.
      </div>
      <div v-if="links" class="b-footer__menu">
        <template v-for="(link, index) in links" v-bind:key="index">
          <e-link v-bind="link" class="b-footer__menu-item">{{
            link.title
          }}</e-link>
        </template>
      </div>
    </div>
  </footer>
</template>

<script>
import eLink from "../../Elements/e-link/e-link.vue";

export default {
  name: "b-footer",
  components: {
    eLink,
  },
  props: {
    links: {
      type: Object,
    },
    projectName: String,
  },
  computed: {
    currentYear() {
      return new Date().getFullYear();
    },
  },
};
</script>

<style scoped lang="scss" src="./b-footer.scss" />
