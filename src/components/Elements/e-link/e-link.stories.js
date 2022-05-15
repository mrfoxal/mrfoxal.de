import eLink from './e-link.vue';
import dummyData from './e-link.data.js';

export default {
  title: 'Elements/Link',
  component: eLink,
  argTypes: {},
};

const Template = (args) => ({
  components: { eLink },
  setup: () => ({ args }),
  template: '<e-link v-bind="args">Link</e-link>',
});

export const Default = Template.bind({});
Default.args = { ...dummyData };
