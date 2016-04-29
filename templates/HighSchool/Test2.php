 <!DOCTYPE html>
<html lang="en"> 
  <head>
    <meta charset="utf-8">
    <title>Indiana High School Lacrosse Association (IHSLA)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="../css/bootstrap_311_css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap_css/datepicker.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
    <link href="../css/bootstrap_css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../js/bootstrap_js/html5shiv.js"></script>
    <![endif]-->

  </head>
  
  <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div class="collapse navbar-collapse">
         <p class="navbar-text pull-right">
           Logged in as <a href="#" class="navbar-link">Username</a>
         </p>        
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
           <li><a href="leagueinfo.php">Legaue Info</a></li>
           <li><a href="teams.php">Teams</a></li>
           <li><a href="schedule.php">Schedule</a></li>
           <li><a href="stats.php">Stats</a></li>
           <li><a href="Links.php">Links</a></li>
           <li><a href="login.php">Coaches Area</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
  

 <body>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../js/bootstrap_311_js/bootstrap.min.js"></script>
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