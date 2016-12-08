<table class="table table-condensed span3">
   <thead>
      <tr>
         <th><h4>Team</h4></th>
         <?php foreach ( $Score->homeQuarterScore as $quarter => $score ): ?>
            <th><h4><?php echo Points_Row::getQuarterName($quarter)?></h4></th>
         <?php endforeach; ?>
         <th><h4>Final</h4></th>
      </tr>
   </thead>
     <tr>
         <td><?php echo $Score->_HomeTeamObject->Team_Name?></td>
         <?php foreach ( $Score->homeQuarterScore as $score ): ?>
            <td><?php echo $score?></td>
         <?php endforeach; ?>
         <td><?php echo $Score->homeScore?></td>
     </tr>
     <tr>
         <td><?php echo $Score->_AwayTeamObject->Team_Name?></td>
         <?php foreach ( $Score->awayQuarterScore as $score ): ?>
            <td><?php echo $score?></td>
         <?php endforeach; ?>
         <td><?php echo $Score->awayScore?></td>
     </tr>
 </table> 