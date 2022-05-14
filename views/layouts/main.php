<?php

/* @var $this yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use app\components\UserPermissions;
use \app\assets\VueAsset;
use yii\helpers\Url;

AppAsset::register($this);
VueAsset::register($this);

$projectName = json_encode(\Yii::$app->params['site']['name']);

// breadcrumbs

$breadcrumbs = [];

if (!empty($this->params['breadcrumbs'])) {
    $breadcrumbs[] = ['label' => 'Home', 'url' => Url::home()];

    foreach ($this->params['breadcrumbs'] as $item) {
        $breadcrumbs[] = is_array($item) ? $item : ['label' => $item];
    }
}

// logo

$logo = [
    'image' => [
        'src' => '/img/logo.png',
        'alt' => 'mrfoxal',
    ],
    'href'=> Url::home(),
];

// menu items

$menuItems[] = ['label' => 'Blog', 'url' => Url::toRoute(['/post/index'])];
$menuItems[] = ['label' => 'Instagram', 'url' => 'https://www.instagram.com/mrfoxal/'];
$menuItems[] = ['label' => 'Discord', 'url' => 'https://discord.gg/xaytsMJDzp'];

if (Yii::$app->user->isGuest) {
    // $menuItems[] = ['label' => 'Login', 'url' => Url::toRoute(['/login'])];
} else {

    $menuItems[] = [
        'label' => 'Profil', 'url' => Url::toRoute(['/user/view', 'id' => \Yii::$app->user->id])
    ];

    if (Yii::$app->user->can('admin')) {
        $menuItems[] = [
            'label' => 'Panel', 'items' => [
                [
                    'label' => 'Posts (admin)',
                    'url' => Url::toRoute(['/post/admin']),
                    'visible' => UserPermissions::canAdminPost()
                ],
                [
                    'label' => 'Kategorien (admin)',
                    'url' => Url::toRoute(['/category/admin']),
                    'visible' => UserPermissions::canAdminCategory()
                ],
                [
                    'label' => 'Kommentar (admin)',
                    'url' => Url::toRoute(['/comment-admin/manage/index']),
                    'visible' => UserPermissions::canAdminPost()
                ],
                [
                    'label' => 'Upload',
                    'url' => Url::toRoute(['/upload/index']),
                    'visible' => UserPermissions::canAdminUpload()
                ],
                [
                    'label' => 'User (admin)',
                    'url' => Url::toRoute(['/user/admin']),
                    'visible' => UserPermissions::canAdminUsers()
                ],
            ],
        ];
    }

    $menuItems[] = [
        'label' => \Yii::t('app', 'Abmelden ({username})', [
            'username' => Yii::$app->user->identity->username,
        ]),
        'url' => Url::toRoute(['/site/logout']),
        'linkOptions' => ['data-method' => 'post']
    ];
}

// footer

$footerLink = json_encode([
    ['href' => '/mrfoxal', 'title' => 'Über Mr. Foxal'],
    ['href' => '/impressum', 'title' => 'Impressum'],
    ['href' => '/datenschutz', 'title' => 'Datenschutz'],
    ['href' => '/kontakt', 'title' => 'Kontakt aufnehmen']
]);

?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <?php $this->head() ?>
            <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
            <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
            <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
            <link rel="manifest" href="/site.webmanifest">
            <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#f8b526">
            <meta name="msapplication-TileColor" content="#f8b526">
            <meta name="theme-color" content="#ffffff">
        </head>
        <body>
            <?php $this->beginBody() ?>
                <div id="app" class="main-wrapper">
                    <b-logo :image='<?= json_encode($logo['image']) ?>' :href='<?= json_encode($logo['href']) ?>'></b-logo>

                    <b-navbar :items='<?= json_encode($menuItems) ?>'></b-navbar>

                    <b-cookie-modal>123</b-cookie-modal>

                    <b-breadcrumbs :links='<?= json_encode($breadcrumbs) ?>' /></b-breadcrumbs>

                    <b-content><?= $content ?></b-content>

                    <b-footer :project-name='<?= $projectName; ?>' :links='<?= $footerLink; ?>'></b-footer>
                </div>
            <?php $this->endBody(); ?>
        </body>
    </html>
<?php $this->endPage() ?>
