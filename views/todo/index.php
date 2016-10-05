<?php
use app\models\Todo;
use app\models\Project;
use app\models\User;
?>

<div class="container">
    <div class="row">
        <div class="col-sm-7">
      
            <h2>Project Details:</h2><br>
            <?php foreach($projects as $project):?>
                <b>Project Name: <?php echo $project->project_name;?></b><br>
                <b>Project Deadline:<mark><?php echo $project->deadline;?></mark></b><br>
                <b>Today's Date:<mark><?php echo date("Y-m-d"); echo " "; echo date("h:i:sa");?></mark></b><br>
                <b>Project Status:
                    
                    <?php   
                        if($project->deadline < date("Y-m-d"))
                        {
                            ?><script>alert('Project/s deadline reached');</script><?php
                            $insertstatus=Project::find()->where(['project_id'=>$project->project_id])->one();
                            $insertstatus->project_status="Project deadline reached!";
                            $insertstatus->update();
                            echo $project->project_status;
                        }
      
                        else
                        {
                            echo  $project->project_status;
                        }
                    ?>
                </b><br>

                <?php if($project->project_status!="Completed")
                    {
                        ?><a href="" class="completeproject" data-id="<?php echo $project->project_id;?>"><button type="button" class="btn btn-info">Mark Project As Complete</button></a><?php
                    }
                    else
                    {
                        echo "Completed date:$project->completed_date<br>";
                        ?><a href="" class="incompleteproject" data-id="<?php echo $project->project_id;?>"><button type="button" class="btn btn-info">Mark Project As Incomplete</button></a><?php
                    }
                ?>

                <a href="<?php echo Yii::$app->request->baseUrl;?>/todo/deleteproject" data-id="<?php echo $project->project_id;?>" class="removeproject"  ><button type="button" class="btn btn-danger">Delete Project</button></a>
  
                <a href="<?php echo Yii::$app->request->baseUrl;?>/todo/editproject" data-id="<?php echo $project->project_id;?>" class="editproject"><button type="button" class="btn btn-warning">Edit Project</button></a>
    
                </br>
                <br>
       
                <table id="tableid" border='1' class='table table-hover table-striped'>
                    <thead style='background-color:silver'><tr><td>S.N.</td><td>Todo Lists</td><td>Status</td><td>Mark Status</td><td>Completed Date</td><td>Options</td></tr>
                    </thead>
                        <tbody>        
                            <?php $todos=Todo::find()->where(['project_id'=>$project->project_id])->all();?>
                            <?php $i=0;?>
                                <?php foreach($todos as $tod):?>
                                    <td>
                                            <?php $i++; echo $i;?>  
                                    </td>
                                    <td>
                                            <?php echo $tod->todo_name;?>
                                    </td>
                                    <td>
                                            <?php echo $tod['status'];?>  
                                    </td>
                                    <td>
                                            <?php if($tod['status']=="Running")
                                                    {
                                                        ?><a href="" data-id="<?php echo $tod->todo_id;?>" class="completetodo">Mark as complete</a><?php
                                                    }
                                                 else
                                                    {
                                                        ?><a href="" class="incompletetodo" data-id="<?php echo $tod->todo_id;?>">Mark as Incomplete</a><?php
                                                    }
                                            ?>
                                    </td>
                                    <td>
                                            <?php echo $tod->todocompleted_date;?>
                                    </td>
                                    <td>
                                            <a href="<?php echo Yii::$app->request->baseUrl;?>/todo/deletetask" data-id="<?php echo $tod->todo_id;?>" class="remove"><button type="button" class="btn btn-danger">Delete</button></a></td></tr>
                                    </td>

                                <?php endforeach;?>        
                        </tbody>        
                </table>
            <?php endforeach;?>
        </div>

        <div class="col-sm-4">
		<h2> Add New Project</h2><br>
		Please fill out the project details:<br><br>

    	<form class="formclass" method="POST" action="<?php echo Yii::$app->request->baseUrl;?>/todo/add/" role="form"  id="register-form" novalidate="novalidate">        
            <label>Project Name: </label>
                <input type="name" name="project" class="form-control"  placeholder="Project Name" required><br><br>
            <label>Todo:</label><br>
                <textarea type="text" name="todo[]" placeholder="Todo Description..."></textarea>
                    <div id="dynamicInput">
                	       <span class="glyphicon glyphicon-plus" onClick="addInput('dynamicInput');"></span>
               		</div><br>
           	<label>Project Deadline:</label><br>
           		<input type="date" name="deadline"><br><br>
        	<button type="submit" class="btn btn-default">Add Project</button><BR><BR>          			  
   		</form>  
    </div>
</div>


