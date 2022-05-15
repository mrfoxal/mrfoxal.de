import { app } from "@storybook/vue3";
import clickOutside from "../src/components/Directives/click-outside";

import '@fortawesome/fontawesome-free/css/all.css';

app.directive("click-outside", clickOutside);

export const parameters = {
  actions: { argTypesRegex: "^on[A-Z].*" },
  controls: {
    matchers: {
      color: /(background|color)$/i,
      date: /Date$/,
    },
  },
}