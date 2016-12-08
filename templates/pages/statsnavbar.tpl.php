<div class="btn-toolbar" role="toolbar">
   <div class="btn-group btn-group-xs">
     <button type="button" class="<?php echo$navigation->subpage == Scoring ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?subpage=Scoring'">Scoring</button>
     <button type="button" class="<?php echo$navigation->subpage == Goalie ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?subpage=Goalie'">Goalie</button>
     <button type="button" class="<?php echo$navigation->subpage == Stats ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?subpage=Stats'">Stats</button>
   </div>
</div>