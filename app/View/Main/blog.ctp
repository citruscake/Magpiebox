<div id='blog_container'>
  <div class='row-fluid'>
    <div class='span10'>
      <header>
        <h1>
          Our blog
        </h1>
      </header>
    </div>
  </div>
  <div class='row-fluid'>
    <div class='span8'>
      <?php
      	foreach($posts as $post) {
      
      		echo $this->element('blog_post', array('post' => $post));
      
      	}
      ?>
    </div>
    <div class='span2'>
      <header>
        <h1>
          Recent entries:
        </h1>
      </header>
      <nav>
        <ul class='list-group'>
          <li class='list-group-item'>
            Tuesday 3rd September 2013
          </li>
          <li class='list-group-item'>
            Saturay 31st Satuday 2013
          </li>
        </ul>
      </nav>
    </div>
  </div>
</div>
