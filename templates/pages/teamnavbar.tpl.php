

<div class="btn-toolbar" role="toolbar">
   <div class="btn-group btn-group-xs">
     <button type="button" class="<?php echo$navigation->subpage == ContactInfo ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?subpage=ContactInfo&Team_ID=<?php echo$Team_ID?>'">Contact Info</button>
     <button type="button" class="<?php echo$navigation->subpage == Roster ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?subpage=Roster&Team_ID=<?php echo$Team_ID?>'">Roster</button>
     <button type="button" class="<?php echo$navigation->subpage == Scoring ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?subpage=Scoring&Team_ID=<?php echo$Team_ID?>'">Scoring</button>
     <button type="button" class="<?php echo$navigation->subpage == Goalie ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?subpage=Goalie&Team_ID=<?php echo$Team_ID?>'">Goalie</button>
     <button type="button" class="<?php echo$navigation->subpage == Stats ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?subpage=Stats&Team_ID=<?php echo$Team_ID?>'">Stats</button>
     <button type="button" class="<?php echo$navigation->subpage == Schedule ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?subpage=Schedule&Team_ID=<?php echo$Team_ID?>'">Schedule</button>
     <button type="button" class="<?php echo$navigation->subpage == TeamMessages ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?subpage=TeamMessages'">Team Messages</button>
   </div>
</div> 

<!--
<ul class="nav nav-pills">
  <li class="<?php echo$navigation->subpage == ContactInfo ? "active" : "" ?>"><a href="<?php echo$_SERVER['PHP_SELF']?>?subpage=ContactInfo&Team_ID=<?php echo$Team_ID?>">ContactInfo</a></li>
  <li class="<?php echo$navigation->subpage == Roster ? "active" : "" ?>"><a href="<?php echo$_SERVER['PHP_SELF']?>?subpage=Roster&Team_ID=<?php echo$Team_ID?>">Roster</a></li>
  <li class="<?php echo$navigation->subpage == Scoring ? "active" : "" ?>"><a href="<?php echo$_SERVER['PHP_SELF']?>?subpage=Scoring&Team_ID=<?php echo$Team_ID?>">Scoring</a></li>
  <li class="<?php echo$navigation->subpage == Goalie ? "active" : "" ?>"><a href="<?php echo$_SERVER['PHP_SELF']?>?subpage=Goalie&Team_ID=<?php echo$Team_ID?>">Goalie</a></li>
  <li class="<?php echo$navigation->subpage == TeamMessages ? "active" : "" ?>"><a href="<?php echo$_SERVER['PHP_SELF']?>?subpage=TeamMessages&Team_ID=<?php echo$Team_ID?>">TeamMessages</a></li>
</ul>
-->