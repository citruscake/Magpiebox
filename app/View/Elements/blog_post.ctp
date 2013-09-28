<article>
  <div class='row-fluid'>
    <div class='blog-header'>
      <div class='row-fluid'>
        <header class='title-container'>
          <h1>
            <?php
            	echo $post['title'];
            ?>
          </h1>
        </header>
        <div class='row-fluid'>
          <div class='date-container'>
            <?php
            	echo "<time datetime=\"".$post['pubDate']."\" pubDate>".$post['pubDate']."</time>";
            ?>
            <div class='name'>
              <?php
              	echo $post['author'];
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class='row-fluid' id='divider'></div>
  <div class='row-fluid'>
    <div class='blog-body'>
      <div class='row-fluid'>
        <div class='body-container'>
          <?php
          	echo $post['description'];
          ?>
        </div>
      </div>
    </div>
  </div>
</article>
