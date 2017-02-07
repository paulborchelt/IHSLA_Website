<p>Welcome to the IHSLA Coaches site, <?php echo$user->_contactInfoObject->GetFullName()?> !</p>

<ul>
   <?php while ( $team = $user->fetchNextTeamObject() ): ?>
   <li><h5>Team Administration for <?php echo$team->Team_Name?></h5></li>
      <ul>
         <li><button type="button" onClick="window.location='Roster.php?Team_ID=<?php echo$team->Team_ID?>'" name="AddTeam">Enter Roster</button></li>
         <li><button type="button" onClick="window.location='EnterTeamSchedule.php?Team_ID=<?php echo$team->Team_ID?>'" name="AddTeam">Enter Schedule</button></li>
         <!--<li>Schedule Entry Turned Off for Upload to Arbiter</li>-->
         <li><button type="button" onClick="window.location='EnterTeamStats.php?Team_ID=<?php echo$team->Team_ID?>'" name="AddTeam">Enter Stats</button></li>
         <li><button type="button" onClick="window.location='OfficialsEvaluation.php?Team_ID=<?php echo$team->Team_ID?>'">Evaluate Officials</button></li>
         <li><button type="button" onClick="window.location='teams.php?Team_ID=<?php echo$team->Team_ID?>'">Update Team Contacts</button></li>
         <li><button type="button" onClick="window.location='SubmitProgramMembers.php?Team_ID=<?php echo$team->Team_ID?>'">Submit Program Members to League</button></li>
         <?php if ( 1 != $team->Club ): ?>
         <!-- </a><li><button type="button" onClick="window.location='EnterAllStateNominations.php?Team_ID=<?php echo$team->Team_ID?>&Position_ID=1'">Enter All-State Nominations</button></li> -->
         <!-- <li><button type="button" onClick="window.location='EnterAllStateVotes.php?Team_ID=<?php echo$team->Team_ID?>&Position_ID=1&Team_Level=1'">Enter All-State Votes</button></li> -->
         <?endif;?>
      </ul>
   <?php endwhile; ?>
   <?php if ($user->hasPermisions(Groups_Row::Administrators)): ?>
   <li><h5>Site Administration</h5></li>
      <ul>
         <li><button type="button" onClick="window.location='AdminUser.php'" name="AdminUsers">Admin Users</button></li>
         <li><button type="button" onClick="window.location='teams.php'">Update Team Contacts</button></li>
      </ul>
   <?php endif; ?>
   <?php if ($user->hasPermisions(Groups_Row::Officials)): ?>
   <li><h5>Officials</h5></li>
      <ul>
         <li><button type="button" onClick="window.location='OfficialsEvaluation.php?action=EvalList'">View Official Evaluations</button></li>
      </ul>
   <?php endif; ?>
   <?php if ($user->hasPermisions(Groups_Row::Administrators) || $user->hasPermisions(Groups_Row::News)): ?>
   <li><h5>News</h5></li>
      <ul>
         <li><button type="button" onClick="window.location='EmailContacts.php'">Email Contacts</button></li>
         <li><button type="button" onClick="window.location='EnterNews.php'">Enter News</button></li>
      </ul>
   <?php endif; ?>
   <li><h5>Info</h5></li>
      <ul>
         <li><button type="button" onClick="window.location='ContactInfoList.php'">Contact List</button></li>
      </ul>
   <li><h5>Account</h5></li>
      <ul>
         <li><button type="button" onClick="window.location='login.php?action=Logout'">Logout</button></li>
         <li><button type="button" onClick="window.location='login.php?action=viewchangepassword'">Change Password</button></li>
      </ul>
</ul>

