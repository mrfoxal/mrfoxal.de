import bNavbar from './b-navbar.vue';
import dummyData from './b-navbar.data.js';

export default {
  title: 'Blocks/Navbar',
  component: bNavbar,
  argTypes: {},
};

const Template = (args) => ({
  components: { bNavbar },
  setup: () => ({ args }),
  template: '<b-navbar v-bind="args" />',
});

export const Default = Template.bind({});
Default.args = {
  ...dummyData,
};
