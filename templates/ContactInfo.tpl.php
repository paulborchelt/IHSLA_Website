<table cellspacing="1" cellpadding="1" border="0">
    <tr>
        <td></td>

        <td></td>

        <td></td>

        <td></td>
    </tr>
<?php while ( $contactinfo = $result->fetchNextObject() ): ?>
    <tr>
        <td><b><?php echo $contactinfo->_ContactTypeObject->Type?>
        </b></td>

        <td><b>Name:</b></td>

        <td><b><?php echo $contactinfo->FirstName?>
         <?php echo $contactinfo->LastName?>
        </b></td>
        <td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=Edit&Id=<?php echo $contactinfo->Id?>&Team_ID=<?php echo $contactinfo->_ContactInfoTeamsListObject->TID?>&ID=<?php echo $contactinfo->_ContactInfoTeamsListObject->TID?>"> <img src= /images/site_images/icon_edit.gif></a>
        <a href="<?php echo $_SERVER['PHP_SELF']?>?action=Delete&Id=<?php echo $contactinfo->Id?>&Team_ID=<?php echo $contactinfo->_ContactInfoTeamsListObject->TID?>"> <img src= /images/site_images/icon_delete.gif></a></td>
    </tr>
    
    <?php if ($contactinfo->PhoneHome != ""): ?>

    <tr>
        <td>&nbsp;</td>

        <td>Phone (Home):</td>

        <td><?php echo $contactinfo->PhoneHome?>
        </td>
    </tr>
    <?php endif; ?>
    <?php if ($contactinfo->PhoneWork != ""): ?>

    <tr>
        <td>&nbsp;</td>

        <td>Phone (Work):</td>

        <td><?php echo $contactinfo->PhoneWork?>
        </td>
    </tr><?php endif; ?>
    <?php if ($contactinfo->PhoneCell != ""): ?>

    <tr>
        <td>&nbsp;</td>

        <td>Phone (Cell):</td>

        <td><?php echo $contactinfo->PhoneCell?>
        </td>
    </tr>
    <?php endif; ?>
    <?php if ($contactinfo->Email != ""): ?>

    <tr>
        <td>&nbsp;</td>

        <td>Email:</td>

        <td><?php echo $contactinfo->Email?>
        </td>
    </tr>
    <?php endif; ?>
    <?php if ($contactinfo->_ContactInfoTeamsListObject->MainContact == 1): ?>

    <tr>
        <td>&nbsp;</td>

        <td>Main Contact:</td>

        <td>YES</td>
    </tr>
    <?php else: ?>

    <tr>
        <td>&nbsp;</td>

        <td>Main Contact:</td>

        <td>NO</td>
    </tr>
    <?php endif; ?>
<?php endwhile; ?>
    <tr>
        <td>&nbsp;</td>

        <td>&nbsp;</td>'
        <!--
        <td><a href="<?php echo $_SERVER['PHP_SELF']?>?Team_ID=<?php echo $teamid?>&action=AddContact">Add Conact</a></td>
        -->
    </tr>
</table>

