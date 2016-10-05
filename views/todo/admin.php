<?php
use app\models\Todo;
use app\models\Project;
use app\models\User;
?>


<div class="container">
    <div class="row">
        <div class="col-sm-7">
      
            <h2>My Project Details:</h2><br>
            <?php foreach($projects as $project):?>
            <b>Project Name: <?php echo $project->project_name;?></b><br>
            <b>Project Deadline:<mark><?php echo $project->deadline;?></mark></b><br>
            <b>Today's Date:<mark><?php echo date("Y-m-d"); echo " "; echo date("h:i:sa");?></mark></b><br>
            <b>Project Status:
            <?php if($project->deadline < date("Y-m-d"))
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
            ?><br>

            <?php if($project->project_status!="Completed")
            {
                ?> <a href="<?php echo Yii::$app->request->baseUrl;?>/todo/updatealltocomplete/<?php echo $project->project_id;?>"><button>Mark Project As Complete</button></a><?php
            }
            else
            {
                echo "Completed date:$project->completed_date<br>";
            ?> <a href="<?php echo Yii::$app->request->baseUrl;?>/todo/updatealltoincomplete/<?php echo $project->project_id;?>"><button>Mark Project As Incomplete</button></a><?php
            }
            ?>
            <a href="<?php echo Yii::$app->request->baseUrl;?>/todo/deleteproject" data-id="<?php echo $project->project_id;?>" class="removeproject"  ><button>Delete Project</button></a>
  
            <a href="<?php echo Yii::$app->request->baseUrl;?>/todo/editproject/<?php echo $project->project_id;?>" class="editproject"><button>Edit Project</button></a>
    
            </b></br>
            <br>
       
            <table id="tableid" border='1' class='table table-hover table-striped'>
       
            <thead style='background-color:silver'><tr><td>S.N.</td><td>Todo Lists</td><td>Status</td><td>Mark Status</td><td>Completed Date</td><td>Options</td></tr></thead>
            <?php $todos=Todo::find()->where(['project_id'=>$project->project_id])->all();?>
            <?php $i=0;?>
            <?php foreach($todos as $tod):?>
        
            <tbody><td><?php $i++; echo $i;?></td>
            <td>
            <?php echo $tod->todo_name;?>
            </td>
            <td><?php echo $tod['status'];?>  
            </td>
            <td>
            <?php if($tod['status']=="Running")
            {
                  ?><a href="<?php echo Yii::$app->request->baseUrl;?>/todo/updatetocomplete/<?php echo $tod->todo_id;?>" data-id="">Mark as complete</a><?php
            }
            else
            {
                  ?><a href="<?php echo Yii::$app->request->baseUrl;?>/todo/updatetoincomplete/<?php echo $tod->todo_id;?>" data-id="">Mark as Incomplete</a><?php
            }
            ?></td>
            <td><?php echo $tod->todocompleted_date;?></td>
            <td>
            <a href="<?php echo Yii::$app->request->baseUrl;?>/todo/deletetask" data-id="<?php echo $tod->todo_id;?>" class="remove"><button>Delete</button></a></td></tr>
            </td>

            </tbody>
        
            <?php endforeach;?>
             </table>
            <?php endforeach;?>
 
        </div>

    <div class="col-sm-4">
			<h2> Add New Project</h2><br>
			Please fill out the project details:<br><br>

    		<form class="formclass" method="POST" action="<?php echo Yii::$app->request->baseUrl;?>/todo/add/" role="form"  id="register-form" novalidate="novalidate">
                    
                      <label>    Project Name: </label>       <input type="name" name="project" class="form-control"  placeholder="Project Name" required><br><br>
                      <!-- <input type="hidden" name="profile_id" value=""> -->
                      <label>    Todo: </label><br>
                      <textarea type="text" name="todo[]" placeholder="Todo Description..."></textarea>
                      <div id="dynamicInput">
                	  <span class="glyphicon glyphicon-plus" onClick="addInput('dynamicInput');"></span>
               		    </div><br>
           			  <label> Project Deadline:</label><br>
           			  <input type="date" name="deadline"><br><br>
           			  <button type="submit" class="btn btn-default">Add Project</button><BR><BR>          			  
   		    </form> 
    </div>
 </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-7">
            <h2>All Users Details:</h2>

                <table border='1' class='table table-hover table-striped'>
                <thead style='background-color:silver'><tr><td>S.N.</td><td>UserName</td><td>User Position</td><td>Options</td><td>Options</td></tr></thead>   
                    <?php $i=0;?>
                    <?php foreach($others as $other):?>
                        <tbody><td><?php $i++; echo $i;?></td><td><?php echo $other['username'];?></td></td>
                            
                            <td>
                                        <?php if($other['position']!=0)
                                        {
                                            echo "Admin";
                                        }
                                            else
                                            {
                                                echo "User";
                                            }
                                        ;?>
                    
                            </td>

                            <td><a href="<?php echo Yii::$app->request->baseUrl;?>/todo/userdetails/<?php echo $other['id'];?> ">Show Profile details</a></td>
                            <td>
                            <a href="<?php echo Yii::$app->request->baseUrl;?>/todo/deleteuser/" data-id="<?php echo $other['id'];?>" class="removeuser"><button>Delete User</button></a> 
                                       
                                        <?php if($other['position']!=0)
                                        {
                                           ?><a href="<?php echo Yii::$app->request->baseUrl;?>/todo/userpositiontouser/" data-id="<?php echo $other['id'];?>" class="userpositiontouser"><button>Remove Admin</button></a> <?php
                                        }
                                         else
                                        {
                                               ?><a href="<?php echo Yii::$app->request->baseUrl;?>/todo/userpositiontoadmin/" data-id="<?php echo $other['id'];?>" class="userpositiontoadmin"><button>Make Admin</button></a> <?php
                                        }
                                        ;?>
                            </td>
                        </tbody>
                    <?php endforeach;?>


        </div>
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
                                  title: "Project successfully added!",
                                },
                                  function()
                                  {
                                           window.location.href = "<?php echo Yii::$app->request->baseUrl;?>/todo/index/";
                                  });
                    }
                 }
           });       
});  


    $(document).on('click', '.remove', function (e) {
         
         e.preventDefault();
         var id = $(this).data('id');

         //alert(id);
         $.ajax({

            type: "POST",
            url: "<?php echo Yii::$app->request->baseUrl;?>"+'/todo/deletetask',
            data: {id:id},
            success: function (data) {
                var res = $.parseJSON(data);
                if(res != false) {
                    swal({
                          title: "Successfully deleted!",
                        },
                          function(){
                               window.location.href = "<?php echo Yii::$app->request->baseUrl;?>/todo/index/";
                          });              
               }
            }
        });          
      });

  $(document).on('click', '.removeuser', function (e) {
         
         e.preventDefault();
         var id = $(this).data('id');

         //alert(id);
         $.ajax({

            type: "POST",
            url: "<?php echo Yii::$app->request->baseUrl;?>"+'/todo/deleteuser',
            data: {id:id},
            success: function (data) {
                var res = $.parseJSON(data);
                if(res != false) {
                    swal({
                          title: "Successfully deleted!",
                        },
                          function(){
                               window.location.href = "<?php echo Yii::$app->request->baseUrl;?>/todo/index/";
                          });              
               }
            }
        });          
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
                                  title: "Successfully deleted!",
                                },
                                  function()
                                  {
                                    window.location.href = "<?php echo Yii::$app->request->baseUrl;?>/todo/index/";
                                  });
                  
                }
            }
        });          
      });
 
 $(document).on('click', '.userpositiontouser', function (e) {
         
         e.preventDefault();
         var id = $(this).data('id');
         
         $.ajax({

            type: "POST",
            url: "<?php echo Yii::$app->request->baseUrl;?>"+'/todo/userpositiontouser',
            data: {id:id},
            success: function (data) {
                var res = $.parseJSON(data);
                if(res != false) {
                    swal({
                                  title: "User Position Changed to User!",
                                },
                                  function()
                                  {
                                    window.location.href = "<?php echo Yii::$app->request->baseUrl;?>/todo/index/";
                                  });
                  
                }
            }
        });          
      });

  $(document).on('click', '.userpositiontoadmin', function (e) {
         
         e.preventDefault();
         var id = $(this).data('id');
         
         $.ajax({

            type: "POST",
            url: "<?php echo Yii::$app->request->baseUrl;?>"+'/todo/userpositiontoadmin',
            data: {id:id},
            success: function (data) {
                var res = $.parseJSON(data);
                if(res != false) {
                    swal({
                                  title: "User Position Changed to Admin!",
                                },
                                  function()
                                  {
                                    window.location.href = "<?php echo Yii::$app->request->baseUrl;?>/todo/index/";
                                  });
                  
                }
            }
        });          
      });
  
});

</script>