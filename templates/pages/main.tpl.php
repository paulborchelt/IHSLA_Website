<!DOCTYPE html>
<html lang="en">
  <?include('../templates/include/header.html')?>
  
  <body>
  
    <?include('../templates/pages/navbar.tpl.php')?>

    <div class="container-fluid">
      <div class="row-fluid">
         <?include('../templates/include/sidebar.html')?>
         <div class="span9">
            <?=$logging?>
            <?=$selectYear?>
            <?=$content?>
         </div><!--/span-->
      </div><!--/row-->

      <hr>
      
      <footer>
        <p>&copy; IHSLA 2014</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../js/bootstrap_js/bootstrap-transition.js"></script>
    <script src="../js/bootstrap_js/bootstrap-alert.js"></script>
    <script src="../js/bootstrap_js/bootstrap-modal.js"></script>
    <script src="../js/bootstrap_js/bootstrap-dropdown.js"></script>
    <script src="../js/bootstrap_js/bootstrap-scrollspy.js"></script>
    <script src="../js/bootstrap_js/bootstrap-tab.js"></script>
    <script src="../js/bootstrap_js/bootstrap-tooltip.js"></script>
    <script src="../js/bootstrap_js/bootstrap-popover.js"></script>
    <script src="../js/bootstrap_js/bootstrap-button.js"></script>
    <script src="../js/bootstrap_js/bootstrap-collapse.js"></script>
    <script src="../js/bootstrap_js/bootstrap-carousel.js"></script>
    <script src="../js/bootstrap_js/bootstrap-typeahead.js"></script>
    <script src="../js/bootstrap_js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
      $(function(){
         $('.datepicker').datepicker({
            format: 'mm/dd/yyyy'
          });
      });
      </script>

  </body>
</html>