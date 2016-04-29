<div class="navbar navbar-inverse navbar-fixed-top">
   <div class="navbar-inner">
     <div class="container-fluid">
       <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </button>
       <a class="brand" href="index.php">IHSLA</a>
       <div class="nav-collapse collapse">
         <p class="navbar-text pull-right">
           <? $user = Users_Row::getUser($db) ?>
           <? if ($user == null): ?>
             <a href="login.php" class="navbar-link">Log in</a>
           <? else: ?>
               Logged in as <a href="#" class="navbar-link"><?=$user->_contactInfoObject->GetFullName()?></a>
           <? endif; ?>
         </p>
         <ul class="nav">
           <li class="active"><a href="index.php">Home</a></li>
           <li><a href="leagueinfo.php">League Info</a></li>
           <li><a href="teams.php">Teams</a></li>
           <li><a href="schedule.php">Schedule</a></li>
           <li><a href="stats.php">Stats</a></li>
           <li><a href="Links.php">Links</a></li>
           <li><a href="login.php">Coaches Area</a></li>
         </ul>
       </div><!--/.nav-collapse -->
     </div>
   </div>
</div>