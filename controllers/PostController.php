<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use yii\helpers\Url;
use app\enums\PostStatus;
use app\models\category\Category;
use app\models\Material;
use app\models\Tag;
use app\models\post\Post;
use app\models\post\PostSearch;
use app\components\feed\Feed;
use app\components\feed\Item;
use app\components\UserPermissions;
use app\helpers\Text; 

/**
 * PostController implements the CRUD actions for Post model.
 *
 * @package app\controllers
 */
class PostController extends Controller
{
    /**
     * Behaviors
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['index', 'view', 'category', 'tag', 'create', 'admin', 'update', 'delete', 'rss', 'deals'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'view', 'category', 'tag', 'rss', 'deals'],
                        'roles'   => ['?', '@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['create', 'update', 'admin', 'delete'],
                        'roles'   => [UserPermissions::ADMIN_POST],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * List of categories
     * TODO: move to category controller
     */
    public function actionCategoriesList() {
        $request = Yii::$app->request;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        if ($request->post('depdrop_parents')) {
            $parents = $request->post('depdrop_parents');

            if ($parents !== null) {
                $type_id = $parents[0];
                $out = Category::getAllCategories($type_id);

                return ['output'=>$out, 'selected'=>''];
            }
        }

        return ['output'=>'', 'selected'=>''];
    }

    /**
     * Lists all posts
     *
     * @param int|null $id
     */
    public function actionIndex($id = null)
    {
        $searchModel = new PostSearch([
            'sortBy' => (int) $id,
            'type_id' => Material::MATERIAL_POST_ID,
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pagination' => $dataProvider->pagination,
            'page' => [
                'title' => Yii::$app->params['site']['name'],
                'meta' => [
                    'title' => Yii::$app->params['site']['name'],
                    'description' => Yii::$app->params['site']['description'],
                    'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
                ],
                'canonical' => Url::to(Yii::$app->params['site']['url']),
            ],
        ]);
    }

    /**
     * Lists all posts
     *
     * @param int|null $id
     */
    public function actionDeals($id = null)
    {
        $searchModel = new PostSearch([
            'sortBy' => (int) $id,
            'type_id' => Material::MATERIAL_DEAL_ID,
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pagination' => $dataProvider->pagination,
            'page' => [
                'title' => 'Deals',
                'headline' => [
                    'title' => 'Deals',
                    'icon' => 'fas fa-gift',
                ],
                'meta' => [
                    'title' => 'Deals',
                    'description' => 'Deals',
                    'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
                ],
                'canonical' => Url::to(['post/deals'], true),
            ],
        ]);
    }

    /**
     * Admin posts
     */
    public function actionAdmin()
    {
        $searchModel = new PostSearch();

        $dataProvider = $searchModel->adminSearch(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'pagination' => $dataProvider->pagination,
        ]);
    }

    /**
     * Show single post model
     *
     * @param string $slug
     *
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $model = Post::find()->where([
            'status_id' => PostStatus::STATUS_PUBLIC,
            'slug' => $slug,
        ])->withCommentsCount()->one();

        if (!$model) {
            throw new NotFoundHttpException();
        }

        $model->countHits();

        $breadcrumbs = [
            Material::MATERIAL_POST_ID => [
                'label' => 'Posts',
                'url' => '/post/index',
            ],
            Material::MATERIAL_DEAL_ID => [
                'label' => 'Deals',
                'url' => '/post/deals',
            ],
        ];

        return $this->render('view', [
            'model' => $model,
            'breadcrumbs' => $breadcrumbs[$model->type_id],
        ]);
    }

    /**
     * Creates a new Post model
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Gespeichert!');
            return $this->redirect(['post/update', 'id' => $model->id]);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing Post model
     *
     * @param integer $id
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Gespeichert.');

            return $this->redirect(['post/update', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing Post model
     *
     * @param int $id
     */
    public function actionDelete(int $id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['admin']);
    }

    /**
     * Action tag
     * 
     * TODO: move to tag controller
     *
     * @param $tagName
     *
     * @throws NotFoundHttpException
     */
    public function actionTag($tagName)
    {
        $tag = Tag::findOne(['slug' => $tagName]);

        if (!$tag) {
            throw new NotFoundHttpException();
        }

        $searchModel = new PostSearch(['tagId' => $tag->id]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pagination' => $dataProvider->pagination,
            'page' => [
                'title' => sprintf('Posts mit dem Tag: %s', $tag->name),
                'headline' => [
                    'title' => $tag->name,
                    'icon' => 'fa fa-tags',
                ],
                'meta' => [
                    'title' => $tag->name,
                    'description' => $tag->name,
                    'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
                ],
                'canonical' => Url::to(['tag/' . $tag->slug], true),
            ],
        ]);
    }

    /**
     * Action category
     * 
     * TODO: move to category controller
     *
     * @param $categoryName
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionCategory($categoryName)
    {
        $category = Category::findOne([
            'slug' => $categoryName,
        ]);

        if (!$category) {
            throw new NotFoundHttpException();
        }

        $searchModel = new PostSearch([
            'categoryId' => $category->id,
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pagination' => $dataProvider->pagination,
            'page' => [
                'title' => sprintf('Posts aus der Kategorie: %s', $category->name),
                'headline' => [
                    'title' => $category->name,
                    'icon' => 'fas fa-folder',
                ],
                'meta' => [
                    'title' => $category->name,
                    'description' => $category->name,
                    'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
                ],
                'canonical' => Url::to(['category/' . $category->slug], true),
            ]
        ]);
    }

    /**
     * List of posts for rss
     *
     * @return void
     */
    public function actionRss(): void
    {
        /** @var Post[] $posts */
        $posts = Post::find()->where(['status_id' => PostStatus::STATUS_PUBLIC])->orderBy('datecreate DESC')->limit(10)->all();

        $feed = new Feed();
        $feed->title = \Yii::$app->params['site']['name'];
        $feed->link = Url::to(\Yii::$app->params['site']['url']);
        $feed->selfLink = Url::to(['post/rss'], true);
        $feed->description = 'RSS-Feed von ' .\Yii::$app->params['site']['name'];
        $feed->language = Yii::$app->language;
        $feed->setWebMaster(\Yii::$app->params['adminEmail'], \Yii::$app->params['site']['author']);
        $feed->setManagingEditor(\Yii::$app->params['adminEmail'], \Yii::$app->params['site']['author']);

        foreach ($posts as $post) {
            $item = new Item();
            $item->title = $post->title;
            $item->link = Url::to(['post/view', 'slug' => $post->slug], true);
            $item->guid = Url::to(['post/view', 'slug' => $post->slug], true);
            $item->description = Text::cut('[cut]', HtmlPurifier::process(Markdown::process($post->content, 'gfm')));
            $item->pubDate = $post->datecreate;
            $item->setAuthor(\Yii::$app->params['adminEmail'], $post->user->username);
            $feed->addItem($item);
        }

        $feed->render();
    }

    /**
     * Finds the Post model based on its primary key value
     *
     * @param integer $id
     *
     * @return null|Post the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException();
    }
}
