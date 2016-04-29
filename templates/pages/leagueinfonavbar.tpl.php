<div class="btn-toolbar" role="toolbar">
   <div class="btn-group btn-group-xs">
     <button type="button" class="<?=$navigation->subpage == About ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=About'">About</button>
     <button type="button" class="<?=$navigation->subpage == History ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=History'">History</button>
     <button type="button" class="<?=$navigation->subpage == Board ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=Board'">Board</button>
     <button type="button" class="<?=$navigation->subpage == ByLaws ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=ByLaws'">ByLaws/Docs</button>
     <button type="button" class="<?=$navigation->subpage == Dates ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=Dates'">League Dates</button>
     <button type="button" class="<?=$navigation->subpage == Join ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=Join'">Join</button>
     <button type="button" class="<?=$navigation->subpage == Officials ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=Officials'">Officials</button>
   </div>
</div>