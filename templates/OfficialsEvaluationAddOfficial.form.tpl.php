<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <table style="width: 1412">
        <tr>
        <td style="width: 121px">Official</td><td style="height: 63px"><select name="Id"><?=$officialoptions?></select></td>
        </tr>
        <tr>
            <td style="height: 63px; width: 121px;"><INPUT TYPE="HIDDEN" NAME="action" VALUE=Enter ><INPUT type="submit" name="Submit" value="SUBMIT" ></td>
            <input type="HIDDEN" name="Team_ID" value=<?=$Team_ID?> >
            <input type="HIDDEN" name="Game_ID" value=<?=$Game_ID?> >
            <input type="HIDDEN" name="officialtype" value=<?=$officialtype?>>
            <input type="HIDDEN" name="action" value="AddOfficial">
        </tr>
    </table>
</form>