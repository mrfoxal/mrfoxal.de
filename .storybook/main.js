module.exports = {
  "stories": [
    "../src/**/*.stories.mdx",
    "../src/**/*.stories.@(js|jsx|ts|tsx)"
  ],
  "addons": [
    "@storybook/addon-links",
    "@storybook/addon-essentials",
    {
      name: '@storybook/preset-scss',
      options: {
        sassLoaderOptions: {
          additionalData: (content) => {
            return `
              @import "src/scss/app.scss";
            ` + content;
          }
        }
      }
    },
  ],
  "framework": "@storybook/vue3",
  "core": {
    "builder": "@storybook/builder-webpack5"
  }
}