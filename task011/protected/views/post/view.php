<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Posts'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Post', 'url'=>array('index')),
	array('label'=>'Create Post', 'url'=>array('create')),
	array('label'=>'Update Post', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Post', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Post', 'url'=>array('admin')),
);
?>



<div id="post">
    <h1><?php echo $model->title; ?></h1>
    <div class="content">
        <?php echo $model->text; ?>
    </div>
    <div class="tags">
        <strong>Автор:</strong> <?php echo $model->author->name; ?> |
        <strong>Выложено:</strong> <?php echo date('d.m.Y \в H:i',strtotime( $model->date )); ?> |
        <strong>Комментариев:</strong> <?php echo $model->commentCount; ?>
    </div>

    <div class="comments">
        <?php if($model->commentCount>=1): ?>
            <h2>
                Оставлено комментариев: <?php echo $model->commentCount; ?>
            </h2>

            <?php $this->renderPartial('_comments',array(
                'post'=>$model,
                'comments'=>$model->comments,
            )); ?>

        <?php else: ?>
            <h2>
                Комментарии пока никто не оставлял..
            </h2>


       <?php endif; ?>






    </div><!-- comments -->
</div>

