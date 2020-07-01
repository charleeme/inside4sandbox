<section class="jumbotron text-center">
    <div class="shaped" style="background:url(../Public/AppFront/app_default_template/img/knuca.jpg);">
	<!--<video class="video" loop="loop" autoplay="" muted="">
      <source src="/Public/AppFront/app_default_template/img/knuca.mp4" type="video/mp4" />
    </video>-->
	</div>
	<div class="content_s">
		<div class="offer">
			<p class="lead1"><i class="fas fa-quote-left"></i><?=$t->get('motto');?><i class="fas fa-quote-right"></i></p>
			<p class="lead"><?=$t->get('join_text');?></p>
			<a href="#" class="btn btn-lg btn-success my-2" data-toggle="modal" data-target="#order_modal"><?=$t->get('join_btn');?></a>
		</div>
	</div>
	
</section>
<div class="top-shadow">&nbsp;</div>

<!-- Begin page content -->
<main role="main" class="container" >

    <div class="blocks-list row">
        <div class="col-md-4" >
            <div class="card mb-4 box-shadow">
                <img class="card-img-top" data-src="/Public/AppFront/app_default_template/img/1.jpg" src="/Public/AppFront/app_default_template/img/1.jpg" alt="Card image cap">
                <div class="top-shadow">&nbsp;</div>
                <div class="card-body" style="background-image:url(../Public/AppFront/app_default_template/img/1.svg); background-size:cover;" >
                    <?=$t->get('campus');?>
                </div><a href="#" class="btn btn-lg btn-info my-2" data-toggle="modal" data-target="#order_modal" style="margin:0!important;"><?=$t->get('more_info');?></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 box-shadow">
                <img class="card-img-top" data-src="/Public/AppFront/app_default_template/img/2.jpeg" src="/Public/AppFront/app_default_template/img/2.jpeg" alt="Card image cap">
                <div class="top-shadow">&nbsp;</div>
                <div class="card-body" style="background-image:url(../Public/AppFront/app_default_template/img/2.svg); background-size:cover;" >
                    <?=$t->get('international');?>
                </div>
				<a href="#" class="btn btn-lg btn-success my-2" data-toggle="modal" data-target="#order_modal" style="margin:0!important;"><?=$t->get('more_info');?></a>

            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 box-shadow">
                <img class="card-img-top" data-src="/Public/AppFront/app_default_template/img/3.jpg" src="/Public/AppFront/app_default_template/img/3.jpg" alt="Card image cap">
                <div class="top-shadow">&nbsp;</div>
                <div class="card-body" style="background-image:url(../Public/AppFront/app_default_template/img/1.svg); background-position: right bottom; background-repeat: no-repeat;" >
                    <?=$t->get('science');?>
                </div>
				<a href="#" class="btn btn-lg btn-primary my-2" data-toggle="modal" data-target="#order_modal" style="margin:0!important;"><?=$t->get('more_info');?></a>
            </div>
        </div>

        <!--   -------------------- 2nd Line of 3-block on TOP ------------------------------------   -->

    </div>
</main>
<div class="info_bottom mt-4">
		<div class="container text-justify">
			<?=$t->get('un_text_1');?>
		</div>
</div>

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
		<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
		<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
		<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
	</ol>
	<div class="carousel-inner">
		<div class="carousel-item active">
			<img class="d-block w-100 h-100" src="../Public/AppFront/app_default_template/img/11.jpg">
			<div class="carousel-caption d-none d-md-block">
				<h2><?=$t->get('un_name_l');?></h2>
				<h3><?=$t->get('sl1');?></h3>
			</div>
		</div>
		<div class="carousel-item">
			<img class="d-block w-100" src="../Public/AppFront/app_default_template/img/12.jpg">
			<div class="carousel-caption d-none d-md-block">
				<h2><?=$t->get('un_name_l');?></h2>
				<h3><?=$t->get('sl2');?></h3>
			</div>
		</div>
		<div class="carousel-item">
			<img class="d-block w-100" src="../Public/AppFront/app_default_template/img/13.jpg">
			<div class="carousel-caption d-none d-md-block">
				<h2><?=$t->get('un_name_l');?></h2>
				<h3><?=$t->get('sl3');?></h3>
			</div>
		</div>
		<div class="carousel-item">
			<img class="d-block w-100" src="../Public/AppFront/app_default_template/img/14.jpg">
			<div class="carousel-caption d-none d-md-block">
				<h2><?=$t->get('un_name_l');?></h2>
				<h3><?=$t->get('sl4');?></h3>
			</div>
		</div>
	</div>
	<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>
<div class="info_bottom mt-4 pb-4">
		<div class="container text-justify">
			 <?=$t->get('un_text_2');?>
		</div>
</div>



<div class="modal fade bd-example-modal-lg modal_request" id="order_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?=$t->get('order_now_btn');?></h5>
                <button type="button" class="close" request_container="order_modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label class="col-form-label"><?=$t->get('request_form_label_1');?></label>
                        <input type="text" class="form-control name_contacts" name="name_contacts">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><?=$t->get('message');?>:</label>
                        <textarea class="form-control message" name="message"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-body-success d-none">
                <div class="text-center mt-5 mb-4">
                    <i class="fas fa-check big_icon text-success mb-4"></i>
                    <p><?=$t->get('thx_text_1');?></p>
                    <a class="refresh_form a_link" request_container="order_modal"><?=$t->get('refresh_form');?></a>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-inline-block callback_message"></div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$t->get('close');?></button>
                <button type="button" class="btn btn-primary request_btn" request_container="order_modal" request_target="Main Page Order"><?=$t->get('send_message');?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg modal_request" id="ask_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ask_modal_label"><?=$t->get('ask_question');?></h5>
                <button type="button" class="close" request_container="ask_modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label class="col-form-label"><?=$t->get('request_form_label_1');?></label>
                        <input type="text" class="form-control name_contacts" name="name_contacts">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><?=$t->get('message');?>:</label>
                        <textarea class="form-control message" name="message"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-body-success d-none">
                <div class="text-center mt-5 mb-4">
                    <i class="fas fa-check big_icon text-success mb-4"></i>
                    <p><?=$t->get('thx_text_1');?></p>
                    <a class="refresh_form a_link" request_container="ask_modal"><?=$t->get('refresh_form');?></a>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-inline-block callback_message"></div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$t->get('close');?></button>
                <button type="button" class="btn btn-primary request_btn" request_container="ask_modal" request_target="Main Page Ask Button"><?=$t->get('send_message');?></button>
            </div>
        </div>
    </div>
</div>
