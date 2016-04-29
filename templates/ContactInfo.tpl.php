<table cellspacing="1" cellpadding="1" border="0">
    <tr>
        <td></td>

        <td></td>

        <td></td>

        <td></td>
    </tr>
<? while ( $contactinfo = $result->fetchNextObject() ): ?>
    <tr>
        <td><b><?=$contactinfo->_ContactTypeObject->Type?>
        </b></td>

        <td><b>Name:</b></td>

        <td><b><?=$contactinfo->FirstName?>
         <?=$contactinfo->LastName?>
        </b></td>
        <td><a href="<?$_SERVER['PHP_SELF']?>?action=Edit&Id=<?=$contactinfo->Id?>&Team_ID=<?=$contactinfo->_ContactInfoTeamsListObject->TID?>&ID=<?=$contactinfo->_ContactInfoTeamsListObject->TID?>"> <img src= /images/site_images/icon_edit.gif></a>
        <a href="<?$_SERVER['PHP_SELF']?>?action=Delete&Id=<?=$contactinfo->Id?>&Team_ID=<?=$contactinfo->_ContactInfoTeamsListObject->TID?>"> <img src= /images/site_images/icon_delete.gif></a></td>
    </tr>
    
    <? if ($contactinfo->PhoneHome != ""): ?>

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
    <tr>
        <td>&nbsp;</td>

        <td>&nbsp;</td>'
        <!--
        <td><a href="<?=$_SERVER['PHP_SELF']?>?Team_ID=<?=$teamid?>&action=AddContact">Add Conact</a></td>
        -->
    </tr>
</table>

