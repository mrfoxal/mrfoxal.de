import mMaterialFilter from './m-material-filter.vue';
import dummyData from './m-material-filter.data.js';

export default {
  title: 'Modules/MaterialFilter',
  component: mMaterialFilter,
  argTypes: {},
};

const Template = (args) => ({
  components: { mMaterialFilter },
  setup: () => ({ args }),
  template: '<m-material-filter v-bind="args" />',
});

export const MaterialFilter = Template.bind({});
MaterialFilter.args = { ...dummyData };
