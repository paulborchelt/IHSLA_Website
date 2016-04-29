
<div class="well-large">
   <p>We have found a match to the contact's name you just entered. 
   In an effort to avoid having the same contact entered twice we give you the option to move the contact from their current team to yours. 
   Or it is possible that two contact on different teams happen to have the same name and eamil. In this case you will want to conintue entering your new contact on your team.
   Or Maybe you just made a mistake and want to cancel to start over.</p>
</div>

<div class="well-large">
   <p>Here are your 3 Options:</p>
   
   <ol>
      <li>The contact(s) below matches the contact you entered. Please select one to move to your team:</li>
      <ul>
         <? while ( $contactinfo = $result->fetchNextObject() ): ?>
            <li><?=$contactinfo->FirstName?> <?=$contactinfo->LastName?> 
             <? if ($contactinfo->Email != ""): ?>
                <?=$contactinfo->Email?>  
             <? endif ?>
             <? if ($contactinfo->PhoneCell != ""): ?>
                (c) <?=$contactinfo->PhoneCell?>  
             <? endif ?>
             <? if ($contactinfo->PhoneHome != ""): ?>
                (h) <?=$contactinfo->PhoneHome?>  
             <? endif ?>
             <? if ($contactinfo->PhoneWork != ""): ?>
                (w) <?=$contactinfo->PhoneWork?>  
             <? endif ?>
            <button class="btn btn-small btn-primary" type="button" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?action=AddExistingContact&Id=<?=$contactinfo->Id?>&Team_ID=<?=$Team_ID?>&CTID=<?=$CTID?>&MainContact=<?=$MainContact?>'"> Add</button> </li>
         <? endwhile; ?>
      </ul>
       
      <li>None of the contacts above match the contact I want to enter. Please add the contact I entered as a new contact. <button class="btn btn-small" type="button" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?Force=Force&action=EnterContact&FirstName=<?=$newContactInfo->FirstName?>&LastName=<?=$newContactInfo->LastName?>&PhoneCell=<?=$newContactInfo->PhoneCell?>&PhoneHome=<?=$newContactInfo->PhoneHome?>&PhoneWork=<?=$newContactInfo->PhoneWork?>&Email=<?=$newContactInfo->Email?>&PhoneCell=<?=$newContactInfo->PhoneCell?>&CTID=<?=$CTID?>&MainContact=<?=$MainContact?>&Team_ID=<?=$Team_ID?>'"> ADD</button></li>
      
      <li>I made a mistake and would like to start over. <button class="btn btn-small" type="button" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?Team_ID=<?=$Team_ID?>'"> Cancel</button></li>
   
   </ol>

</div>
