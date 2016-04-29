
<div>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <table style="width: 1412px">
        <tr>
            <td style="width: 198px">Linked Team</td>
            <td style="width: 203px">Host Team</td>
        </tr>
        <tr>
            <td style="height: 43px; width: 198px;"><select name="idlinkedteam">
                <?=$linkteamoptions?>
                </select></td>

            <td style="height: 43px; width: 203px;"><select name="idhostteam">
                <?=$hostteamoptions?>
                </select></td>
                
            <td style="height: 43px"></td>
            <? if ($submittype == "Submit"): ?>
            <td style="height: 43px"><INPUT TYPE="HIDDEN" NAME="action" VALUE=Enter ><INPUT type="submit" name="Submit" value="SUBMIT" ></td>
            <? else:?>
            <td style="height: 43px"><INPUT TYPE="HIDDEN" NAME="action" VALUE=SubmitEdit ><INPUT type="submit" name="Edit" value="EDIT" ></td>
            <? endif; ?>
        </tr>
    </table>
</form>

<button type="button" onClick="window.location='AdminTeamsTest.php'" name="AddTeam">Add Team</button>
	<br><br></div>
 

<?=$list_of_team_associations?>