<?php

require_once "../Database/functions.php";
require_once "../Constants/db_queries.php";

$resource_examples = select(QUERY_GET_EXAMPLES_BY_RESOURCE_ID,"i",[$_POST['courseId']]);

$row_number = 1;



// if(isset($_POST['del_example'])){
//     if(manipulate(QUERY_DELETE_EXAMPLE_BY_ID,"i",[intval($_POST['del_example_id'])]) == 1){
//         echo "example deleted successfully";
//     }

// }

 ?>




<div id="flFormsGrid" class="col-lg-12 layout-spacing">
    <div class="statbox widget box box-shadow">

        <div class="widget-content widget-content-area">


            <dive>
                <!-- ToDo -->
                <div class="alert alert-success rounded-3" style="display: none" id="alert-success-addExample" ></div>
                <div class="alert alert-danger rounded-3" style="display: none" id="alert-danger-addExample" ></div>
                <div class="form-row mb-4">
                    <div class="form-group col-md-4">
                        <label for="DateCategory"> Title </label>
                        <input id="TitleExample" value="" name="TitleExample" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Title Example">
                        <div id="danger-DateCategory"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="DateCategory"> Link </label>
                        <input id="LinkExample" value="" name="LinkExample" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Link Example">
                        <div id="danger-DateCategory"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                        </div>
                    </div>
                    <div class="form-group col-md-4 mt-4">
<!--                        TODO:add id of course in  SubmitAddExample-->
                        <button onclick="SubmitAddExample(<?php echo $_POST['courseId']; ?>)" class="btn btn-primary mt-3" name="submit_btn">submit</button>
                    </div>
                </div>


                <!-- ToDo -->
            </dive>


        </div>
    </div>
</div>



<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

    <div class="widget-content widget-content-area br-6">

        <div class="table-responsive mb-4 mt-4">
            <table id="zero-config" class="table table-hover" style="width:100%">
                <thead>
                <tr>

                    <th>#</th>
                    <th>Title</th>
                    <th>link</th>

                    <!--                                <th>Time</th>-->
                    <th class="no-content"></th>
                </tr>
                </thead>
                <tbody>
<!--                TODO: list_of_example-->
                <!-- <form id="delete_example" method="post" action="see_my_courses.php"> -->
                    <?php
                        if(is_array($resource_examples))
                        foreach ($resource_examples as $resource_example) {
                            echo '
                            <tr>
                            <td>'.$row_number++.'</td>
                            <td>'.$resource_example[1].'</td>
                            <td> <a href='.$resource_example[2].' class="btn btn-success m-2" target="_blank" ><i class="fa fa-eye"></i></a></td>
                            

                            <td > <button onclick="delete_example_submit('.$resource_example[0].')" type="submit" name="del_example" class="btn btn-danger m-2" ><i class="fa fa-trash"></i></button></td>
                            <input type="text" value='.$resource_example[0].' name="del_example_id" style="visibility: hidden"/>
                             
                            </tr>';
                        }
                     ?>
                    
                    <!-- </form> -->


                </tbody>
                <tfoot>
                <tr>

                    <th>#</th>
                    <th>Title</th>
                    <th>link</th>

                    <!--                                <th>Time</th>-->
                    <th class="no-content"></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>



<script type="text/javascript">
      
  </script>