import eHeadline from './e-headline.vue';
import dummyData from './e-headline.data.js';

export default {
  title: 'Elements/Headline',
  component: eHeadline,
  argTypes: {},
};

const Template = (args) => ({
  components: { eHeadline },
  setup: () => ({ args }),
  template: '<e-headline v-bind="args" />',
});

export const Default = Template.bind({});
Default.args = { ...dummyData };
