<template>
  <div v-if="item" class="m-list-view-item" :class="classes">
    <div>
      <a :href="item.href">
        <div v-if="!isColumnLayout" :style="{ backgroundImage: 'url(' + item.image + ')' }" class="m-list-view-item__image">
          <div class="m-list-view-item__image-overlay">
            <eHeadline v-bind="item.headline" class="m-list-view-item__title" />
          </div>
        </div>
        <div v-if="isColumnLayout">
          <img :src="item.image" class="m-list-view-item__image--column" />
        </div>
      </a>
      <a v-if="isColumnLayout && item.link" :href="item.link" class="m-list-view-item__button btn btn-danger" target="_blank">
          Zum Deal →
        </a>
    </div>

    <div v-if="isColumnLayout || hasContent" class="m-list-view-item__content-wrapper" :class="contentClasses">
      <template v-if="isColumnLayout">
        <div v-if="!hasContent">
          <a :href="item.href">
            <eHeadline v-bind="item.headline" class="m-grid-view-item__title m-list-view-item__title--column" />
          </a>
        </div>
        <div v-else>
          <eHeadline v-bind="item.headline" class="m-grid-view-item__title m-list-view-item__title--column" />
        </div>
      </template>

      <template v-if="hasContent">
        <div v-if="item.edit?.can">
          <i class="fa fa-edit"></i> <a :href="item.edit.url">Ändern</a>
        </div>

        <div v-html="item.content" />

        <div v-if="item.showDetails" class="m-list-view-item__footer">
          <i class="fa fa-clock-o"></i> {{ item.created }}

          <template v-if="item?.category">
            <i class="fa fa-folder"></i>
            <a :href="item.category.href">{{ item.category.name }}</a>
          </template>

          <template v-if="item.comments.allowed && item.comments.count >= 1">
            <i class="fa fa-comments"></i> {{ item.comments.count }}
          </template>

          <template v-if="item.tags">
            <i class="fa fa-tags"></i> <span v-html="item.tags"></span>
          </template>
        </div>

        <slot />
      </template>
      <div v-if="!item.content">
        <div v-html="item.cutText" class="m-list-view-item__cuttext m-list-view-item__cuttext--column" />

        <div class="m-list-view-item__readmore m-list-view-item__readmore--column">
          <a :href="item.href">Weiterlesen →</a>
        </div>
      </div>
    </div>

    <div v-if="!isColumnLayout && !item.content">
      <div v-html="item.cutText" class="m-list-view-item__cuttext" />

      <div class="m-list-view-item__readmore">
        <a :href="item.href">Weiterlesen →</a>
      </div>
    </div>
  </div>
</template>

<script>
import eHeadline from "../../Elements/e-headline/e-headline.vue";

export default {
  name: "m-list-view-item",
  components: {
    eHeadline,
  },
  props: {
    item: Object,
    layout: String,
  },
  computed: {
    classes() {
      return {
         'm-list-view-item--column': this.isColumnLayout,
      };
    },
    contentClasses() {
      return {
        'm-list-view-item__content-wrapper--column': this.isColumnLayout,
      };
    },
    link() {
      if (this.hasContent) {
        return this.item.link;
      }

      return this.item.href;
    },
    linkTarget() {
      return this.hasContent ? '_blank' : '_self';
    },
    hasContent() {
      return this.item.content?.length;
    },
    isColumnLayout() {
      return this.layout === 'column';
    },
  },
};
</script>

<style scoped lang="scss" src="./m-list-view-item.scss" />
