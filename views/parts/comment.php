<?php use yii\widgets\ActiveForm;  ?>


<?php

if(!empty($comments)):?>
    <h4>3 comments</h4>
    <?php foreach($comments as $comment):?>
        <div class="bottom-comment"><!--bottom comment-->


            <div class="comment-img">
                <img width="70px" class="img-circle" src="<?=$comment->user->image; ?>" alt="">
            </div>

            <div class="comment-text">
                <a href="#" class="replay btn pull-right"> Replay</a>
                <h5><?=$comment->user->username; ?></h5>

                <p class="comment-date">
                    <?=$comment->getDate(); ?>
                </p>


                <p class="para"><?=$comment->text; ?></p>
            </div>
        </div>
        <!-- end bottom comment-->
    <?php endforeach; ?>

<?php endif;?>
<?php if(!Yii::$app->user->isGuest):?>
    <div class="leave-comment"><!--leave comment-->

        <?php if(Yii::$app->session->getFlash('comment')): ?>
            <div class="alert alert-success" role="alert">
                <?= Yii::$app->session->getFlash('comment'); ?>
            </div>
        <?php endif;?>
        <?php $form = ActiveForm::begin([
            'action'=>['post/comment', 'id'=>$article->id],
            'options'=>['class'=>'form-horizontal contact-form', 'role'=>'form']
        ])?>
        <div class="form-group">
            <h4>Leave a comment: </h4>
            <div class="col-md-12">
                <?= $form->field($commentForm, 'comment')->textarea(['class'=>'form-control','placeholder'=>'Write Message', 'rows'=>'6'])->label(false) ?>
            </div>
            <button type="submit" class="btn send-btn">Post Comment</button>
        </div>

        <?php ActiveForm::end(); ?>
    </div><!--end leave comment-->
<?php endif; ?>