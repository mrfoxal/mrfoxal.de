import { createApp } from 'vue';

const app = createApp({});

// components

app.component('b-footer', require('./components/Blocks/b-footer/b-footer.vue').default);
app.component('b-breadcrumbs', require('./components/Blocks/b-breadcrumbs/b-breadcrumbs.vue').default);
app.component('b-content', require('./components/Blocks/b-content/b-content.vue').default);
app.component('b-navbar', require('./components/Blocks/b-navbar/b-navbar.vue').default);
app.component('b-logo', require('./components/Blocks/b-logo/b-logo.vue').default);
app.component('b-page', require('./components/Blocks/b-page/b-page.vue').default);
app.component('m-material-filter', require('./components/Modules/m-material-filter/m-material-filter.vue').default);
app.component('m-list-view-item', require('./components/Modules/m-list-view-item/m-list-view-item.vue').default);

// directives

app.directive('click-outside', require('./components/Directives/click-outside.js').default);

app.mount('#app');
