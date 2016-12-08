
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
         <?php while ( $contactinfo = $result->fetchNextObject() ): ?>
            <li><?php echo $contactinfo->FirstName?> <?php echo $contactinfo->LastName?> 
             <?php if ($contactinfo->Email != ""): ?>
                <?php echo $contactinfo->Email?>  
             <?php endif ?>
             <?php if ($contactinfo->PhoneCell != ""): ?>
                (c) <?php echo $contactinfo->PhoneCell?>  
             <?php endif ?>
             <?php if ($contactinfo->PhoneHome != ""): ?>
                (h) <?php echo $contactinfo->PhoneHome?>  
             <?php endif ?>
             <?php if ($contactinfo->PhoneWork != ""): ?>
                (w) <?php echo $contactinfo->PhoneWork?>  
             <?php endif ?>
            <button class="btn btn-small btn-primary" type="button" onClick="window.location='<?php echo $_SERVER['PHP_SELF']?>?action=AddExistingContact&Id=<?php echo $contactinfo->Id?>&Team_ID=<?php echo $Team_ID?>&CTID=<?php echo $CTID?>&MainContact=<?php echo $MainContact?>'"> Add</button> </li>
         <?php endwhile; ?>
      </ul>
       
      <li>None of the contacts above match the contact I want to enter. Please add the contact I entered as a new contact. <button class="btn btn-small" type="button" onClick="window.location='<?php echo $_SERVER['PHP_SELF']?>?Force=Force&action=EnterContact&FirstName=<?php echo $newContactInfo->FirstName?>&LastName=<?php echo $newContactInfo->LastName?>&PhoneCell=<?php echo $newContactInfo->PhoneCell?>&PhoneHome=<?php echo $newContactInfo->PhoneHome?>&PhoneWork=<?php echo $newContactInfo->PhoneWork?>&Email=<?php echo $newContactInfo->Email?>&PhoneCell=<?php echo $newContactInfo->PhoneCell?>&CTID=<?php echo $CTID?>&MainContact=<?php echo $MainContact?>&Team_ID=<?php echo $Team_ID?>'"> ADD</button></li>
      
      <li>I made a mistake and would like to start over. <button class="btn btn-small" type="button" onClick="window.location='<?php echo $_SERVER['PHP_SELF']?>?Team_ID=<?php echo $Team_ID?>'"> Cancel</button></li>
   
   </ol>

</div>
