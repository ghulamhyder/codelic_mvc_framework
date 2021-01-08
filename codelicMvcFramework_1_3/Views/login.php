<?php

use app\core\form\Form;
?>

<h1><?php echo $title;?></h1><br>
	

	<?php $form= Form::begin(' ','post'); ?>
		
	<?php echo $form->field($model,'email'); ?>
	<?php echo $form->field($model,'password')->setType(); ?>
	
	<input type="submit" name="login" class="btn btn-success" value="Login">
	<?php echo Form::end(); ?>