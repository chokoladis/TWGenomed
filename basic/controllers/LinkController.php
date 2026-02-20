<?php

namespace app\controllers;

use app\services\ShortLinkService;
use yii\web\Controller;
use yii\filters\VerbFilter;

class LinkController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'generate' => ['post'],
            ],
        ];
        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionGenerate()
    {
        $service = new ShortLinkService();
        [$link, $errors] = $service->generate();

        if ($errors) {
            return $this->asJson(['errors' => $errors])->setStatusCode(400);
        }

        return $this->asJson(['result' => $link])->setStatusCode(201);
    }

    public function actionRedirect(string $short_link)
    {
        $service = new ShortLinkService();
        $link = $service->getFullLink($short_link);

        if (!$link) {
            return $this->response->setStatusCode(404);
        }

        return $this->redirect($link);
    }

}
