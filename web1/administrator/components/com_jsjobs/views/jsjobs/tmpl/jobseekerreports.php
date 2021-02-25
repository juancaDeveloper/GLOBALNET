<?php

/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     http://www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */

defined('_JEXEC') or die('Restricted access');

?>
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=reports"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Job Seeker Reports'); ?></span></div>
    <div id="charts">
        <div id="curve_chart"></div>        
    </div>
    <div id="admin-employer-report">
        <div class="count2">
            <div class="js-col-md-3 js-col-lg-3 js-col-xs-12 jsjobs- box-outer">
                <div class="box">
                    <img class="newjobs" src="components/com_jsjobs/include/images/active-jobs.png">
                    <div class="text">
                        <div class="bold-text1"><?php echo $this->jobseekerreports['totaljobs']; ?></div>
                        <div class="nonbold-text"><?php echo JText::_('Active Jobs'); ?></div>   
                    </div>
                </div>
            </div>
            <div class="js-col-md-3 js-col-lg-3 js-col-xs-12 jsjobs- box-outer">
                <div class="box">
                    <img class="newresume" src="components/com_jsjobs/include/images/reume.png">
                    <div class="text">
                        <div class="bold-text2"><?php echo $this->jobseekerreports['totalappliedresume']; ?></div>
                        <div class="nonbold-text"><?php echo JText::_('Applied Jobs'); ?></div>   
                    </div>
                </div>
            </div>
            <div class="js-col-md-3 js-col-lg-3 js-col-xs-12 jsjobs- box-outer">
                <div class="box">
                    <img class="jobapplied" src="components/com_jsjobs/include/images/reume.png">
                    <div class="text">
                        <div class="bold-text3"><?php echo $this->jobseekerreports['totalgoldjob']; ?></div>
                        <div class="nonbold-text"><?php echo JText::_('Gold Jobs'); ?></div>   
                    </div>
                </div>
            </div>
            <div class="js-col-md-3 js-col-lg-3 js-col-xs-12 jsjobs- box-outer">
                <div class="box">
                    <img class="newcompanies" src="components/com_jsjobs/include/images/reume.png">
                    <div class="text">
                        <div class="bold-text4"><?php echo $this->jobseekerreports['totalfeaturedjob']; ?></div>
                        <div class="nonbold-text"><?php echo JText::_('Featured Jobs'); ?></div>   
                    </div>
                </div>
            </div>    
        </div>
        <div class="charthalf">
            <span class="title one">
                <?php echo JText::_('Resume By Categories','js-jobs'); ?>
            </span>
            <div id="pie1"></div>
        </div>        
        <div class="charthalf">
            <span class="title two">
                <?php echo JText::_('Resumes By Types','js-jobs'); ?>
            </span>
            <div id="bar1"></div>
        </div>        
        <div class="charthalf" style="width:98%;">
            <span class="title three">
                <?php echo JText::_('Resumes By Educations','js-jobs'); ?>
            </span>
            <div id="bar2"></div>
        </div>                
        <div class="charthalf" style="display:none;">
            <span class="title four">
                <?php echo JText::_('Resumes By Types','js-jobs'); ?>
            </span>
            <div id="pie2"></div>
        </div>        
    </div>
    </div>
</div>
<div id="jsjobs-footer">
    <table width="100%" style="table-layout:fixed;">
        <tr><td height="15"></td></tr>
        <tr>
            <td style="vertical-align:top;" align="center">
                <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a>
                <br>
                Copyright &copy; 2008 - <?php echo  date('Y') ?> ,
                <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.burujsolutions.com">Buruj Solutions </a></span>
            </td>
        </tr>
    </table>
</div>

<script type="text/javascript">
    google.setOnLoadCallback(drawChartTop);
    function drawChartTop() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', '<?php echo JText::_('Dates','js-jobs'); ?>');
        data.addColumn('number', '<?php echo JText::_('Jobs','js-jobs'); ?>');
        data.addColumn('number', '<?php echo JText::_('Resume','js-jobs'); ?>');
        data.addColumn('number', '<?php echo JText::_('Company','js-jobs'); ?>');
        data.addColumn('number', '<?php echo JText::_('Applied Resume','js-jobs'); ?>');
        data.addRows([
            <?php echo $this->jobseekerreports['line_chart_json_array']; ?>
        ]);        

        var options = {
          colors:['#1EADD8','#179650','#D98E11','#5F3BBB','#DB624C'],
          curveType: 'function',
          legend: { position: 'bottom' },
          pointSize: 6,
          height: 400,
          width: '100%',
          // This line will make you select an entire row of data at a time
          focusTarget: 'category',
          chartArea: {width:'90%',top:50}
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
    }
    google.setOnLoadCallback(drawChartCat);
    function drawChartCat() {
        var piedata = google.visualization.arrayToDataTable([
              ['<?php echo JText::_('Categories','js-jobs'); ?>', '<?php echo JText::_('Jobs','js-jobs'); ?>'],
              <?php echo $this->jobseekerreports['pie1']; ?>
        ]);
        var pieoptions = {title: '',width:'100%',height:300,legend: {position:"bottom"}};
        var piechart = new google.visualization.PieChart(document.getElementById('pie1'));
        piechart.draw(piedata, pieoptions);
    }

    google.setOnLoadCallback(drawChartBar1);
    function drawChartBar1(){
        var data = google.visualization.arrayToDataTable([
                    ['<?php echo JText::_('Job By City','js-jobs'); ?>', '<?php echo JText::_('Jobs','js-jobs'); ?>', { role: 'style' }, { role: 'annotation' } ],
                    <?php echo $this->jobseekerreports['bar1']; ?>
                    ]);
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                           { calc: "stringify",
                             sourceColumn: 1,
                             type: "string",
                             role: "annotation" },
                           2]);

        var options = {
                        title: "",  
                        width:'100%',           
                        height: 300,
                        bar: {groupWidth: "80%"},
                        legend: { position: "none" },
                        chartArea: {width:'90%',top:50}
                    };
        var chart = new google.visualization.BarChart(document.getElementById("bar1"));
        chart.draw(view, options);
    }

    google.setOnLoadCallback(drawChartpie2);
    function drawChartpie2() {
        var piedata = google.visualization.arrayToDataTable([
              ['<?php echo JText::_('Jobs By Company','js-jobs'); ?>', '<?php echo JText::_('Jobs','js-jobs'); ?>'],
              <?php echo $this->jobseekerreports['pie2']; ?>
        ]);
        var pieoptions = {title: '',width:'100%',height:300,legend: {position:"bottom"},pieHole:0.4};
        var piechart = new google.visualization.PieChart(document.getElementById('pie2'));
        piechart.draw(piedata, pieoptions);
    }

    google.setOnLoadCallback(drawChartBar2);
    function drawChartBar2(){
        var data = google.visualization.arrayToDataTable([
                    ['<?php echo JText::_('Job By Type','js-jobs'); ?>', '<?php echo JText::_('Jobs','js-jobs'); ?>', { role: 'style' }, { role: 'annotation' } ],
                      <?php echo $this->jobseekerreports['bar2']; ?>
                    ]);
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                           { calc: "stringify",
                             sourceColumn: 1,
                             type: "string",
                             role: "annotation" },
                           2]);

        var options = {
                        title: "",  
                        width:'100%',           
                        height: 300,
                        bar: {groupWidth: "80%"},
                        legend: { position: "none" },
                        chartArea: {width:'90%',top:50}
                    };
        var chart = new google.visualization.BarChart(document.getElementById("bar2"));
        chart.draw(view, options);
    }

</script>