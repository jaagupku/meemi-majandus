<?php
include('header.php');

array_push($scripts, '/assets/js/script.js');
?>

<?php foreach($memes as $row) : ?>

<div class="container-fluid"><div class="break"></div></div>

<div class="container-fluid">
  <div class="row" data-id="<?= $row['Id'] ?>">
    <div class="col-xs-12 col-custom-frontpage col-centered">

      <h2><a href="<?php echo site_url('/meme/'.$row['Id'])?>"><?php echo $row['Title']; ?></a></h2>

      <div class="meme">
        <?php if ($row['Data_Type']=="P") {
           echo '<img alt="'.$row['Title'].'" src="http://res.cloudinary.com/spicy-memes/image/upload/t_meme/'.$row['Data'].'" />';
        } else {
           echo "<div class=\"embed-responsive embed-responsive-16by9\">
           <iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/{$row['Data']}\" allowfullscreen></iframe>
             </div>";
        }
        ?>
      </div>

      <div class="memedata">
        <p>Spice Level: <span class="points badge"><?php echo $row['Points']; ?></span></p>
        <p>Added by: <a href="<?php echo site_url('/profile/'.$row['User_Name']) ?>"><?php echo $row['User_Name'] ?></a></p>
        <p>Comments: <a href="comments_page.html"><span class="badge">1001</span></a></p>
      </div>

      <div class="updownvote-frontpage">
        <a role="button" class="btn btn-upvotes btn-md"><span class="	glyphicon glyphicon-arrow-up upvote<?php if ($row['User_Vote'] == 1) echo(' active-vote') ?>"></span></a>
        <a role="button" class="btn btn-downvotes btn-md"><span class="	glyphicon glyphicon-arrow-down downvote<?php if ($row['User_Vote'] == -1) echo(' active-vote') ?>"></span></a>
      </div>

    </div>
  </div>
</div>

<?php endforeach ?>

<?php if($nextpage != FALSE) : ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-custom-frontpage col-centered">
        <a role="button" class="btn btn-lg" href="<?php echo site_url($nextpage) ?>">Load next page.</a>
    </div>
  </div>
</div>
<?php else : ?>
<div class="container-fluid">
  <div class="row col-centered col-custom-frontpage">
    <p>End of page, no more memes.</p>
  </div>
</div>
<?php endif; ?>

<?php
include('footer.php')
?>
