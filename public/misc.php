<?php
$title = "Information Management System";

require 'includes/main-include.php';
require 'includes/panel-header.php';
?>

<!-- Full Width Column -->
 <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>Employee Directory
          <!-- <small>Example 2.0</small> -->
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">

	  <div class="box box-default">
          <div class="box-body">

<?php

require 'views/misc.php';

require 'documents/changelog.htm';

?>

<div id="console"></div>

</div>
          <!-- /.box-body -->
        </div>

</section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->


<?php

require 'includes/panel-footer.php'; 
