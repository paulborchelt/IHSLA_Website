

<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.js"></script>
<div>
   <? foreach ( $logs as $row ): ?>
      <? foreach ( $row as $type => $log ): ?>
        <? if ( TemplateLogger::success == $type ): ?>
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <?=$log?>
            </div>
        <? elseif ( TemplateLogger::error == $type): ?>
            <div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <?=$log?>
            </div>
        <? elseif ( TemplateLogger::info == $type ): ?>
            <div class="alert alert-info">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <?=$log?>
            </div>
        <? elseif ( TemplateLogger::debug == $type): ?>
            <div class="alert alert-warring">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <b>DEBUG:</b> <?=$log?>
            </div>
        <? else: ?>
            <p><?=$log?></p> 
        <? endif; ?>
      <?endforeach;?>
   <?endforeach;?>
</div>



