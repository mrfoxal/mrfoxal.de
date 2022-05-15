import bContent from './b-content.vue';
import dummyData from './b-content.data.js';

export default {
  title: 'Blocks/Content',
  component: bContent,
  argTypes: {},
};

const Template = (args) => ({
  components: { bContent },
  setup: () => ({ args }),
  template: '<b-content v-bind="args">Hello World</b-content>',
});

export const Content = Template.bind({});
Content.args = { ...dummyData };
