import bFooter from './b-footer.vue';
import dummyData from './b-footer.data.js';

export default {
  title: 'Blocks/Footer',
  component: bFooter,
  argTypes: {},
};

const Template = (args) => ({
  components: { bFooter },
  setup: () => ({ args }),
  template: '<b-footer v-bind="args" />',
});

export const Footer = Template.bind({});
Footer.args = { ...dummyData };
