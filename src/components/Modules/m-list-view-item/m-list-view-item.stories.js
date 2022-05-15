import mListViewItem from './m-list-view-item.vue';
import dummyData from './m-list-view-item.data.js';

export default {
  title: 'Modules/ListViewItem',
  component: mListViewItem,
  argTypes: {},
};

const Template = (args) => ({
  components: { mListViewItem },
  setup: () => ({ args }),
  template: '<m-list-view-item v-bind="args" />',
});

export const cutText = Template.bind({});
cutText.args = {
  ...dummyData,
  item: {
    ...dummyData.item,
    content: null,
  }
};

export const fullText = Template.bind({});
fullText.args = { ...dummyData };
