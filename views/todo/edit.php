
<div class="container">
    <div class="row">
        <h2>Edit Project/Todo details:</h2><br> 
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-5">
                <form method="POST" id="register-form" action="<?php echo Yii::$app->request->baseUrl;?>/todo/updateproject" >
                <label>Project:</label><br>
                <input type="name" class="form-control" name="project" placeholder="Project Name" value="<?php echo $project->project_name;?>" ><br>
                <label>Deadline: </label><br>
                <input type="date" class="form-control" name="deadline" placeholder="Project Deadline" value="<?php echo $project->deadline;?>" >              
                <br>
                <label>Todo: </label><br>
                <?php foreach($todos as $todo):?>
                <textarea type="text" name="todo[]" placeholder="Todo Description..."><?php echo $todo->todo_name;?></textarea><br><br>
                <?php endforeach;?>
                <div id="dynamicInput">
                <span class="glyphicon glyphicon-plus" onClick="addInput('dynamicInput');"></span>
                </div><br>          
                <input type="hidden" name="id" value="<?php echo $project->project_id;?>">       
                <button type="submit" class="btn btn-default">Submit</button><BR><BR>
		        </form>

        </div>
    </div>
</div>
<script>

$(function()
  {
       $("#register-form").validate({

        rules: {
          project: {
                     required:true,
                     },
             }, 
        });
});

var counter = 1;
var limit = 10;
function addInput(divName)
{ 
  if (counter != limit) 
   {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "<br><textarea type='text' name='todo[]' placeholder='Todo Description...'></textarea>";
          document.getElementById(divName).appendChild(newdiv);    
          counter++;     
    }
}

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
                    if(res != false)
                    {
                             swal({
                                    title: "Project successfully edited!",
                                },
                                  function()
                                  {
                                           window.location.href = "<?php echo Yii::$app->request->baseUrl;?>/todo/index/";
                                  });
                    }
                 }
           });       
});  


</script>
