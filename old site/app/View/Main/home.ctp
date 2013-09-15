<div id="mb_home_container">
	<div class="row">
		<?php /*<div style="width:650px;position:relative; margin-left:0px; margin-top:20px;">*/ ?>
		<div style="position:relative; margin-left:0px; margin-top:20px; width:980px;">
              <div id="mbCarousel" class="carousel slide">
                <ol class="carousel-indicators">
                  <li data-target="#mbCarousel" data-slide-to="0" class="active"></li>
                  <li data-target="#mbCarousel" data-slide-to="1"></li>
                  <li data-target="#mbCarousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                  <div class="item active">
                    <img src="/img/stratford5.jpg" style="height:300px;" alt=""/>
                    <div class="carousel-caption">
                      <h4>Magpiebox is our new gift shop in Stratford Upon Avon</h4>
                      <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    </div>
                  </div>
                  <div class="item">
                    <img src="/img/stratford4.jpg" style="height:300px;" alt=""/>
                    <div class="carousel-caption">
                      <h4>New! Rob Ryan Egg Cups</h4>
                      <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    </div>
                  </div>
                  <div class="item">
                    <img src="/img/stratford3.jpg" style="height:300px;" alt=""/>
                    <div class="carousel-caption">
                      <h4>Why not come along to our opening?</h4>
                      <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    </div>
                  </div>
                </div>
                <a class="left carousel-control" href="#mbCarousel" data-slide="prev">&lsaquo;</a>
                <a class="right carousel-control" href="#mbCarousel" data-slide="next">&rsaquo;</a>
              </div>
		</div>
	</div>
	<div class="row" style="margin-bottom:150px;">
		<div class="span3">
			<?php 
				echo $this->element('daily_item');
			?>
		</div>
	</div>
</div>