
<div class="container">
	<div class="row">
		<div class="col-sm-4">
			
			<h2> Personal Income TAX calculator</h2><br>
			Please fill out the following fields to find personal income tax:<br><br>
   				 
   				<form class="formclass" method="POST" action="<?php echo Yii::$app->request->baseUrl;?>/tax/result/" role="form"  id="register-form" novalidate="novalidate">                 
                        <label>Annual Income: </label>       <input type="name" id="salary" name="salary" class="form-control" placeholder="Annual Income" required><br><br>
                        <label> Maritial Status:</label> <br>    
                        <select name="status">
                            <option value="">--Please select your status--</option>
                            <option value="1">Single</option>
                            <option value="2">Married</option>  
                        </select>
                        <br><br>
                        <button type="submit" class="btn btn-default">Calculate</button><BR><BR>
                </form>

		    <div id="result"></div>
        </div>
        <div class="col-sm-7">
            <div ng-app="">
                <p>First Name : <input class="form-control" type="text" ng-model="first"></p>
                <p>Last Name: <input class="form-control" type="text" ng-model="last"></p>
                <h1>{{first + " " + last}}</h1>
            </div>
        </div>
	</div>
</div>



<script>

$(function()
{
    $("#register-form").validate({
        
        rules: 
        {
          	salary:{
                     required:true,
                     number:true,
                   },

            status:{
                    required:true,
                    },
        },
                   
        messages: 
        {
            status:
            {
                    required: "Please select your status.",
            },

        } 
    });


    $(document).on('submit', '#register-form', function (e) {
             
            e.preventDefault();
            var frm = $(this);
            $.ajax
            ({

                type: frm.attr('method'),
                url: frm.attr('action'),

                data: frm.serialize(),
                success: function (data)
                {
                    var res = $.parseJSON(data);
                    if(res.status != false)
                    {
                        // console.log(res.result);
                        var result =' The income tax to be paid anually is:';           
                        result +=res.result;

                        $('#result').html(result);      //inserting the html of result variable to id result.
                        
                        var sal=$("#salary").val();
                       
                        result +=' for the salary: '+ sal +'. Thank you!'; 
                        swal(result);
                        
                        //swal($('#result').html());         // inserting the html of result id to alert

                        // var test= $("#register-form").attr("method");
                        // $('#test').html(test);

                        //var test= $("#register-form").attr("method");

                        // $('#result').append(test);

                        $('#result').append('. Thank You!');
                        //$('#result').append($('#result').html())

                     // alert($("#result").text());
                     // alert($("#result").html());
                               
                    }

                }
            });       
    });

// All practices below


    // $("#result").click(function(){
    //     $(this).hide();
    // });

    // $("#result").mouseenter(function(){
    // swal("You entered p1!");
    // });

    // // $("#register-form").hover(function(){
    // // alert("You entered form!");
    // // },
    // //     function(){
    // //         alert("Bye! You now leave p1!");
    // // });
    
    // $("input").focus(function()
    // {
    //     $(this).css("color", "red");
    // });    

    // $("#result").on({
    //     mouseenter: function(){
    //     $(this).css("background-color", "lightgray");
    // }, 
    // mouseleave: function(){
    //     $(this).css("background-color", "lightblue");
    // }, 
    // click: function(){
    //     $(this).css("background-color", "yellow");
    // } 
    // });

    // $("#result").click(function(){
    // $("#register-form").fadeToggle();
    // $("h2").fadeToggle("slow");
    // $("button").fadeTo("slow", 0.5);   //fade to given opacity
    // });


    // $("#result").click(function(){  
    //      $("button").animate({
    //         left: '250px',   //You will need to write paddingLeft instead of padding-left, marginRight instead of margin-right, and so on. 
    //         opacity: '0.5',
    //         height: '150px',
    //         width: '150px'
    //     });
    // }); 

    // $("button").click(function(){
    //     $("#register-form").hide("slow", function(){
    //         swal("The form is now hidden");
    //     });
    // });
    // $("button").click(function(){
    // $("#result").css("color", "red").slideUp(2000).slideDown(2000);
    // });

    // $("button").click(function(){
    //     alert("Text: " + $("#result").text());
    // });

    // $("button").click(function(){
    //     alert("Value entered in salary: " + $("#salary").val());
    // });
        
     // $("button").click(function(){
     //     alert($("#register-form").attr("method"));   //The jQuery attr() method is used to get attribute values.
     // });
    //  $("button").click(function(){
    //     $("h2").append("Some appended text.");
    //     $("h2").prepend("Some prepended text.");
    // });


});



</script>

<!-- 

document.ready  is to prevent any jQuery code from running before the document is finished loading (is ready). 
The jQuery team has also created an even shorter method for the document ready event.
$(function(){

   // jQuery methods go here...

}); 

-->

