<p>Welcome to the IHSLA Coaches site, <?=$user->_contactInfoObject->GetFullName()?> !</p>

<ul>
   <? while ( $team = $user->fetchNextTeamObject() ): ?>
   <li><h5>Team Administration for <?=$team->Team_Name?></h5></li>
      <ul>
         <li><button type="button" onClick="window.location='Roster.php?Team_ID=<?=$team->Team_ID?>'" name="AddTeam">Enter Roster</button></li>
         <li><button type="button" onClick="window.location='EnterTeamSchedule.php?Team_ID=<?=$team->Team_ID?>'" name="AddTeam">Enter Schedule</button></li>
         <!--<li>Schedule Entry Turned Off for Upload to Arbiter</li>-->
         <li><button type="button" onClick="window.location='EnterTeamStats.php?Team_ID=<?=$team->Team_ID?>'" name="AddTeam">Enter Stats</button></li>
         <li><button type="button" onClick="window.location='OfficialsEvaluation.php?Team_ID=<?=$team->Team_ID?>'">Evaluate Officials</button></li>
         <li><button type="button" onClick="window.location='teams.php?Team_ID=<?=$team->Team_ID?>'">Update Team Contacts</button></li>
         <li><button type="button" onClick="window.location='SubmitProgramMembers.php?Team_ID=<?=$team->Team_ID?>'">Submit Program Members to League</button></li>
         <? if ( 1 != $team->Club ): ?>
         </a><li><button type="button" onClick="window.location='EnterAllStateNominations.php?Team_ID=<?=$team->Team_ID?>&Position_ID=1'">Enter All-State Nominations</button></li> 
         <!-- <li><button type="button" onClick="window.location='EnterAllStateVotes.php?Team_ID=<?=$team->Team_ID?>&Position_ID=1&Team_Level=1'">Enter All-State Votes</button></li> -->
         <?endif;?>
      </ul>
   <? endwhile; ?>
   <? if ($user->hasPermisions(Groups_Row::Administrators)): ?>
   <li><h5>Site Administration</h5></li>
      <ul>
         <li><button type="button" onClick="window.location='AdminUser.php'" name="AdminUsers">Admin Users</button></li>
         <li><button type="button" onClick="window.location='teams.php'">Update Team Contacts</button></li>
      </ul>
   <? endif; ?>
   <? if ($user->hasPermisions(Groups_Row::Officials)): ?>
   <li><h5>Officials</h5></li>
      <ul>
         <li><button type="button" onClick="window.location='OfficialsEvaluation.php?action=EvalList'">View Official Evaluations</button></li>
      </ul>
   <? endif; ?>
   <? if ($user->hasPermisions(Groups_Row::Administrators) || $user->hasPermisions(Groups_Row::News)): ?>
   <li><h5>News</h5></li>
      <ul>
         <li><button type="button" onClick="window.location='EmailContacts.php'">Email Contacts</button></li>
      </ul>
   <? endif; ?>
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

