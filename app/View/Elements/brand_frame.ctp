<div class='brand-frame'>
  <article>
    <div class='row-fluid'>
      <header>
        <h1>
          <?php
          	echo $brand['title'];
          ?>
        </h1>
      </header>
    </div>
    <div class='row-fluid'>
      <div class='image-container'>
        <?php
        	echo $this->Html->image('/img/brands/'.$brand['image_file_name'].'.jpg', array('alt' => 'CakePHP'));
        ?>
      </div>
    </div>
    <div class='row-fluid'>
      <content>
        <p>
          <?php
          	echo $brand['description'];
          ?>
        </p>
      </content>
    </div>
  </article>
</div>
