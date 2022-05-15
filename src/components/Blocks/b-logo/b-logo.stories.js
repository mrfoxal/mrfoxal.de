import bLogo from './b-logo.vue';
import dummyData from './b-logo.data.js';

export default {
  title: 'Blocks/Logo',
  component: bLogo,
  argTypes: {},
};

const Template = (args) => ({
  components: { bLogo },
  setup: () => ({ args }),
  template: '<b-logo v-bind="args" />',
});

export const Default = Template.bind({});
Default.args = { ...dummyData };
