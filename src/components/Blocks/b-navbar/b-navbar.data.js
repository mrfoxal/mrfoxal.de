export default {
  items: [
    {
      "label": "Blog",
      "url": "/post/index"
    },
    {
      "label": "Instagram",
      "url": "https://www.instagram.com/mrfoxal/"
    },
    {
      "label": "Discord",
      "url": "https://discord.gg/xaytsMJDzp"
    },
    {
      "label": "Profil",
      "url": "/user/1"
    },
    {
      "label": "Panel",
      "items": [
        {
          "label": "Posts (admin)",
          "url": "/post/admin",
          "visible": true,
        },
        {
          "label": "Kategorien (admin)",
          "url": "/category/admin",
          "visible": true,
        },
        {
          "label": "Kommentar (admin)",
          "url": "/comment-admin/manage/index",
          "visible": true,
        },
        {
          "label": "Upload",
          "url": "/upload/index",
          "visible": true,
        },
        {
          "label": "User (admin)",
          "url": "/user/admin",
          "visible": true,
        }
      ],
    },
    {
      "label": "Abmelden (admin)",
      "url": "/logout",
      "linkOptions": {
        "data-method": "post"
      }
    }
  ],
  isFixed: false,
};
