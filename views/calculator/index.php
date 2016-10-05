

<div class="container">
	<div class="row">
		<div class="col-sm-4">
			
			<h2>Calculator</h2><br>
			Please fill out the following fields to find the result:<br><br>
   				 
   				 <form class="formclass" method="POST" action="" role="form"  id="formid" >                 
                      <label> First Number: </label><input type="name" id="first" name="first" class="form-control" placeholder="First Number" required><br><br>
                      <label> Second Number:</label><input type="name" id="second" name="second" class="form-control" placeholder="Second Number" required><br><br>
           			  <button id="add"  class="btn btn-primary">Add</button>
                      <button id="subtract" class="btn btn-info">Subtract</button>
                      <button id="multiply" class="btn btn-primary">Multiply</button>
                      <button id="divide" class="btn btn-info">Divide</button>
                </form>

		</div> 
	</div>
</div>

<script>

$(function()
{
    $("#formid").validate({

        rules: {
          	first: {
                     required:true,
                     number:true,
                   },

            second:  {
                     required:true,
                     number:true,
                   },

        }, 
    });

    $("#add").click(function(){
    
        var first=$("#first").val();
        var second=$("#second").val();
        var result=parseInt(first)+parseInt(second);
        $('#formid').append('The result is: '+result);                              
     
     });

    $("#subtract").click(function(){
    
        var first=$("#first").val();
        var second=$("#second").val();
        var result=parseInt(first)-parseInt(second);
        $('#formid').append('The result is: '+result);                              
     
     });


    $("#multiply").click(function(){
    
        var first=$("#first").val();
        var second=$("#second").val();
        var result=parseInt(first)*parseInt(second);
        $('#formid').append('The result is: '+result);                              
     
     });


    $("#divide").click(function(){
    
        var first=$("#first").val();
        var second=$("#second").val();
        var result=parseInt(first)/parseInt(second);
        $('#formid').append('The result is: '+result);                              
     
     });

});

</script>
