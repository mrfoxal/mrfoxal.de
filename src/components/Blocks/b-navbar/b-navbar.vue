<template>
  <nav v-if="items">
    <div
      class="b-navbar"
      v-click-outside="closeDropdown"
      :class="navbarClasses"
    >
      <div class="b-navbar__hamburger">
        <button
          type="button"
          class="b-navbar__hamburger-button"
          @click="isOpen = !isOpen"
        >
          <span class="b-navbar__hamburger-line"></span>
          <span class="b-navbar__hamburger-line"></span>
          <span class="b-navbar__hamburger-line"></span>
        </button>
      </div>
      <div class="b-navbar__container" :class="containerClasses">
        <template v-for="(menu, index) in items" :key="index">
          <div v-if="menu.items" class="b-navbar__item">
            <div @click.prevent="toggleExpansion(index)">
              {{ menu.label }}
              <span class="b-navbar__caret" />
            </div>
            <div v-show="isExpanded(index)" class="b-navbar__dropdown">
              <template
                v-for="(submenu, index) in menu.items"
                v-bind:key="index"
              >
                <e-link
                  v-if="submenu.url"
                  :href="submenu.url"
                  v-bind="submenu.linkOptions"
                  class="b-navbar__dropdown-item"
                >
                  {{ submenu.label }}
                </e-link>
              </template>
            </div>
          </div>
          <e-link
            v-if="menu.url"
            v-bind="menu.linkOptions"
            :href="menu.url"
            class="b-navbar__item"
          >
            {{ menu.label }}
          </e-link>
        </template>
      </div>
    </div>
  </nav>
</template>

<script>
import eLink from "../../Elements/e-link/e-link.vue";

export default {
  name: "b-navbar",
  components: {
    eLink,
  },
  data() {
    return {
      isOpen: false,
      expandedGroup: [],
    };
  },
  props: {
    items: {
      type: Object,
    },
    isFixed: {
      type: Boolean,
      default: true,
    },
  },
  computed: {
    navbarClasses() {
      return {
        "b-navbar--fixed": this.isFixed,
      };
    },
    containerClasses() {
      return {
        "b-navbar__container--hidden": !this.isOpen,
      };
    },
  },
  methods: {
    isExpanded(index) {
      return this.expandedGroup.includes(index);
    },
    toggleExpansion(index) {
      this.closeDropdown();

      if (!this.isExpanded(index)) {
        this.expandedGroup.push(index);
      }
    },
    closeDropdown() {
      this.expandedGroup = [];
    },
  },
};
</script>

<style scoped lang="scss" src="./b-navbar.scss" />
