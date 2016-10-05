<?php

namespace app\controllers;
use yii\web\Controller;
use Yii;
use app\models\Profile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Todo;
use app\models\Project;
use app\models\User;
use yii\web\Session;

class TodoController extends Controller
{
	public function behaviors()
    {
       return [
           'access' => [
           		'class' => AccessControl::className(),
           		'only' => ['display'],
           		'rules' => [
            // allow authenticated users
           			[
            			'allow' => true,
                		'roles' => ['@'],
              		],
                 ],
            ],
        ];
    }

		public function actionDisplay()
		{
				echo "display";
		} 

		public function actionLogin()
		{ 

		  if (!\Yii::$app->user->isGuest)
			    {
						return $this->redirect(Yii::$app->request->baseUrl.'/todo/index');	
				}

				$model = new LoginForm();
				if ($model->load(Yii::$app->request->post()) && $model->login() ) 
				{	
	     			   // $session = Yii::$app->session;
	     			   // $session['is_logged_in'] = TRUE;

					    return $this->redirect(Yii::$app->request->baseUrl.'/todo/index');		
				}
				
				// else
				// {
				// 	       $session = Yii::$app->session;
	            //   	   $session['is_logged_in'] = FALSE;
				// }

				return $this->render('login', [
						'model' => $model,
				]);
				
			 

		}	

		public function actionLogout()
		{
				Yii::$app->user->logout();

				return $this->redirect(Yii::$app->request->baseUrl.'/todo/login');	
		}
		
		public function actionSignupform()
		{
			
				return $this->render('register');
		}


		public function actionSignup($username,$token)
		{
				$session = Yii::$app->session;
				$session->setFlash('signup', 'You have successfully registered a new account.');
				$getModel = Profile::find()->where(['token'=>$token])->one();
				$getModel->status=1;
				$getModel->update();

				return $this->redirect(Yii::$app->request->baseUrl.'/todo/login');	
	 	}

	 	public function actionVerify()
		{ 
				$request = Yii::$app->request;
				$token = str_shuffle('abcdefgh1234567890xsY');

				$model = new Profile();
				$model->username=$request->post('username');
				$model->email=$request->post('email');
				$model->password=Yii::$app->security->generatePasswordHash($request->post('password'));
				$model->token=$token;
				$model->status=0;
				$model->position=0;
				
				if($model->save())
				{
					return Yii::$app->request->baseUrl.'/todo/signup/'.$model->username.'/'.$token;
				}

		}

		public function actionForgotform()
		{
			return $this->render('forgot');
		}
			
		public function actionToken()
		{
				$request = Yii::$app->request;
				$token = str_shuffle('abcdefgh1234567890xsY');
				$getEmail=$request->post('email');
				$getModel=Profile::find()->where(['email'=>$getEmail])->one();
				
				if($getModel)
				{
						$getModel->token=$token;
						$getModel->update();
						return Yii::$app->request->baseUrl.'/todo/reset/'.$getModel->username.'/'.$token;
				}

				else
				{
							echo "Email doesnot exist.";
				}
		
		}

		public function actionReset($username, $token)
		{ 
			
					$getModel=Profile::find()->where(['username'=>$username])->one();
					
					if($getModel->token==$token)
					{
							return $this->render('verify', ['id' => $getModel->id]);
					}

					else
					{
							return $this->redirect(Yii::$app->request->baseUrl.'/todo/forgotform');	
					}

		}

		public function actionNewpassword()
		{
				$request = Yii::$app->request;
				$password=$request->post('password');
				$password=Yii::$app->security->generatePasswordHash($password);
				$id=$request->post('id');

				$getModel=Profile::find()->where(['id'=>$id])->one();
				$getModel->password=$password;
				$getModel->update();
 
				$session = Yii::$app->session;
				$session->setFlash('passwordreset', 'You have successfully changed your password.');   		
				return $this->redirect(Yii::$app->request->baseUrl.'/todo/login');	

		}

