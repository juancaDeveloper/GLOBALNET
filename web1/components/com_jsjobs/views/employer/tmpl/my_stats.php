<?php

/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     https://www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}


$document->addScript('components/com_jsjobs/js/responsivetable.js');

?>
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>                     
            <a class="js_menu_link <?php if ($lnk[2] == 'coverletter') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'coverletter') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    ?>
</div>
<?php
if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else {
  ?>
  <div id="jsjobs-main-wrapper">
      <span class="jsjobs-main-page-title"><?php echo JText::_('Stats'); ?></span>
  <?php
    if ($this->mystats_allowed == VALIDATE) { // employer
        $isodd = 0;
        ?>
            <?php
            if ($this->ispackagerequired != 1) {
                $message = "<strong>" . JText::_('Package Not Required') . "</strong>";
                ?>
                <div id="stats-package-message">
                    <img class="package-massage-img" src="<?php echo JURI::root();?>components/com_jsjobs/images/icon-massage-stats.png"> <?php echo $message; ?>
                </div>

                <?php
            } ?>
            <span class="jsjobs-stats-title"><?php echo JText::_('My Stats'); ?></span>
            <div class="jsjobs-listing-stats-wrapper">
                <div class="jsjobs-icon-wrap">
                   <img class="jsjobs-img" src="<?php echo JURI::root();?>components/com_jsjobs/images/statsicon/company.png">
                   <span class="stats-data-value"><?php echo $this->totalcompanies; ?></span>
                   <span class="stats-data-title"><?php echo JText::_('Companies'); ?></span>
                </div>
                <div class="jsjobs-icon-wrap">
                    <img class="jsjobs-img" src="<?php echo JURI::root();?>components/com_jsjobs/images/statsicon/jobs.png">
                    <span class="stats-jobs-value"><?php echo $this->totaljobs; ?></span>
                    <span class="stats-data-title"><?php echo JText::_('Jobs'); ?></span>
                </div>
                 <div class="jsjobs-icon-wrap">
                    <img class="jsjobs-img" src="<?php echo JURI::root();?>components/com_jsjobs/images/statsicon/gold-company.png">
                    <span class="stats-golddata-value"><?php echo $this->totalgoldcompanies; ?></span>
                    <span class="stats-data-title"><?php echo JText::_('Gold Companies'); ?></span>
                </div>
                <div class="jsjobs-icon-wrap">
                    <img class="jsjobs-img" src="<?php echo JURI::root();?>components/com_jsjobs/images/statsicon/featured-company.png">
                    <span class="stats-featuredata-value"><?php echo $this->totalfeaturedcompanies; ?></span>
                    <span class="stats-data-title"><?php echo JText::_('Featured Companies'); ?></span>
                </div>
                <div class="jsjobs-icon-wrap">
                    <img class="jsjobs-img" src="<?php echo JURI::root();?>components/com_jsjobs/images/statsicon/gold-job.png">
                    <span class="stats-golddata-value"><?php echo $this->totalgoldjobs; ?></span>
                    <span class="stats-data-title"><?php echo JText::_('Gold Jobs'); ?></span>
                </div>
                <div class="jsjobs-icon-wrap">
                    <img class="jsjobs-img" src="<?php echo JURI::root();?>components/com_jsjobs/images/statsicon/featured-job.png">
                    <span class="stats-featuredata-value"><?php echo $this->totalfeaturedjobs; ?></span>
                    <span class="stats-data-title"><?php echo JText::_('Featured Jobs'); ?></span>
                </div>
            </div>            
            <div class="jsjobs-listing-stats-wrapper">
               <table id="js-table">
                   <thead>
                       <th>
                           <?php echo JText::_('Jobs'); ?>
                       </th>
                       <th class="center">
                           <?php echo JText::_('Allow'); ?>
                       </th>
                       <th class="center">
                           <?php echo JText::_('Published'); ?>
                       </th>
                       <th class="center">
                           <?php echo JText::_('Expired'); ?>
                       </th>
                       <th class="center">
                           <?php echo JText::_('Available'); ?>
                       </th>
                       <tbody>
                           <tr class="bodercolor5_rs">
                               <td class="color3 bodercolor5">
                                  <?php echo JText::_('Jobs'); ?> 
                               </td>
                               <td class="center color">
                               <?php
                                    if ($this->ispackagerequired != 1) {
                                        echo JText::_('Unlimited');
                                    } elseif ($this->jobsallow == -1) {
                                        echo JText::_('Unlimited');
                                    } else
                                        echo $this->jobsallow;
                                ?>
                                </td>
                               <td class="center color2">
                                     <?php echo $this->publishedjob; ?>
                               </td>
                               <td class="center color4">
                                     <?php echo $this->expiredjob; ?>
                               </td>
                               <td class="center color5">
                                    <?php
                                        if ($this->ispackagerequired != 1) {
                                            echo JText::_('Unlimited');
                                        } elseif ($this->jobsallow == -1) {
                                            echo JText::_('Unlimited');
                                        } else {
                                            $available_jobs = $this->jobsallow - $this->totaljobs;
                                            echo $available_jobs;
                                        }
                                    ?> 
                               </td>
                           </tr>
                           <tr class="bodercolor6_rs">
                               <td  class="color3 bodercolor6"><?php echo JText::_('Gold Jobs'); ?></td>
                               <td class="center color">
                                   <?php
                                    if ($this->ispackagerequired != 1) {
                                        echo JText::_('Unlimited');
                                    } else if ($this->goldjobsallow == -1) {
                                        echo JText::_('Unlimited');
                                    } else
                                        echo $this->goldjobsallow;
                                    ?>
                               </td>
                               <td class="center color2"> <?php echo $this->publishedgoldjob; ?></td>
                               <td class="center color4"> <?php echo $this->expiregoldjob; ?></td>
                               <td class="center color5">
                                   <?php
                                    if ($this->ispackagerequired != 1) {
                                        echo JText::_('Unlimited');
                                    } elseif ($this->goldjobsallow == -1) {
                                        echo JText::_('Unlimited');
                                    } else {
                                        $available_goldjobs = $this->goldjobsallow - $this->totalgoldjobs;
                                        echo $available_goldjobs;
                                    }
                                    ?>
                               </td>
                           </tr>
                           <tr class="bodercolor7_rs">
                               <td  class="color3 bodercolor7"><?php echo JText::_('Featured Jobs'); ?></td>
                               <td class="center color">
                                    <?php
                                    if ($this->ispackagerequired != 1) {
                                        echo JText::_('Unlimited');
                                    } elseif ($this->featuredjobsallow == -1) {
                                        echo JText::_('Unlimited');
                                    } else
                                        echo $this->featuredjobsallow;
                                    ?>  
                                </td>
                               <td class="center color2"> <?php echo $this->publishedgoldjob; ?></td>
                               <td class="center color4"> <?php echo $this->expiregoldjob; ?></td>
                               <td class="center color5"> 
                                    <?php
                                    if ($this->ispackagerequired != 1) {
                                        echo JText::_('Unlimited');
                                    } elseif ($this->featuredjobsallow == -1) {
                                        echo JText::_('Unlimited');
                                    } else {
                                        $available_featuredjobs = $this->featuredjobsallow - $this->totalfeaturedjobs;
                                        echo $available_featuredjobs;
                                    }
                                    ?>
                               </td>
                           </tr>
                       </tbody>
                   </thead>
               </table>
                
            </div>            
            <div class="jsjobs-listing-stats-wrapper">
               <table id="js-table" class="second">
                  <thead>
                      <th>
                         <?php echo JText::_('Companies'); ?> 
                      </th>
                      <th class="center">
                          <?php echo JText::_('Allow'); ?>
                      </th>
                      <th class="center">
                          <?php echo JText::_('Published'); ?>
                      </th>
                      <th class="center">
                          <?php echo JText::_('Expired'); ?>
                      </th>
                      <th class="center">
                          <?php echo JText::_('Available'); ?>
                      </th>
                  </thead>
                  <tbody>
                      <tr class="bodercolor5_rs">
                          <td  class="color3 bodercolor5"><?php echo JText::_('Companies'); ?></td>
                          <td class="center color">
                               <?php
                                if ($this->ispackagerequired != 1) {
                                    echo JText::_('Unlimited');
                                } elseif ($this->companiesallow == -1) {
                                    echo JText::_('Unlimited');
                                } else
                                    echo $this->companiesallow;
                                ?>
                          </td>
                          <td class="center color2">
                              <?php echo $this->totalcompanies; ?>
                          </td>
                          <td class="center color4">
                               <?php echo '0'; ?>
                          </td>
                          <td class="center color5">
                              <?php
                                if ($this->ispackagerequired != 1) {
                                    echo JText::_('Unlimited');
                                } elseif ($this->companiesallow == -1) {
                                    echo JText::_('Unlimited');
                                } else {
                                    $available_companies = $this->companiesallow - $this->totalcompanies;
                                    echo $available_companies;
                                }
                              ?> 
                          </td>
                      </tr>
                      <tr class="bodercolor6_rs">
                          <td  class="color3 bodercolor6"><?php echo JText::_('Gold Companies'); ?></td>
                          <td class="center color">
                              <?php
                                if ($this->ispackagerequired != 1) {
                                    echo JText::_('Unlimited');
                                } elseif ($this->goldcompaniesallow == -1) {
                                    echo JText::_('Unlimited');
                                } else
                                    echo $this->goldcompaniesallow;
                                ?>
                          </td>
                          <td class="center color2"><?php echo $this->totalgoldcompanies; ?></td>
                          <td class="center color4"> <?php echo $this->goldcompaniesexpire; ?></td>
                          <td class="center color5">
                              <?php
                                if ($this->ispackagerequired != 1) {
                                    echo JText::_('Unlimited');
                                } elseif ($this->goldcompaniesallow == -1) {
                                    echo JText::_('Unlimited');
                                } else {
                                    $available_gold_companies = $this->goldcompaniesallow - $this->totalgoldcompanies;
                                    echo $available_gold_companies;
                                }
                                ?>
                          </td>
                      </tr>
                      <tr class="bodercolor7_rs">
                          <td  class="color3 bodercolor7"><?php echo JText::_('Featured Companies'); ?></td>
                          <td class="center color">
                               <?php
                                if ($this->ispackagerequired != 1) {
                                    echo JText::_('Unlimited');
                                } elseif ($this->featuredcompainesallow == -1) {
                                    echo JText::_('Unlimited');
                                } else
                                    echo $this->featuredcompainesallow;
                                ?>
                          </td>
                          <td class="center color2"><?php echo $this->totalfeaturedcompanies; ?></td>
                          <td class="center color4"> <?php echo $this->featurescompaniesexpire; ?></td>
                          <td class="center color5">
                              <?php
                                if ($this->ispackagerequired != 1) {
                                    echo JText::_('Unlimited');
                                } elseif ($this->featuredcompainesallow == -1) {
                                    echo JText::_('Unlimited');
                                } else {
                                    $available_gold_companies = $this->featuredcompainesallow - $this->totalfeaturedcompanies;
                                    echo $available_gold_companies;
                                }
                                ?>
                          </td>
                      </tr>
                  </tbody>
               </table> 
            </div>
            
            <?php
        } 
        ?>
            </div>
        <?php

        switch ($this->mystats_allowed) {
            case JOBSEEKER_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('Job seeker not allowed', 'Job seeker is not allowed in employer private area', 0);
                break;
            case USER_ROLE_NOT_SELECTED:
                $link = "index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=".$this->Itemid;
                $vartext = JText::_('You do not select your role').','.JText::_('Please select your role');
                $this->jsjobsmessages->getUserNotSelectedMsg('You do not select your role', $vartext, $link);
                break;
            case VISITOR_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('You are not logged in', 'Please login to access private area', 1);
                break;
        }
    }//ol
    ?>	
</div> 
<script type="text/javascript">
jQuery(document).ready(function(){

  // responsive tables
  var headertext = [];
  headers = document.querySelectorAll("#js-table.second th");
  tablerows = document.querySelectorAll("#js-table.second th");
  tablebody = document.querySelector("#js-table.second tbody");

  for(var i = 0; i < headers.length; i++) {
    var current = headers[i];
    headertext.push(current.textContent.replace(/\r?\n|\r/,""));
  } 
  for (var i = 0; row = tablebody.rows[i]; i++) {
    for (var j = 0; col = row.cells[j]; j++) {
      col.setAttribute("data-th", headertext[j]);
    } 
  }
});  
</script>