<div class="container">
    <div class="well well-small">
        <?php echo $news->headline?>
    </div>
    <div class="well well-large">
        <?php echo $news->formatmessage() ?>
    </div>
    <p><a class="btn" href="EnterNews.php?action=Archive">News Archive</a></p>
</div>
