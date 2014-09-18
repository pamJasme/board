<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DietCake</title>

    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bootstrap/css/layout.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px;
      }
    </style>
  </head>

  <body style="background-color:#A5C5AF">
        <div>
          <?php if (is_logged_in()) : ?>
            <div class="navbar navbar-inverse" style="margin-left: 100px; margin-right: 100px;">
              <div class="navbar-inner">
                <a class="brand" href="#">DietCake</a>
                  <ul class="nav">
                    <li><a href="<?php encode_quotes(url('thread/home'));?>">Home</a></li>
                    <li><a href="<?php encode_quotes(url('thread/index'));?>">Threads</a></li>
                    <li><a href="<?php encode_quotes(url('thread/my_posts'));?>">My Posts</a></li>
                    <li><a href="<?php encode_quotes(url('user/edit'));?>">Account</a></li>
                    <li><a href="<?php encode_quotes(url('thread/logout'));?>">Logout</a></li>
                  </ul>
                  <span class="label label-info" style="float:right; margin-top: 10px; font-size:15px">
                Welcome <?php echo $_SESSION['username'];?></span>
                </div>
              </div>
          <?php endif ?>
        </div>

    <div class="container">
      <?php echo $_content_ ?>
    </div>
    
    <script>
    console.log(<?php encode_quotes(round(microtime(true) - TIME_START, 3)) ?> + 'sec');
    </script>

  </body>
</html>

