<table cellspacing="1" cellpadding="1" border="0">
    <tr>
        <td></td>

        <td></td>

        <td></td>

        <td></td>
    </tr>
    <? if( true == $edit ): ?>
    <tr>
        <td>&nbsp;</td>

        <td>&nbsp;</td>
        
        <td>&nbsp;</td>

        <td><button type="button" class="btn btn-default" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?action=AddContact&Team_ID=<?=$teamid?>'">Add Contact</button></td>
            
            
    </tr>
    <? endif; ?>
<? while ( $contactinfo = $result->fetchNextObject() ): ?>
    <tr>
        <td><b><?=$contactinfo->_ContactTypeObject->Type?>
        </b></td>

        <td><b>Name:</b></td>

        <td><b><?=$contactinfo->FirstName?>
         <?=$contactinfo->LastName?>
        </b></td>
        <? if( true == $edit ): ?>
             <td><a href="<?$_SERVER['PHP_SELF']?>?action=Edit&Id=<?=$contactinfo->Id?>&Team_ID=<?=$contactinfo->_ContactInfoTeamsListObject->TID?>&contactinfoteamslistid=<?=$contactinfo->_ContactInfoTeamsListObject->contactinfoteamslistid?>"> <img src= /images/site_images/icon_edit.gif></a>
              <a href="<?$_SERVER['PHP_SELF']?>?action=Delete&CID=<?=$contactinfo->Id?>&Id=<?=$contactinfo->Id?>&Team_ID=<?=$contactinfo->_ContactInfoTeamsListObject->TID?>&contactinfoteamslistid=<?=$contactinfo->_ContactInfoTeamsListObject->contactinfoteamslistid?>"> <img src= /images/site_images/icon_delete.gif></a></td>
        <? endif; ?>
    </tr><? if ($contactinfo->PhoneHome != ""): ?>

    <tr>
        <td>&nbsp;</td>

        <td>Phone (Home):</td>

        <td><?=$contactinfo->PhoneHome?>
        </td>
    </tr>
    <? endif; ?>
    <? if ($contactinfo->PhoneWork != ""): ?>

    <tr>
        <td>&nbsp;</td>

        <td>Phone (Work):</td>

        <td><?=$contactinfo->PhoneWork?>
        </td>
    </tr><? endif; ?>
    <? if ($contactinfo->PhoneCell != ""): ?>

    <tr>
        <td>&nbsp;</td>

        <td>Phone (Cell):</td>

        <td><?=$contactinfo->PhoneCell?>
        </td>
    </tr>
    <? endif; ?>
    <? if ($contactinfo->Email != ""): ?>

    <tr>
        <td>&nbsp;</td>

        <td>Email:</td>

        <td><?=$contactinfo->Email?>
        </td>
    </tr>
    <? endif; ?>
    <? if ($contactinfo->_ContactInfoTeamsListObject->MainContact == 1): ?>

    <tr>
        <td>&nbsp;</td>

        <td>Main Contact:</td>

        <td>YES</td>
    </tr>
    <? else: ?>

    <tr>
        <td>&nbsp;</td>

        <td>Main Contact:</td>

        <td>NO</td>
    </tr>
    <? endif; ?>
<? endwhile; ?>
</table>