		public function actionIndex()
		{		

				if (Yii::$app->user->isGuest)
			    {
						return $this->redirect(Yii::$app->request->baseUrl.'/todo/login');	
				}

				$id=Yii::$app->user->id;
				$position= Yii::$app->user->identity->position;
			
				if($position!=0)
				{	    				    
			      		// $sql ="SELECT username, position, id FROM profile INNER JOIN project ON profile.id =project.profile_id ";
	 			    	// $others=Yii::$app->db->createCommand($sql)->queryAll();
					    
					    $projects=Project::find()->where(['profile_id'=>$id])->all();    
					    $others=Profile::find()->all();
						return $this->render('admin', ['others' => $others,'projects'=>$projects]);								
				}
				else 
				{		   
					    $projects=Project::find()->where(['profile_id'=>$id])->all();	
					 	return $this->render('index', ['projects' => $projects]);
				}
		}

		public function actionAdd()
		{
			if(Yii::$app->request->isAjax)
				{
					 				
					$request = Yii::$app->request;
					$add=new Project();
					$add->project_name=$request->post('project');
					$add->deadline=$request->post('deadline');
					$add->profile_id=Yii::$app->user->id;
					$add->project_status="Running";
					$add->save();
					$getlast=Yii::$app->db->getLastInsertId();

					$todo=$request->post('todo');
					foreach($todo as $to)
			    	{
						if(!empty($to))
							{ 	
								$add=new Todo();
								$add->todo_name=$to;
								$add->status="Running";
								$add->project_id=$getlast;
								$add->save();
							}
					}			
						
					echo json_encode(TRUE); die;
				}

				echo json_encode(FALSE); die;
		}

		public function actionUpdatetocomplete()
		{
			if(Yii::$app->request->isAjax)
				{
					$id=$_POST['id'];
					$todo=Todo::find()->where(['todo_id'=>$id])->one();
					if(!empty($todo))
						{
							$todo->status="Completed";
							$todo->todocompleted_date=date("Y-m-d");      
							$todo->update();	
							echo json_encode(TRUE); die;
						}

				}

				echo json_encode(FALSE); die;
		}

		public function actionUpdatetoincomplete()
		{			
			if(Yii::$app->request->isAjax)
				{
					$id=$_POST['id'];
					$todo=Todo::find()->where(['todo_id'=>$id])->one();
					if(!empty($todo))
						{
							$todo->status="Running";
							$todo->todocompleted_date=''; 
							$todo->update();
							echo json_encode(TRUE); die;
						}
				}
				echo json_encode(FALSE); die;
		}
	
		public function actionUpdatealltocomplete()
		{
			if(Yii::$app->request->isAjax)
				{
					$project=Project::find()->where(['project_id'=>$_POST['id']])->one();
					if(!empty($project))
						{
							$project->project_status="Completed";
							$project->completed_date=date("Y-m-d");     
							$project->update();
							echo json_encode(TRUE); die;
						}
					echo json_encode(FALSE); die;
				}
		
		}

		public function actionUpdatealltoincomplete()
		{
			if(Yii::$app->request->isAjax)
				{
					$project=Project::find()->where(['project_id'=>$_POST['id']])->one();
					if(!empty($project))
						{
							$project->project_status="Running";
							$project->completed_date="";
							$project->update();
							echo json_encode(TRUE); die;
						}
					echo json_encode(FALSE); die;
				}
		}
		
	public function actionDeletetask()
	{
		if(Yii::$app->request->isAjax)
		{
			$id = $_POST['id'];
			if($id)
				{
					Todo::find()->where(['todo_id'=>$id])->one()->delete();    
					echo json_encode(TRUE);die;
				}
		}
		
		echo json_encode(FALSE);die;
			
	}

