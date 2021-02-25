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
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=reports"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Overall Reports'); ?></span></div>
        <div id="charts">
            <div id="curve_chart"></div>        
            <div class="boxeswrapper">
                <div class="box">
                    <img src="components/com_jsjobs/include/images/job2.png" />
                    <span class="number"><?php echo $this->overall['totaljobs']; ?></span>
                    <span class="desc"><?php echo JText::_('Total Jobs'); ?></span>
                </div>
                <div class="box">
                    <img src="components/com_jsjobs/include/images/resume2.png" />
                    <span class="number"><?php echo $this->overall['totalresume']; ?></span>
                    <span class="desc"><?php echo JText::_('Total Resumes'); ?></span>              
                </div>
                <div class="box">
                    <img src="components/com_jsjobs/include/images/company2.png" />
                    <span class="number"><?php echo $this->overall['totalcompany']; ?></span>
                    <span class="desc"><?php echo JText::_('Total Companies'); ?></span>                
                </div>
                <div class="box">
                    <img src="components/com_jsjobs/include/images/appliedresume2.png" />
                    <span class="number"><?php echo $this->overall['totalappliedresume']; ?></span>
                    <span class="desc"><?php echo JText::_('Total Applied Resume'); ?></span>
                </div>
            </div>
            <div class="categorycharts">
                <span class="title one">
                    <?php echo JText::_('By Categories'); ?>
                </span>
                <div class="chartwrap">
                    <span class="title"><?php echo JText::_('Jobs'); ?></span>
                    <div id="catbar1"></div>
                </div>
                <div class="chartwrap">
                    <span class="title"><?php echo JText::_('Resume'); ?></span>
                    <div id="catbar2"></div>
                </div>
                <div class="chartwrap">
                    <span class="title"><?php echo JText::_('Companies'); ?></span>
                    <div id="catpie"></div>
                </div>
            </div>
            <div class="categorycharts">
                <span class="title two">
                    <?php echo JText::_('By Cities'); ?>
                </span>
                <div class="chartwrap">
                    <span class="title"><?php echo JText::_('Jobs'); ?></span>
                    <div id="citybar1"></div>
                </div>
                <div class="chartwrap">
                    <span class="title"><?php echo JText::_('Companies'); ?></span>
                    <div id="citypie"></div>
                </div>
                <div class="chartwrap">
                    <span class="title"><?php echo JText::_('Resume'); ?></span>
                    <div id="citybar2"></div>
                </div>
            </div>
            <div class="categorycharts">
                <span class="title three">
                    <?php echo JText::_('By Types'); ?>
                </span>
                <div class="chartwrap type">
                    <span class="title"><?php echo JText::_('Jobs'); ?></span>
                    <div id="jobtypebar1"></div>
                </div>
                <div class="chartwrap type">
                    <span class="title"><?php echo JText::_('Resume'); ?></span>
                    <div id="jobtypebar2"></div>
                </div>
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
        data.addColumn('date', '<?php echo JText::_('Dates'); ?>');
        data.addColumn('number', '<?php echo JText::_('Jobs'); ?>');
        data.addColumn('number', '<?php echo JText::_('Resume'); ?>');
        data.addColumn('number', '<?php echo JText::_('Company'); ?>');
        data.addColumn('number', '<?php echo JText::_('Applied Resume'); ?>');
        data.addRows([
            <?php echo $this->overall['line_chart_json_array']; ?>
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

    google.setOnLoadCallback(drawChartCatBar1);
    function drawChartCatBar1(){
        var data = google.visualization.arrayToDataTable([
                    ['<?php echo JText::_('Categories'); ?>', '<?php echo JText::_('Jobs'); ?>', { role: 'style' }, { role: 'annotation' } ],
                    <?php echo $this->overall['catbar1']; ?>
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
        var chart = new google.visualization.BarChart(document.getElementById("catbar1"));
        chart.draw(view, options);
    }

    google.setOnLoadCallback(drawChartCatBar2);
    function drawChartCatBar2(){
        var data = google.visualization.arrayToDataTable([
                    ['<?php echo JText::_('Categories'); ?>', '<?php echo JText::_('Resume'); ?>', { role: 'style' }, { role: 'annotation' } ],
                    <?php echo $this->overall['catbar2']; ?>
                    ]);
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                           { calc: "stringify",
                             sourceColumn: 1,
                             type: "string",
                             role: "annotation" },
                           2]);

        var options = {title: "",width:'100%',height: 300,bar: {groupWidth: "80%"},legend: { position: "none" }};
        var chart = new google.visualization.ColumnChart(document.getElementById("catbar2"));
        chart.draw(view, options);
    }

    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var piedata = google.visualization.arrayToDataTable([
              ['<?php echo JText::_('Categories'); ?>', '<?php echo JText::_('Companies'); ?>'],
              <?php echo $this->overall['catpie']; ?>
        ]);
        var pieoptions = {title: '',width:'100%',height:300,legend: {position:"bottom"},pieHole: 0.4,};
        var piechart = new google.visualization.PieChart(document.getElementById('catpie'));
        piechart.draw(piedata, pieoptions);
    }

    google.setOnLoadCallback(drawChartCityBar1);
    function drawChartCityBar1(){
        var data = google.visualization.arrayToDataTable([
                    ['<?php echo JText::_('Cities'); ?>', '<?php echo JText::_('Jobs'); ?>', { role: 'style' }, { role: 'annotation' } ],
                    <?php echo $this->overall['citybar1']; ?>
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
        var chart = new google.visualization.BarChart(document.getElementById("citybar1"));
        chart.draw(view, options);
    }

    google.setOnLoadCallback(drawChartCityBar2);
    function drawChartCityBar2(){
        var data = google.visualization.arrayToDataTable([
                    ['<?php echo JText::_('Cities'); ?>', '<?php echo JText::_('Resume'); ?>', { role: 'style' }, { role: 'annotation' } ],
                    <?php echo $this->overall['citybar2']; ?>
                    ]);
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                           { calc: "stringify",
                             sourceColumn: 1,
                             type: "string",
                             role: "annotation" },
                           2]);

        var options = {title: "",width:'100%',height: 300,bar: {groupWidth: "80%"},legend: { position: "none" }};
        var chart = new google.visualization.ColumnChart(document.getElementById("citybar2"));
        chart.draw(view, options);
    }

    google.setOnLoadCallback(drawChartCity);
    function drawChartCity() {
        var piedata = google.visualization.arrayToDataTable([
              ['<?php echo JText::_('Cities'); ?>', '<?php echo JText::_('Companies'); ?>'],
              <?php echo $this->overall['citypie']; ?>
        ]);
        var pieoptions = {title: '',width:'100%',height:300,legend: {position:"bottom"},pieHole: 0.4,};
        var piechart = new google.visualization.PieChart(document.getElementById('citypie'));
        piechart.draw(piedata, pieoptions);
    }

    google.setOnLoadCallback(drawChartJobtypeBar1);
    function drawChartJobtypeBar1(){
        var data = google.visualization.arrayToDataTable([
                    ['<?php echo JText::_('Job Type'); ?>', '<?php echo JText::_('Jobs'); ?>', { role: 'style' }, { role: 'annotation' } ],
                    <?php echo $this->overall['jobtypebar1']; ?>
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
        var chart = new google.visualization.BarChart(document.getElementById("jobtypebar1"));
        chart.draw(view, options);
    }

    google.setOnLoadCallback(drawChartJobtypeBar2);
    function drawChartJobtypeBar2(){
        var data = google.visualization.arrayToDataTable([
                    ['<?php echo JText::_('Job Type'); ?>', '<?php echo JText::_('Resume'); ?>', { role: 'style' }, { role: 'annotation' } ],
                    <?php echo $this->overall['jobtypebar2']; ?>
                    ]);
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                           { calc: "stringify",
                             sourceColumn: 1,
                             type: "string",
                             role: "annotation" },
                           2]);

        var options = {title: "",width:'100%',height: 300,bar: {groupWidth: "80%"},legend: { position: "none" }};
        var chart = new google.visualization.ColumnChart(document.getElementById("jobtypebar2"));
        chart.draw(view, options);
    }

</script>
