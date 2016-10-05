<?php

namespace app\controllers;
use yii\web\Controller;
use Yii;


class EmiController extends Controller
{

	public function actionIndex()
    {
        return $this->render('index');
    }

	public function actionResult()
    {
        
        if(Yii::$app->request->isAjax)
			{
				 				
				$request = Yii::$app->request;
				if($request)
				{
					$amount=$request->post('amount');	
					$rate=$request->post('rate');
					$ratepermonth=$rate/(100*12);
					$term=$request->post('term');
				
					$power=pow((1+$ratepermonth),$term);
					$result=round(($amount*$ratepermonth*$power)/($power-1));		
				
    				echo json_encode(array('status' => TRUE, 'result'=>$result)); die;
				}			
			}

				 echo json_encode(FALSE); die;

	}

}