

<div class="container">
	<div class="row">
		<div class="col-sm-4">
			
			<h2> New User Signup</h2><br>
			Please fill out the following fields to register:<br><br>
   				 
   				 <form class="formclass" method="POST" action="<?php echo Yii::$app->request->baseUrl;?>/todo/verify/" role="form"  id="register-form" novalidate="novalidate">

                      <label>Email: </label>       <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" required><br><br>
                      <label> UserName:</label>     <input type="name" name="username" class="form-control" id="username" placeholder="UserName" required><br><br>
                      <label>Password: </label>       <input type="password" name="password" class="form-control" id="password" placeholder="Password" required><br><br>

           			  <button type="submit" class="btn btn-default">Sign Up</button><BR><BR>
                </form>

		</div>
	</div>
</div>
<script>

$(function()
  {
       $("#register-form").validate({

        rules: 
        {
             	username:
                {
                    required:true,
                    remote:
                      {
                            url: "<?php echo Yii::$app->request->baseUrl;?>/todo/checkusername/",
                            type: "post"
                      }
                },


                email:  
                {
                     required:true,
                     remote:
                      {
                            url: "<?php echo Yii::$app->request->baseUrl;?>/todo/checkemail/",
                            type: "post"
                      }
                },

                password: 
                {
                          required:true,         
                },
        }, 

        messages: 
        {
                
                    username:
                    {
                            required: "Username is a required field.",
                            remote: "This username already exists."     
                    },

                    email:
                    {
                             required: "Email is a required field.",
                             remote: "This email is already in use."     
                    },
        }

        });
});
</script>