<?php

namespace app\controllers;

use app\helpers\ChallengeSession;
use app\helpers\ChallengeSummarizer;
use app\models\Challenge;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use kartik\markdown\Markdown;

/**
 * Class ChallengeController
 * @package app\controllers
 */
class ChallengeController extends Controller
{
    public $layout = 'metronic_sidebar';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'answer' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Challenges list
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Free challenges list
     * @return string
     */
    public function actionFree()
    {
        $challenges = Challenge::findFree()->all();

        if (count($challenges) == 1) {
            $challenge = reset($challenges);
            return $this->redirect(Url::to(['challenge/start', 'id' => $challenge->id]));
        }

        return $this->render('free', [
            'challenges' => $challenges
        ]);
    }

    /**
     * Start challenge
     * @param int $id Challenge Id
     * @param bool $confirm Confirm start
     * @return string|\yii\web\Response
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function actionStart($id = 0, $confirm = false)
    {
        $challenge = $this->getChallenge($id);

        if ($challenge->settings->autostart || $confirm) {

            $session = new ChallengeSession($challenge, Yii::$app->user->id);
            if ($session->start()) {
                return $this->redirect(Url::to(['challenge/progress', 'id' => $challenge->id]));
            } else {
                throw new HttpException(500);
            }

        } else {
            return $this->render('start', [
                'challenge' => $challenge
            ]);
        }
    }

    /**
     * Finish challenge
     * @param int $id Challenge Id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionFinish($id = 0, $confirm = false)
    {
        $challenge = $this->getChallenge($id);
        $session = new ChallengeSession($challenge, Yii::$app->user->id);

        if (!$session->isFinished()) {
            if ($confirm) {
                $session->finish();
            } else {
                return $this->render('finish_confirm', [
                    'challenge' => $challenge
                ]);
            }
        }

        if (count($session->getAnswers())) {
            $summary = ChallengeSummarizer::fromSession($session);
            if (!Yii::$app->user->isGuest) {
                $summary->saveAttempt();
            }

            return $this->render('finish', [
                'challenge' => $challenge,
                'summary' => $summary
            ]);
        } else {
            // It looks like session wasn't even started
            return $this->redirect(Url::to(['challenge/start', 'id' => $challenge->id]));
        }
    }

    /**
     * Challenge in progress
     * @param int $id Challenge Id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionProgress($id = 0)
    {
        $challenge = $this->getChallenge($id);
        $session = new ChallengeSession($challenge, Yii::$app->user->id);

        if ($session->isFinished()) {
            return $this->redirect(Url::to(['challenge/finish', 'id' => $challenge->id]));
        }

        return $this->render('progress', [
            'session' => $session,
            'challenge' => $challenge
        ]);
    }

    /**
     * Submit answer to current challenge question
     * @param int $id Challenge Id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionAnswer($id = 0)
    {
        $challenge = $this->getChallenge($id);
        $session = new ChallengeSession($challenge, Yii::$app->user->id);

        if (!$session->isFinished()) {
            $session->answer(\Yii::$app->request->post('answer'));
        }

        if ($session->isFinished()) {
            return $this->redirect(Url::to(['challenge/finish', 'id' => $challenge->id]));
        } else {
            return $this->redirect(Url::to(['challenge/progress', 'id' => $challenge->id]));
        }
    }

    /**
     * Get question hint
     * @param int $id
     */
    public function actionHint($id = 0)
    {
        $challenge = $this->getChallenge($id);
        $session = new ChallengeSession($challenge, Yii::$app->user->id);

        //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $session->hint();
    }

    /**
     * Skip current question
     * @param int $id
     */
    public function actionSkip($id = 0)
    {
        $challenge = $this->getChallenge($id);
        $session = new ChallengeSession($challenge, Yii::$app->user->id);

        $session->skip();

        return $this->redirect(Url::to(['challenge/progress', 'id' => $challenge->id]));
    }

    /**
     * Get Challenge by id
     * @param $id
     * @return Challenge
     * @throws NotFoundHttpException
     */
    protected function getChallenge($id)
    {
        if ($challenge = Challenge::findOne($id)) {
            return $challenge;
        } else {
            throw new NotFoundHttpException(Yii::t('challenge', 'Not found'));
        }
    }

}
