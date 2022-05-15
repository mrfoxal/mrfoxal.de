<template>
  <div v-if="item" class="m-list-view-item">
    <div>
      <a :href="item.href">
        <div :style="{ backgroundImage: 'url(' + item.image + ')' }" class="m-list-view-item__image">
          <div class="m-list-view-item__image-overlay">
            <eHeadline v-bind="item.headline" class="m-list-view-item__title" />
          </div>
        </div>
      </a>
    </div>

    <div v-if="item.content" class="m-list-view-item__content">

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
    </div>

    <div v-if="!item.content">
      <div v-html="item.cutText" class="m-list-view-item__cuttext" />

      <div class="m-list-view-item__readmore">
        <a :href="item.href">Mehr lesen →</a>
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
  },
};
</script>

<style scoped lang="scss" src="./m-list-view-item.scss" />
