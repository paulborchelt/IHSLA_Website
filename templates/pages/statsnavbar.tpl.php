<div class="btn-toolbar" role="toolbar">
   <div class="btn-group btn-group-xs">
     <button type="button" class="<?=$navigation->subpage == Scoring ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=Scoring'">Scoring</button>
     <button type="button" class="<?=$navigation->subpage == Goalie ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=Goalie'">Goalie</button>
     <button type="button" class="<?=$navigation->subpage == Stats ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=Stats'">Stats</button>
   </div>
</div>