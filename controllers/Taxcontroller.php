<?php

namespace app\controllers;
use yii\web\Controller;
use Yii;


class TaxController extends Controller
{

	 public function actionIndex()
    {
        return $this->render('index');
    }

	public function actionResult()
    {
        
        if(Yii::$app->request->isAjax)
			{
				 	
				$amount=Yii::$app->request->post('salary');	
				$status=Yii::$app->request->post('status');
				$twentyfive=250000;
				$thirtyfive=350000;
				$thirty=300000;

				if($status==1)
				{
						if($twentyfive>$amount)
						{
							$result=0.01*$amount;
						}
						
						else if($amount>=$twentyfive && $amount<$thirtyfive)
						{
						 	$result=0.01*$twentyfive+($amount-$twentyfive)*0.15;
						}

						else if($thirtyfive<$amount)
						{
							$result=0.01*$twentyfive+100000*0.15+($amount-$twentyfive-100000)*0.25;
						}

						else
						{
							echo "Something went wrong!";
						}
				}

				else if($status==2)
				{
						if($thirty>$amount)
						{
							$result=0.01*$amount;
						}
						
						else if($amount>=$thirty && $amount<400000)
						{
						 	$result=0.01*$thirty+($amount-$thirty)*0.15;
						}

						else if(350000<$amount)
						{
							$result=0.01*$thirty+100000*0.15+($amount-$thirty-100000)*0.25;
						}

						else
						{
							echo "Something went wrong!";
						}
				}

				else
				{
						echo "Something went wrong!";
				}

    			echo json_encode(array('status' => TRUE, 'result'=>$result)); die;
			}

				echo json_encode(FALSE); die;
	}

}