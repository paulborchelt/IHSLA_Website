
<head>
<style type="text/css">
.style1 {
	font-size: small;
}
.style2 {
	margin-left: 11px;
}
</style>
</head>

<form method="post" action="" style="height: 254px">
    <strong><span class="style1">Select the official you would like to evaluate 
	or </span><br class="style1"><span class="style1">add/change official for 
	this game so you can evaluate them.</span></strong><table >
        <tr>
               <td>Select</td>
               <td  >Type</td>
               <td  >Name</td><td align="left">Change Official</td>
               <td>&nbsp;</td>
         </tr>
        <tr>
            <? if ($refereeinfo->FirstName == null): ?>
               <td><input TYPE="button" value="Add Official" onClick="location.href='<?=$_SERVER['PHP_SELF']?>?action=AddOfficialDisplay&officialtype=Referee&Game_ID=<?=$Game_ID?>&Team_ID=<?=$Team_ID?>'"></td>
               <td  >Referee</td>
            <? else:?>
               <td  >
			   <input name="official" value="<?=$refereeinfo->Id?>" type="radio" align="left" style="width: 35px"> </td>
               <td  >Referee</td><td align="left"><?=$refereeinfo->FirstName?> <?=$refereeinfo->LastName?></td>
               <td>
			   <input TYPE="button" value="Change" onClick="location.href='<?$_SERVER['PHP_SELF']?>?action=EditOfficial&idcontactinfo=<?=$refereeinfo->Id?>&officialtype=Referee&Game_ID=<?=$Game_ID?>&Team_ID=<?=$Team_ID?>'"></td>
            <? endif; ?>
         </tr>
         <tr>
            <? if ($umpireinfo->FirstName == null): ?>
               <td> <input TYPE="button" value="Add Official" onClick="location.href='<?=$_SERVER['PHP_SELF']?>?action=AddOfficialDisplay&officialtype=Umpire&Game_ID=<?=$Game_ID?>&Team_ID=<?=$Team_ID?>'"></td>
               <td  >Umpire</td>
            <? else:?>
               <td  >
			   <input name="official" value="<?=$umpireinfo->Id?>" type="radio" align="left" style="width: 39px"></td>
               <td  >Umpire</td><td align="left"><?=$umpireinfo->FirstName?> <?=$umpireinfo->LastName?></td>
               <td> 
			   <input TYPE="button" value="Change" onClick="location.href='<?$_SERVER['PHP_SELF']?>?action=EditOfficial&idcontactinfo=<?=$umpireinfo->Id?>&officialtype=Umpire&Game_ID=<?=$Game_ID?>&Team_ID=<?=$Team_ID?>'"> </td>
            <? endif; ?>
         </tr>
         <tr>
            <? if ($fieldjudgeinfo->FirstName == null): ?>
                <td><input TYPE="button" value="Add Official" onClick="location.href='<?=$_SERVER['PHP_SELF']?>?action=AddOfficialDisplay&officialtype=Field_Judge&Game_ID=<?=$Game_ID?>&Team_ID=<?=$Team_ID?>'"></td>
                <td  >Field Judge</td>
            <? else:?>
               <td  >
			   <input name="official" value="<?=$fieldjudgeinfo->Id?>" type="radio" align="left" style="width: 38px"></td>
               <td  >Field Judge</td><td align="left"><?=$fieldjudgeinfo->FirstName?> <?=$fieldjudgeinfo->LastName?></td>
               <td> 
			   <input TYPE="button" value="Change" onClick="location.href='<?$_SERVER['PHP_SELF']?>?action=EditOfficial&idcontactinfo=<?=$fieldjudgeinfo->Id?>&officialtype=Field_Judge&Game_ID=<?=$Game_ID?>&Team_ID=<?=$Team_ID?>'"></td>
               
            <? endif; ?>
        	<br>
         </tr>
         </table>
        <input type="HIDDEN" name="action" value="DisplayEvaluation">
        <input type="HIDDEN" name="Game_ID" value=<?=$Game_ID?>>
        <input type="HIDDEN" name="Team_ID" value=<?=$Team_ID?>>
        <br>
		<input name="Submit1" type="submit" value="Evaluate" /><input TYPE="button" value="Back" onClick="location.href='<?=$_SERVER['PHP_SELF']?>?Team_ID=<?=$Team_ID?>'" class="style2" style="width: 63px"></form>