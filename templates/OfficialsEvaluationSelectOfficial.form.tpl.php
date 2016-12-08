
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
            <?php if ($refereeinfo->FirstName == null): ?>
               <td><input TYPE="button" value="Add Official" onClick="location.href='<?php echo $_SERVER['PHP_SELF']?>?action=AddOfficialDisplay&officialtype=Referee&Game_ID=<?php echo $Game_ID?>&Team_ID=<?php echo $Team_ID?>'"></td>
               <td  >Referee</td>
            <?php else:?>
               <td  >
			   <input name="official" value="<?php echo $refereeinfo->Id?>" type="radio" align="left" style="width: 35px"> </td>
               <td  >Referee</td><td align="left"><?php echo $refereeinfo->FirstName?> <?php echo $refereeinfo->LastName?></td>
               <td>
			   <input TYPE="button" value="Change" onClick="location.href='<?php echo $_SERVER['PHP_SELF']?>?action=EditOfficial&idcontactinfo=<?php echo $refereeinfo->Id?>&officialtype=Referee&Game_ID=<?php echo $Game_ID?>&Team_ID=<?php echo $Team_ID?>'"></td>
            <?php endif; ?>
         </tr>
         <tr>
            <?php if ($umpireinfo->FirstName == null): ?>
               <td> <input TYPE="button" value="Add Official" onClick="location.href='<?php echo $_SERVER['PHP_SELF']?>?action=AddOfficialDisplay&officialtype=Umpire&Game_ID=<?php echo $Game_ID?>&Team_ID=<?php echo $Team_ID?>'"></td>
               <td  >Umpire</td>
            <?php else:?>
               <td  >
			   <input name="official" value="<?php echo $umpireinfo->Id?>" type="radio" align="left" style="width: 39px"></td>
               <td  >Umpire</td><td align="left"><?php echo $umpireinfo->FirstName?> <?php echo $umpireinfo->LastName?></td>
               <td> 
			   <input TYPE="button" value="Change" onClick="location.href='<?php echo $_SERVER['PHP_SELF']?>?action=EditOfficial&idcontactinfo=<?php echo $umpireinfo->Id?>&officialtype=Umpire&Game_ID=<?php echo $Game_ID?>&Team_ID=<?php echo $Team_ID?>'"> </td>
            <?php endif; ?>
         </tr>
         <tr>
            <?php if ($fieldjudgeinfo->FirstName == null): ?>
                <td><input TYPE="button" value="Add Official" onClick="location.href='<?php echo $_SERVER['PHP_SELF']?>?action=AddOfficialDisplay&officialtype=Field_Judge&Game_ID=<?php echo $Game_ID?>&Team_ID=<?php echo $Team_ID?>'"></td>
                <td  >Field Judge</td>
            <?php else:?>
               <td  >
			   <input name="official" value="<?php echo $fieldjudgeinfo->Id?>" type="radio" align="left" style="width: 38px"></td>
               <td  >Field Judge</td><td align="left"><?php echo $fieldjudgeinfo->FirstName?> <?php echo $fieldjudgeinfo->LastName?></td>
               <td> 
			   <input TYPE="button" value="Change" onClick="location.href='<?php echo $_SERVER['PHP_SELF']?>?action=EditOfficial&idcontactinfo=<?php echo $fieldjudgeinfo->Id?>&officialtype=Field_Judge&Game_ID=<?php echo $Game_ID?>&Team_ID=<?php echo $Team_ID?>'"></td>
               
            <?php endif; ?>
        	<br>
         </tr>
         </table>
        <input type="HIDDEN" name="action" value="DisplayEvaluation">
        <input type="HIDDEN" name="Game_ID" value=<?php echo $Game_ID?>>
        <input type="HIDDEN" name="Team_ID" value=<?php echo $Team_ID?>>
        <br>
		<input name="Submit1" type="submit" value="Evaluate" /><input TYPE="button" value="Back" onClick="location.href='<?php echo $_SERVER['PHP_SELF']?>?Team_ID=<?php echo $Team_ID?>'" class="style2" style="width: 63px"></form>