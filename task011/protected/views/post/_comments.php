<?php foreach($comments as $comment): ?>
    <div class="comment" id="c<?php echo $comment->id; ?>">

        <div class="username">
            <strong><?php echo $comment->author->name; ?> </strong> <span>написал</span>:
        </div>

        <div class="time">
            <?php echo date('F j, Y \в H:i',strtotime( $comment->date )); ?>
        </div>

        <div class="content">
            <?php echo nl2br(CHtml::encode($comment->text)); ?>
        </div>

    </div><!-- comment -->
<?php endforeach; ?>