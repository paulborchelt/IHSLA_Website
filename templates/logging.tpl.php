

<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.js"></script>
<div>
   <?php foreach ( $logs as $row ): ?>
      <?php foreach ( $row as $type => $log ): ?>
        <?php if ( TemplateLogger::success == $type ): ?>
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <?php echo $log?>
            </div>
        <?php elseif ( TemplateLogger::error == $type): ?>
            <div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <?php echo $log?>
            </div>
        <?php elseif ( TemplateLogger::info == $type ): ?>
            <div class="alert alert-info">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <?php echo $log?>
            </div>
        <?php elseif ( TemplateLogger::debug == $type): ?>
            <div class="alert alert-warring">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <b>DEBUG:</b> <?php echo $log?>
            </div>
        <?php else: ?>
            <p><?php echo $log?></p> 
        <?php endif; ?>
      <?php endforeach;?>
   <?php endforeach;?>
</div>



