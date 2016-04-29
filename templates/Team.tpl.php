
<table cellspacing="1" cellpadding="1" border="0">
    <valign="top"><font color="#000066"><b><font size="3" face="Arial, Helvetica, sans-serif"><?=$team->Team_Name?> High School</font></b></font>
    <? if ( $edit == EDIT ): ?>

    <tr>
        <td><b>School Information</b></td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>
        <!--
        <td><a href="AdminTeams.php?link=UpdateTeamInfoTest.php?Team_ID=<?=$team->Team_ID?>&Team_ID=<?=$team->Team_ID?>&action=Edit"><img src=" /HighSchool/images/icon_edit.gif"></a></td>
        -->
    </tr>
    
    <? else:?>

    <tr>
        <td><b>School Information</b></td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>
    </tr>
    
    <? endif; ?>

    <tr>
        <td>&nbsp;</td>

        <td>School Address:</td>

        <td><?=$team->Address?></td>
    </tr>

    <tr>
        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td><?=$team->ZIP?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>

        <td>Phone:</td>

        <td><?=$team->Phone?></td>
    </tr>

    <tr>
        <td>&nbsp;</td>

        <td>Home Colors</td>

        <td><?=$team->Home_Colors?></td>
    </tr>

    <tr>
        <td>&nbsp;</td>

        <td>Away Colors</td>

        <td><?=$team->Away_Colors?></td>
    </tr>

    <tr>
        <td>&nbsp;</td>

        <td>Mascot</td>

        <td><?=$team->Mascot?></td>
    </tr>
        <tr>
        <td>&nbsp;</td>

        <td>Class:</td>

        <td><?=$team->getClassName()?></td>
    </tr>
    
</table>

