<template>
  <transition name="b-cookie-modal">
    <div v-if="showModal" class="b-cookie-modal-overlay">
      <div class="b-cookie-modal-wrapper">
        <p>Wir verwenden Cookies!</p>
        <p>Viele sind notwendig, um die Website und ihre Funktionen zu betreiben, andere sind für statistische oder Marketingzwecke.</p>
        <p>Welche Cookies dürfen wir verwenden?</p>
        <div class="b-cookie-modal__buttons">
          <a class="btn btn-primary" @click.prevent="acceptCookie('all')" href="#">Alle akzeptieren</a>
          <a class="btn btn-secondary" @click.prevent="acceptCookie('essential')" href="#">Nur notwendige Cookies</a>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: "b-cookie-modal",
  data() {
    return {
      showModal: false,
    }
  },
  methods: {
    acceptCookie(type) {
      this.$cookie.setCookie('cookie-accepted', type);
      this.showModal = false;
    },
  },
  mounted () {
    if (this.$cookie.getCookie('cookie-accepted') === null) {
      this.showModal = true;
    }
  },
};
</script>

<style scoped lang="scss" src="./b-cookie-modal.scss" />
