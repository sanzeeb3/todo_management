

<div class="container">
	<div class="row">
		<div class="col-sm-4">
			
			<h2> EMI Calculator</h2><br>
			Please fill out the following fields to find the monthly payments:<br><br>
   				 
   				 <form class="formclass" method="POST" action="<?php echo Yii::$app->request->baseUrl;?>/emi/result/" role="form"  id="register-form" novalidate="novalidate">                 
                      
                      <label>    Loan Amount: </label>       <input type="name" name="amount" class="form-control" placeholder="Loan Amount" required><br><br>
                      <label> Interest Rate:</label>     <input type="name" name="rate" class="form-control" placeholder="Interest rate per annum" required><br><br>
                      <label>    Term(Months): </label>       <input type="name" name="term" class="form-control"  placeholder="Period (in months)" required><br><br>
           			  <button type="submit" class="btn btn-default">Calculate</button><BR><BR>
                      

                </form>

		      <div id="result"></div>
    </div>
	</div>
</div>

<script>

$(function()
{
    $("#register-form").validate({

        rules: {
          	amount: {
                     required:true,
                     number:true,
                   },

            rate:  {
                     required:true,
                     number:true,
                   },

            term:  {
                     required:true,
                     number:true,
                   },
     }, 
});


 $(document).on('submit', '#register-form', function (e) 
    {
            
             e.preventDefault();
             var frm = $(this);
             $.ajax({

                        type: frm.attr('method'),
                        url: frm.attr('action'),
                        data: frm.serialize(),
                        success: function (data) 
                        {
                            var res = $.parseJSON(data);
                            if(res.status != false)
                            {

                                 var result=res.result;
                                 result +=' is the EMI to be paid.  ';
                                            
                                 $('#result').html(result);
                                 swal($('#result').html());
    
                            }
                        }
                
                   });       
    });
});

</script>
