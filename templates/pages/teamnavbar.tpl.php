

<div class="btn-toolbar" role="toolbar">
   <div class="btn-group btn-group-xs">
     <button type="button" class="<?=$navigation->subpage == ContactInfo ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=ContactInfo&Team_ID=<?=$Team_ID?>'">Contact Info</button>
     <button type="button" class="<?=$navigation->subpage == Roster ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=Roster&Team_ID=<?=$Team_ID?>'">Roster</button>
     <button type="button" class="<?=$navigation->subpage == Scoring ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=Scoring&Team_ID=<?=$Team_ID?>'">Scoring</button>
     <button type="button" class="<?=$navigation->subpage == Goalie ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=Goalie&Team_ID=<?=$Team_ID?>'">Goalie</button>
     <button type="button" class="<?=$navigation->subpage == Stats ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=Stats&Team_ID=<?=$Team_ID?>'">Stats</button>
     <button type="button" class="<?=$navigation->subpage == Schedule ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=Schedule&Team_ID=<?=$Team_ID?>'">Schedule</button>
     <button type="button" class="<?=$navigation->subpage == TeamMessages ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?subpage=TeamMessages'">Team Messages</button>
   </div>
</div> 

<!--
<ul class="nav nav-pills">
  <li class="<?=$navigation->subpage == ContactInfo ? "active" : "" ?>"><a href="<?=$_SERVER['PHP_SELF']?>?subpage=ContactInfo&Team_ID=<?=$Team_ID?>">ContactInfo</a></li>
  <li class="<?=$navigation->subpage == Roster ? "active" : "" ?>"><a href="<?=$_SERVER['PHP_SELF']?>?subpage=Roster&Team_ID=<?=$Team_ID?>">Roster</a></li>
  <li class="<?=$navigation->subpage == Scoring ? "active" : "" ?>"><a href="<?=$_SERVER['PHP_SELF']?>?subpage=Scoring&Team_ID=<?=$Team_ID?>">Scoring</a></li>
  <li class="<?=$navigation->subpage == Goalie ? "active" : "" ?>"><a href="<?=$_SERVER['PHP_SELF']?>?subpage=Goalie&Team_ID=<?=$Team_ID?>">Goalie</a></li>
  <li class="<?=$navigation->subpage == TeamMessages ? "active" : "" ?>"><a href="<?=$_SERVER['PHP_SELF']?>?subpage=TeamMessages&Team_ID=<?=$Team_ID?>">TeamMessages</a></li>
</ul>
-->