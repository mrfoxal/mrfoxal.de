<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
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
                'only'  => ['index', 'view', 'category', 'tag', 'create', 'admin', 'update', 'delete', 'rss'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'view', 'category', 'tag', 'rss'],
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
     * Lists all posts
     *
     * @param int|null $id
     */
    public function actionIndex($id = null)
    {
        $searchModel = new PostSearch(['sortBy' => (int) $id]);

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
     * Admin posts
     * 
     * @return string
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
     * @param $slug
     *
     * @return string
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

        $model->countHits(Material::MATERIAL_POST_NAME);

        return $this->render('view', ['model' => $model]);
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
     *
     * @throws ForbiddenHttpException
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
     * @param integer $id
     */
    public function actionDelete(int $id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['admin']);
    }

    /**
     * Action tag
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
            'material_id' => Material::MATERIAL_POST_ID
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
     * If the model is not found, a 404 HTTP exception will be thrown
     *
     * @param integer $id
     *
     * @return Post the loaded model
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
