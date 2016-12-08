
<div>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <table style="width: 1412px">
        <tr>
            <td style="width: 198px">Linked Team</td>
            <td style="width: 203px">Host Team</td>
        </tr>
        <tr>
            <td style="height: 43px; width: 198px;"><select name="idlinkedteam">
                <?php echo $linkteamoptions?>
                </select></td>

            <td style="height: 43px; width: 203px;"><select name="idhostteam">
                <?php echo $hostteamoptions?>
                </select></td>
                
            <td style="height: 43px"></td>
            <?php if ($submittype == "Submit"): ?>
            <td style="height: 43px"><INPUT TYPE="HIDDEN" NAME="action" VALUE=Enter ><INPUT type="submit" name="Submit" value="SUBMIT" ></td>
            <?php else:?>
            <td style="height: 43px"><INPUT TYPE="HIDDEN" NAME="action" VALUE=SubmitEdit ><INPUT type="submit" name="Edit" value="EDIT" ></td>
            <?php endif; ?>
        </tr>
    </table>
</form>

<button type="button" onClick="window.location='AdminTeamsTest.php'" name="AddTeam">Add Team</button>
	<br><br></div>
 

<?php echo $list_of_team_associations?>