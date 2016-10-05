<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
?>
<!DOCTYPE html>

<html lang="en">
<head>
<title>Project Wise Todo</title>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl;?>/assets/bootstrap/css/bootstrap.min.css">         

<script src="<?php echo Yii::$app->request->baseUrl;?>/assets/jquery.min.js"></script>
<script src="<?php echo Yii::$app->request->baseUrl;?>/assets/jquery.validate.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->request->baseUrl;?>/assets/sweetalert.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
<link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl;?>/assets/fileinput/fileinput.css">
<script src="<?php echo Yii::$app->request->baseUrl;?>/assets/fileinput/fileinput.js"></script>
<script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl;?>/assets/sweetalert.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>

<style>

body {

      position: relative;
    
  }
footer
{
      bottom:0;
      min-height: 100 px;
      background-color:black;
      color:red;
      height:199 px;
      dispaly:block;
}
.affix {
      top: 0;
      width: 100%;
       z-index:100; 
  }

  .affix + .container-fluid {
      padding-top: 20px;
  }

</style>
</head>
<body>
<div class="container-fluid" style="background-color:#F44336;color:#fff;height:120px;">
   
<h1>Project Wise Todo List</h1>
<h3>An online task management system </h3> 
</div>

</div>

<nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="13320">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="<?php echo Yii::$app->request->baseUrl;?>/todo/index/"><span class="glyphicon glyphicon-home"></span>Home</a></li>
        <?php
        if (Yii::$app->user->isGuest)
            {
                ?><li class=""><a href="<?php echo Yii::$app->request->baseUrl;?>/todo/login/"><span class="glyphicon glyphicon-user"></span> Login</a></li>
                  <li class=""><a href="<?php echo Yii::$app->request->baseUrl;?>/todo/signupform/"><span class="glyphicon glyphicon-log-in"></span> SignUp</a></li> <?php       
            }
        else
            {
                ?><li class=""><a href="<?php echo Yii::$app->request->baseUrl;?>/todo/logout/"><span class="glyphicon glyphicon-log-out"></span> Logout(<?php echo Yii::$app->user->identity->username;?>)</a></li> <?php
            }
        ?> 
        <li class=""><a href="<?php echo Yii::$app->request->baseUrl;?>/calculator"><span class=""></span>Calculator</a></li>
        <li class=""><a href="<?php echo Yii::$app->request->baseUrl;?>/emi"><span class=""></span>EMI</a></li>
        <li class=""><a href="<?php echo Yii::$app->request->baseUrl;?>/tax"><span class=""></span>TAX</a></li>
        
          
         </ul>
      </div>
  </div>
</nav>

   <?= $content ?>

</body>

</html>
<script type="text/javascript">
</script>