<script>
$('#tableid').DataTable();

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
$(function() {

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
                                title: "Your project has been Added!",
                                type: "success",
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK!",
                                closeOnConfirm: false
                        },
                            function(){
                                       window.location.href = "<?php echo Yii::$app->request->baseUrl;?>/todo/index/";
                       });    
                    } 
                    else
                    {
                        swal("Opps!", "Something went wrong!", "error");
                    }
                    
                 }
           });       
    });  

$(document).on('click', '.remove', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    // Show the user a swal confirmation window
    swal({
            title: "Are you sure!",
            text: "You will not be able to recover this task",
            type: "error",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes!",
            showCancelButton: true,
        },
        function(isConfirm) {

            if(isConfirm)
            {
            // This function will run ONLY if the user clicked "ok"
            // Only here we want to send the request to the server!
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::$app->request->baseUrl;?>"+'/todo/deletetask',
                    data: {id:id},
                    success: function (data) {
                        var res = $.parseJSON(data);
                        if(res != false) {
                            swal("Task Deleted", "", "success");
                            window.location.href = "<?php echo Yii::$app->request->baseUrl;?>/todo/index/";
                           // $('#'+id).remove();

                        }
                    }
                });
            }
            else
            {
                    swal("Task not deleted!","","error");
            }

        }
    );
});

    $(document).on('click', '.removeproject', function (e) {
         
         e.preventDefault();
         var id = $(this).data('id');
         $.ajax({

            type: "POST",
            url: "<?php echo Yii::$app->request->baseUrl;?>"+'/todo/deleteproject',
            data: {id:id},
            success: function (data) {
                var res = $.parseJSON(data);
                if(res != false) {
                    swal({
                            title: "Project deleted!",
                            type:"error",
                            confirmButtonClass: "btn-danger",
                         },
                            function()
                                {
                                    window.location.href = "<?php echo Yii::$app->request->baseUrl;?>/todo/index/";
                           });
                  
                }
                if(res==false)
                {
                        swal("Opps!", "Something went wrong!", "error");
                }
                    
            }
        });          
    });


    $(document).on('click', '.completetodo', function (e) {
         
         e.preventDefault();
         var id = $(this).data('id');
         $.ajax({

            type: "POST",
            url: "<?php echo Yii::$app->request->baseUrl;?>"+'/todo/updatetocomplete',
            data: {id:id},
            success: function (data) {
                var res = $.parseJSON(data);
                if(res != false) {
                    swal({
                            title: "Marked as complete!",
                            type: "success",
                            confirmButtonClass: "btn-success",
                          },
                            function(){

                                       window.location.href = "<?php echo Yii::$app->request->baseUrl;?>/todo/index/";
                       });         
                }
                else
                {
                    swal("Opps!", "Something went wrong!", "error");
                }
            }
        });          
    });


    $(document).on('click', '.incompletetodo', function (e) {
         
         e.preventDefault();
         var id = $(this).data('id');

         $.ajax({

            type: "POST",
            url: "<?php echo Yii::$app->request->baseUrl;?>"+'/todo/updatetoincomplete',
            data: {id:id},
            success: function (data) {
                var res = $.parseJSON(data);
                if(res != false) {
                    swal({
                            title: "Marked as Incomplete!",
                            type: "warning",
                            confirmButtonClass: "btn-success",
                          },
                            function(){

                                       window.location.href = "<?php echo Yii::$app->request->baseUrl;?>/todo/index/";
                       });         
                }
                else
                {
                    swal("Opps!", "Something went wrong!", "error");
                }
            }
        });          
    });


    $(document).on('click', '.completeproject', function (e) {
         
         e.preventDefault();
         var id = $(this).data('id');
         $.ajax({

            type: "POST",
            url: "<?php echo Yii::$app->request->baseUrl;?>"+'/todo/updatealltocomplete',
            data: {id:id},
            success: function (data) {
                var res = $.parseJSON(data);
                if(res != false) {
                    swal({
                            title: "Marked as complete!",
                            type: "success",
                            confirmButtonClass: "btn-success",
                          },
                            function(){

                                       window.location.href = "<?php echo Yii::$app->request->baseUrl;?>/todo/index/";
                       });         
                }
                else
                {
                    swal("Opps!", "Something went wrong!", "error");
                }
            }
        });          
    });

    $(document).on('click', '.incompleteproject', function (e) {
         
         e.preventDefault();
         var id = $(this).data('id');
         $.ajax({

            type: "POST",
            url: "<?php echo Yii::$app->request->baseUrl;?>"+'/todo/updatealltoincomplete',
            data: {id:id},
            success: function (data) {
                var res = $.parseJSON(data);
                if(res != false) {
                    swal({
                            title: "Marked as incomplete!",
                            type: "warning",
                            confirmButtonClass: "btn-success",
                          },
                            function(){

                                       window.location.href = "<?php echo Yii::$app->request->baseUrl;?>/todo/index/";
                       });         
                }
                else
                {
                    swal("Opps!", "Something went wrong!", "error");
                }
            }
        });          
    });

});
</script>