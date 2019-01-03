<!DOCTYPE html>
<html lang="en">
  <?php include('templates/include/header.html')?>
  <body>
    <?php include('templates/pages/navbar.tpl.php')?>
    <div class="container-fluid">
      <div class="row-fluid">
          <?php include('templates/include/sidebar.html')?>
        <div class="span9">
          <div class="hero-unit">
            <h3>Congratulation to Hamilton Southeastern the 2018 State Champions.</h3>
            <p>Welcome all students, parents, and visitors to the Indiana High School Lacrosse Association (IHSLA) website.Here you will find all the information you need to know about boys high school lacrosse in the state of Indiana. The league will provide informational updates in the news section below and you can view information about our league, teams, schedule and stats with the links above.</p>
            <p><a href="leagueinfo.php" class="btn btn-primary btn-large">Learn more &raquo;</a></p>
          </div>
          <?php echo $newscards ?>
      </div><!--/row-->

      <footer>
        <p>&copy; Company 2017</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap_js/jquery.js"></script>
    <script src="js/bootstrap_js/bootstrap-transition.js"></script>
    <script src="js/bootstrap_js/bootstrap-alert.js"></script>
    <script src="js/bootstrap_js/bootstrap-modal.js"></script>
    <script src="js/bootstrap_js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap_js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap_js/bootstrap-tab.js"></script>
    <script src="js/bootstrap_js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap_js/bootstrap-popover.js"></script>
    <script src="js/bootstrap_js/bootstrap-button.js"></script>
    <script src="js/bootstrap_js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap_js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap_js/bootstrap-typeahead.js"></script>

  </body>
</html>