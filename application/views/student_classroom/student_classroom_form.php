<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Student_classroom <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Classroom Id <?php echo form_error('classroom_id') ?></label>
            <input type="text" class="form-control" name="classroom_id" id="classroom_id" placeholder="Classroom Id" value="<?php echo $classroom_id; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Student Id <?php echo form_error('student_id') ?></label>
            <input type="text" class="form-control" name="student_id" id="student_id" placeholder="Student Id" value="<?php echo $student_id; ?>" />
        </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('student_classroom') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>