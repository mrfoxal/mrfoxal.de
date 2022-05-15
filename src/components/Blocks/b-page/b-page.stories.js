import bPage from './b-page.vue';
import dummyData from './b-page.data.js';

export default {
  title: 'Blocks/Page',
  component: bPage,
  argTypes: {},
};

const Template = (args) => ({
  components: { bPage },
  setup: () => ({ args }),
  template: '<b-page v-bind="args" />',
});

export const Default = Template.bind({});
Default.args = { ...dummyData };
