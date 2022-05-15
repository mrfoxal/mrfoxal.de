import bBreadcrumbs from './b-breadcrumbs.vue';
import dummyData from './b-breadcrumbs.data.js';

export default {
  title: 'Blocks/Breadcrumbs',
  component: bBreadcrumbs,
  argTypes: {},
};

const Template = (args) => ({
  components: { bBreadcrumbs },
  setup: () => ({ args }),
  template: '<b-breadcrumbs v-bind="args" />',
});

export const Breadcrumbs = Template.bind({});
Breadcrumbs.args = { ...dummyData };
