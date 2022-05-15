import eDummy from './e-dummy.vue';
import dummyData from './e-dummy.data.js';

export default {
  title: 'Elements/Dummy',
  component: eDummy,
  argTypes: {},
};

const Template = (args) => ({
  components: { eDummy },
  setup: () => ({ args }),
  template: '<e-dummy v-bind="args" />',
});

export const Dummy = Template.bind({});
Dummy.args = { ...dummyData };
