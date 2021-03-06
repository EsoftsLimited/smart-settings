<?php
namespace esoftslimited\settings\actions;

use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\base\UserException;
use yii\helpers\Url;

/**
 * SettingsAction displays application settngs using a specified view.
 *
 * To use SettingsAction, you need to do the following steps:
 *
 * First, declare an action of SettingsAction type in the `actions()` method of your `Controller` like the following:
 *
 * ```php
 * public function actions()
 * {
 *     return [
 *         'settings' => ['class' => 'common\actions\SettingsAction'],
 *     ];
 * }
 * ```
 *
 **/
class SettingsAction extends Action
{
    /**
     * @var string the view file to be rendered. If not set, it will take the value of [[id]].
     */
    public $view;
    public $basePostName;
    public $sections=null;

    public $active;
    /**
     * Runs the action
     *
     * @return string result content
     */
    public function run()
    {
      
        if(isset($_POST)){ 
            $settings=$_POST;
            unset($settings['_csrf']);
            $return=false;
            foreach ($settings as $category => $args) {               
              $return=Yii::$app->settings->updateBatch($category,$args);
            }
           
            Yii::$app->session->setFlash('success',Yii::t('app','Settings updated'));
            
           
        }
        
        if (Yii::$app->getRequest()->getIsAjax()) {
            return null;
        } else {
            return $this->controller->render($this->view ?: $this->id, [
                'sections' => $this->sections,
                'selected' => $this->active,
                  
            ]);
        }
    }
}