	public function actionDeleteproject()
	{
		if(Yii::$app->request->isAjax)
		{
			$id = $_POST['id'];
			
			if($id)
				{
					$project=Project::find()->where(['project_id'=>$id])->one();
					if($project)
					{
						$project->delete();
						$todos=Todo::find()->where(['project_id'=>$project->project_id])->all();
						foreach($todos as $todo)
						{
								$todo->delete();
						}
		 			}
		 		}

			echo json_encode(TRUE);die;
		}

		echo json_encode(FALSE);die;
			
	}

	public function actionEditproject($id)
	{
		if(!empty($id))
			{
				$project=Project::find()->where(['project_id'=>$id])->one();
				if($project)
					{
						$todos=Todo::find()->where(['project_id'=>$project->project_id])->all();
						return $this->render('edit', ['project'=>$project,'todos'=>$todos]);
					}
				else
					{
						throw new \yii\web\NotFoundHttpException();
					}		
			}
		else
			{
					throw new \yii\web\NotFoundHttpException();
			}

	}

	public function actionUpdateproject()
	{
		if(Yii::$app->request->isAjax)
		{
			$id=$_POST['id'];
			if(!empty($id))
			{	
				$request = Yii::$app->request;
				$update=Project::find()->where(['project_id'=>$id])->one();
				$update->project_name=$request->post('project');
				$update->deadline=$request->post('deadline');         
				$update->update();

				$delete=Todo::find()->where(['project_id'=>$id])->all();
				if($delete)
				{
					foreach($delete as $del)
					{
							$del->delete();
					}
				}
		
				$getlast=Yii::$app->db->getLastInsertId();
				$todo=$request->post('todo');
		    	$count=count($todo);
			 	foreach($todo as $to)
		    	{
					if(!empty($to))
					{ 	
						$add=new Todo();
						$add->todo_name=$to;
						$add->status="Running";
						$add->project_id=$id;
						$add->save();
					}
				}

			}

			echo json_encode(TRUE);die;
		}

		echo json_encode(FALSE);die;
	}

	public function actionUserdetails($id)
	{
		$position= Yii::$app->user->identity->position;
		if($position==1)
			{
				$projects=Project::find()->where(['profile_id'=>$id])->all();	
				if($projects)
				{
					return $this->render('index', ['projects' => $projects]);	
				}
			}
		else
		{
			?><script>alert('You must be an admin to access this.');</script><?php
		}

		return $this->redirect(Yii::$app->request->baseUrl.'/todo/index');	
	
	}


	public function actionDeleteuser()
	{
		if(Yii::$app->request->isAjax)
		{
			$id=$_POST['id'];
			if($id)
				{
					Profile::find()->where(['id'=>$id])->one()->delete();	
					echo json_encode(TRUE);die;
				}
			echo json_encode(FALSE);die;
		}			
	}


	public function actionUserpositiontouser()
	{
		if(Yii::$app->request->isAjax)
		{
			$id=$_POST['id'];
			if($id)
			{	
				$profile=Profile::find()->where(['id'=>$id])->one();	
				$profile->position=0;
				$profile->update();
				echo json_encode(TRUE);die;
			}
		}
		echo json_encode(FALSE);die;
	}

	public function actionUserpositiontoadmin()
	{
		if(Yii::$app->request->isAjax)
		{
			$id=$_POST['id'];
			$profile=Profile::find()->where(['id'=>$id])->one();	
			$profile->position=1;
			$profile->update();

			echo json_encode(TRUE);die;
		}

			echo json_encode(FALSE);die;
	}

	public function actionCheckusername()
	{
		if(Yii::$app->request->isAjax)
		{
			$check=Profile::find()->where(['username'=>$_POST['username']])->one();
			if(!$check)
			{
				echo json_encode(TRUE);die;
			}

		}	
		echo json_encode(FALSE);die;
	}

	public function actionCheckemail()
	{
		if(Yii::$app->request->isAjax)
		{
			$check=Profile::find()->where(['email'=>$_POST['email']])->one();
			if(!$check)
			{
				echo json_encode(TRUE);die;
			}

				echo json_encode(FALSE);die;
		}	
	}
}
//$id=Yii::$app->user->id;