<table class="table table-condensed span3">
   <thead>
      <tr>
         <th><h4>Team</h4></th>
         <? foreach ( $Score->homeQuarterScore as $quarter => $score ): ?>
            <th><h4><?=Points_Row::getQuarterName($quarter)?></h4></th>
         <? endforeach; ?>
         <th><h4>Final</h4></th>
      </tr>
   </thead>
     <tr>
         <td><?=$Score->_HomeTeamObject->Team_Name?></td>
         <? foreach ( $Score->homeQuarterScore as $score ): ?>
            <td><?=$score?></td>
         <? endforeach; ?>
         <td><?=$Score->homeScore?></td>
     </tr>
     <tr>
         <td><?=$Score->_AwayTeamObject->Team_Name?></td>
         <? foreach ( $Score->awayQuarterScore as $score ): ?>
            <td><?=$score?></td>
         <? endforeach; ?>
         <td><?=$Score->awayScore?></td>
     </tr>
 </table> 