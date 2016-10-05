
<div class="container">
<div class="row">
<div class="col-sm-4">
<h2> Reset Password</h2><br>
Please fill out the following fields to reset:<br><br>
    <form class="formclass" method="POST" action="<?php echo Yii::$app->request->baseUrl;?>/todo/token/" role="form"  id="register-form" novalidate="novalidate">
                      <label>    Email: </label>       <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" required><br><br>
                     
           <button type="submit" class="btn btn-default">Reset Password</button><BR><BR>
                            </form>

</div>
</div>
</div>