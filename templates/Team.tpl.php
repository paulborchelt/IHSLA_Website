
<table cellspacing="1" cellpadding="1" border="0">
    <valign="top"><font color="#000066"><b><font size="3" face="Arial, Helvetica, sans-serif"><?php echo$team->Team_Name?> High School</font></b></font>
    <?php if ( $edit == EDIT ): ?>

    <tr>
        <td><b>School Information</b></td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>
        <!--
        <td><a href="AdminTeams.php?link=UpdateTeamInfoTest.php?Team_ID=<?php echo$team->Team_ID?>&Team_ID=<?php echo$team->Team_ID?>&action=Edit"><img src=" /HighSchool/images/icon_edit.gif"></a></td>
        -->
    </tr>
    
    <?php else:?>

    <tr>
        <td><b>School Information</b></td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>
    </tr>
    
    <?php endif; ?>

    <tr>
        <td>&nbsp;</td>

        <td>School Address:</td>

        <td><?php echo$team->Address?></td>
    </tr>

    <tr>
        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td><?php echo$team->ZIP?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>

        <td>Phone:</td>

        <td><?php echo$team->Phone?></td>
    </tr>

    <tr>
        <td>&nbsp;</td>

        <td>Home Colors</td>

        <td><?php echo$team->Home_Colors?></td>
    </tr>

    <tr>
        <td>&nbsp;</td>

        <td>Away Colors</td>

        <td><?php echo$team->Away_Colors?></td>
    </tr>

    <tr>
        <td>&nbsp;</td>

        <td>Mascot</td>

        <td><?php echo$team->Mascot?></td>
    </tr>
        <tr>
        <td>&nbsp;</td>

        <td>Class:</td>

        <td><?php echo$team->getClassName()?></td>
    </tr>
    
</table>

