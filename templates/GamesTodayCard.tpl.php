<div class="row-fluid">
    <div class="span4">
    <h5>Varsity Games Today:</h5>
    <p>
        <small>
        <?php while ( $schedule = $result->fetchNextObject() ): ?>
           	<a><?php echo$schedule->_HomeTeamObject->Team_Name?> vs <?php echo$schedule->_AwayTeamObject->Team_Name?> <?php echo$schedule->_TimeObject->getTime()?></a>
            </br>
        <?php endwhile; ?>
        </small>
    </p>
    </div>
</div> 