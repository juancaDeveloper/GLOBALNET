<?php
defined('_JEXEC') or die('Access Dany');

?>

  <?php
    foreach ($result['packages'] as $pkg ) {
  ?>
      <?php
        echo 'Title = '.$pkg->title.'<br>';
      ?>


      <?php
        echo 'Price = '.$pkg->symbol.$pkg->price.'<br>';
      ?>
      <?php
        if(isset($pkg->resumeallow)) {
           echo $pkg->resumeallow.'Resume Allowed';
        }else{
          echo $pkg->companiesallow.'Companies Allowed';
        }
      ?>
      <?php
        if (isset($pkg->applyjobs)) {
          echo $pkg->applyjobs.'  '.'Apply Jobs';
       }else{    
          echo $pkg->jobsallow.'  '.'Jobs Allowed';
       }
      ?>
      <?php
      ?>
      <?php
        if (isset($pkg->jobsallow)) {

        }else{
        echo 'Resume Seaarch = '.$pkg->resumesearch.'<br>';
        }
      ?>
      <?php
        if (isset($pkg->savejobsearch)) {
         $pkg->savejobsearch.'  '.'Save job Search';
      }else{
        echo $pkg->saveresumesearch.'  '.'Save Resume Search';
      }
      ?>
      <?php
        echo 'Expire in Days = '.$pkg->packageexpireindays.'<br>';?>
  <?php
    }
  ?>
 