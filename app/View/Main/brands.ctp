<div id='brands_container'>
  <div class='row-fluid'>
    <div class='span10'>
      <header>
        <h1>
          Brands we stock
        </h1>
      </header>
    </div>
  </div>
  <div class='row-fluid'>
    <content class='span10' id='brands_gallery'>
      <?php
      	foreach($brands as $brand) {
      		echo $this->element("brand_frame", array("brand" => $brand));
      	}
      ?>
    </content>
  </div>
</div>
