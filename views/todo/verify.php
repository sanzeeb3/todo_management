
<div class="container">
<div class="row">
<div class="col-sm-4">
<h2> Reset Password</h2><br>

    <form class="formclass" method="POST" action="<?php echo Yii::$app->request->baseUrl;?>/todo/newpassword/" role="form"  id="register-form" novalidate="novalidate">
                     <input type="hidden" name="id" value="<?php echo $id;?>">
                      <label>  New Password: </label>       <input type="password" name="password" class="form-control" id="password" placeholder="Password" required><br><br>
                      <label>  Confirm Password: </label>       <input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="Confirm Password" required ><br><br>

           <button type="submit" name="submit" class="btn btn-default">Submit</button><BR><BR>
                            </form>

</div>
</div>
</div>
<script>
 $("#register-form").validate({
    
        // Specify the validation rules
        rules: {
                password : {
                    minlength : 5
                },
                cpassword : {
                    minlength : 5,
                    equalTo : "#password"
                }
            }
        
       messages: {
            password: "Password is a required value and must be 6 characters long.",
          	cpassword:"Password and confirm Password donot match."
            
        }

    });
    
</script>
