
	function setTabsWidth(rows, mod_prefix){
		
		if(isIEx() && isIEx()<=8)
			return;
		
		if (!mod_prefix)
			mod_prefix = '';
			
		if (!rows)
			rows = 1;
		
		var tab = document.id(mod_prefix+'djtab1');
		var tabs = document.id(mod_prefix+'djtabs');
		var titlesArray = $$('.'+mod_prefix+'djtabs_help_class');
		var t_count = titlesArray.length;
	
	
		if (tab && window.innerWidth > 480 && t_count > rows)
		{
		
		
			var margins = parseInt(tab.getStyle('margin-left')) + parseInt(tab.getStyle('margin-right'));
			var paddings = parseInt(tab.getStyle('padding-left')) + parseInt(tab.getStyle('padding-right'));
			var borders = parseInt(tab.getStyle('border-left')) + parseInt(tab.getStyle('border-right'));
			var offset = margins + paddings + borders;
			
			
			var tabsSummedWidth = 0;
			
			for (k=0; k < t_count; k++)
			{
					tabsSummedWidth = tabsSummedWidth + parseInt(titlesArray[k].getStyle('width'));		
			}
			
			tabsSummedWidth = tabsSummedWidth + (offset * t_count);
		
			
			var available_space = 
				parseInt(tabs.getStyle('width')) + 
				parseInt(tabs.getStyle('padding-left')) + 
				parseInt(tabs.getStyle('padding-right'))
				- 2;
				
		
			if (tabsSummedWidth > available_space)
			{
				
				r = t_count % rows;
				l = parseInt(t_count / rows);
		
				var rows_array = new Array();
				
				for (i=0; i < rows; i++)
				{
					rows_array.push(l);
				}
				
				for (i=0; i < r; i++)
				{
					rows_array[i] = rows_array[i] + 1;
				}
				
				var rows_array_copy = rows_array.slice(0);
	
				var row_t_count;
				var tabNewWidth;
				var tab_class;
				
		  		for (i=0; i < t_count; i++)
				{	
					for (j=0; j < rows; j++)
					{
						if (rows_array_copy[j]>0){
							row_t_count = rows_array[j];
							rows_array_copy[j] = rows_array_copy[j] - 1;
							
							if(j==0)
								tab_class = 'first-row';
							else if(j==rows-1)
								tab_class = 'last-row';
							else
								tab_class = 'n-row';
							
							break;
						}
							
					}
	
					tabNewWidth = parseInt(((available_space - (row_t_count * offset)) / row_t_count) - 1);
					
					var n_tab = document.id(mod_prefix+'djtab'+(i+1));
					
					n_tab.addClass(tab_class);
					n_tab.removeClass('tabsBlock');
					n_tab.style.width=tabNewWidth+'px';
					document.id(mod_prefix+'djtabs_title_img_right'+(i+1)).setStyle('left',tabNewWidth + paddings - 2);	
				}
				
			if(rows>1)
				document.id(mod_prefix+'djtabs').addClass('rows');
				
			}
		
		}
		else if (tab && (window.innerWidth <= 480 || t_count <= rows)){
			for (i=1; i<=t_count; i++)
			{
				document.id(mod_prefix+'djtab'+i).addClass('tabsBlock');
			}
		}
	
	}
	
	 
	function resetTabsWidth(mod_prefix){
		if(isIEx() && isIEx()<=8)
			return;

		if (!mod_prefix)
			mod_prefix = '';
		
	 		var tab = document.id(mod_prefix+'djtab1');
	 	  	if (tab)
	  		{
	  			var titlesArray = $$('.'+mod_prefix+'djtabs_help_class');
	  			var paddings = parseInt(tab.getStyle('padding-left')) + parseInt(tab.getStyle('padding-right'));

	  				var tabWidth;
	  				for (l=1; l<=titlesArray.length; l++) //reseting width
					{	
						document.id(mod_prefix+'djtab'+l).removeClass('tabsBlock');
						tabWidth = document.id(mod_prefix+'djtab'+l).getStyle('width');
						document.id(mod_prefix+'djtab'+l).removeAttribute('style');
						document.id(mod_prefix+'djtabs_title_img_right'+(l)).setStyle('left',tabWidth + paddings - 2);	
					}
	  		}
	}
	 
	
	function setPanelsText(mod_prefix){
		if(isIEx() && isIEx()<=8)
			return;
	
		if (!mod_prefix)
			mod_prefix = '';
				
		var panelArray = $$('#'+mod_prefix+'djtabs .djtabs-panel');

		for (var j=0; j<panelArray.length; j++){
				
			var panelWidth = parseInt(panelArray[j].getStyle('width')); //panel width

			var spanTitle = null; 
			var spanDate = null; 
			var spanDateWidth = 0;
			var spanTogglerWidth = 0;
			var spanTitleMargins = 0;
			var spanTitleWidth = 0;
			for (var i = 0; i < panelArray[j].children.length; i++){
				if (panelArray[j].children[i].className == "djtabs-panel-title"){
					spanTitle = panelArray[j].children[i];
					spanTitleWidth = getFullWidth(panelArray[j].children[i]);
					spanTitleMargins = getMargins(panelArray[j].children[i]);
			    }
			    else if (panelArray[j].children[i].className == "djtabs-panel-date"){
					spanDate = panelArray[j].children[i];
					spanDateWidth = getFullWidth(panelArray[j].children[i]);
			    }
			    else if (panelArray[j].children[i].className == "djtabs-panel-toggler"){
					spanTogglerWidth = getFullWidth(panelArray[j].children[i]);
			    }      
			}
			
			if(spanTitle){
				if(panelWidth < spanTitleWidth+spanDateWidth+spanTogglerWidth)
					spanTitle.setStyle('width',panelWidth-spanDateWidth-spanTogglerWidth-spanTitleMargins);
			}			
			
		}
	}
	
	
	function resetPanelsText(mod_prefix){
		if(isIEx() && isIEx()<=8)
			return;
	
		if (!mod_prefix)
			mod_prefix = '';
				
		var panelArray = $$('#'+mod_prefix+'djtabs .djtabs-panel-title');

		for (var j=0; j<panelArray.length; j++){			
			panelArray[j].removeAttribute('style');
		}
	}
	
	
	function getFullWidth(el){	
		return el ? el.offsetWidth + getMargins(el) : 0;	
	}

	function getMargins(el){
		return el ? parseInt(el.getStyle('margin-left')) + parseInt(el.getStyle('margin-right')) : 0;
	}
	
	function isIEx() {
		var myNav = navigator.userAgent.toLowerCase();
		return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
	}
	

	function toggleVideo(el, task, ie_fix){
		
		if(isIEx() && isIEx()<=8){
			return;
		}
		
		if(ie_fix){
			var UAString = navigator.userAgent;
			if(UAString.indexOf("Windows NT 10.0") !== -1 && UAString.indexOf("Trident") !== -1 && UAString.indexOf("rv:11") !== -1){
				return;
			} //ie<=8 / ie11(win10) Fix
		}
		
		var post_msg;
		var iframe;
		var djVideoWrapper = el.getElementsByClassName("djVideoWrapper")[0];
		
		if (djVideoWrapper){
			
			iframe = djVideoWrapper.getElementsByTagName("iframe")[0];
			
			if (iframe){
				
				if(iframe.src.contains('vimeo'))
					post_msg = task ? '"method":"play"' : '"method":"pause"';
				else if(iframe.src.contains('youtube'))
					post_msg = task ? '"func":"playVideo"' : '"func":"pauseVideo"';

				if(post_msg)
					iframe.contentWindow.postMessage('{"event":"command",'+post_msg+'}', '*');
			}
		}
	}
	
	// wcag
	var last_key_pressed = '';
	window.addEvent('keydown', function(event){
		last_key_pressed = event.key;
	});
	$$('.djtabs-title').addEvent('click', function(event){
		last_key_pressed = '';
	});
	
  	window.addEvent('domready', function(){
  		if(!DJTabsWCAG){
  			return;
  		}
  		
		$$('.djtabs-title').addEvent('focus', function() {
			if($(this).hasClass('djtabs-active')){
				return; // 1.3.1 fix - don't process if already have focus
			}
			if(last_key_pressed!='tab' && last_key_pressed!='left' && last_key_pressed!='right'){
  				return; // 1.3.6 fix - don't processed if normal click
			}
			
			var tab_no = $(this).getProperty('data-tab-no');
			var focus_el;
			var main_wrapper = $(this).getParent().getParent().getParent();

			if(tab_no){
		    	focus_el = main_wrapper.getElements('.djtabs-body[data-tab-no="'+tab_no+'"]');
		    	if(focus_el.length){
		    		focus_el[0].focus();
		    	}
			}
		});
		$$('.djtabs-body').addEvent('focus', function() {
			var tab_no = $(this).getProperty('data-tab-no');
			tab_no = tab_no ? tab_no - 1 : 'undefined';
			
			if(tab_no != 'undefined'){
				var main_accordion = $(this).getParent().getParent().getParent();
				if(main_accordion.id){
					if(!main_accordion.getElements('.djtabs-title[data-tab-no="'+(parseInt(tab_no)+1)+'"]')[0].hasClass('djtabs-active')){
						window[main_accordion.id].display(tab_no);
						window[main_accordion.id].options.link = 'ignore';
					}
				}
			}
			
		});
		$$('.djtabs-body').addEvent('keydown', function(event){
			
			//last_key_pressed = event.key;
			
			var tab_no = $(this).getProperty('data-tab-no');
			var focus_el;
			var main_accordion = $(this).getParent().getParent().getParent();
			
			//var isAccordion = $(this).getParent().getParent().getParent().hasClass('accordion');
			//var prevKey = isAccordion ? 'up' : 'left';
			//var nextKey = isAccordion ? 'down' : 'right';
			
			var prevKey = 'left';
			var nextKey = 'right';
			
			if(tab_no){
				if(event.key == prevKey){
			    	focus_el = main_accordion.getElements('.djtabs-body[data-tab-no="'+(parseInt(tab_no)-1)+'"]');
			    	if(focus_el.length){
			    		focus_el[0].focus();
			    	}
			    }else if(event.key == nextKey){
			    	focus_el = main_accordion.getElements('.djtabs-body[data-tab-no="'+(parseInt(tab_no)+1)+'"]');
			    	if(focus_el.length){
			    		focus_el[0].focus();
			    	}
			    }
		    }
		});
		
		
		$$('.djtabs-article-group').addEvent('focus', function(event) {

			var inner_accordion = $(this).getParent().id;

			if(inner_accordion){
				var inner_accordion_body = $(this).getChildren('.djtabs-article-body');
				if(inner_accordion_body.length){
					var inner_accordion_item_no = inner_accordion_body.getProperty('data-no');
					inner_accordion_item_no = inner_accordion_item_no ? inner_accordion_item_no - 1 : 'undefined';
					if(inner_accordion_item_no != 'undefined'){
						if(!$(this).hasClass('djtabs-group-active') && $(this).getParent().hasClass('accordion_help_class')){
							window[inner_accordion].display(inner_accordion_item_no);
							window[inner_accordion].options.link = 'ignore';
						}
					}
				}
			}
		});
		$$('.djtabs-article-group').addEvent('keydown', function(event) {
			
			if(event.key == 'up' || event.key == 'down'){
				
				var inner_accordion = $(this).getParent().id;
				var focus_el;
				
				if(inner_accordion){
					var inner_accordion_body = $(this).getChildren('.djtabs-article-body');
					if(inner_accordion_body.length){
						var inner_accordion_item_no = inner_accordion_body.getProperty('data-no');
						inner_accordion_item_no = inner_accordion_item_no || inner_accordion_item_no == '0' ? inner_accordion_item_no : 'undefined';
						if(inner_accordion_item_no != 'undefined'){
							if(event.key == 'up'){
						    	focus_el = $(this).getParent().getChildren('.djtabs-article-group .djtabs-article-body[data-no="'+(parseInt(inner_accordion_item_no)-1)+'"]').getParent();
						    	if(focus_el.length){
						    		event.preventDefault();
									focus_el[0].focus();
						    	}
						    }else if(event.key == 'down'){
						    	focus_el = $(this).getParent().getChildren('.djtabs-article-group .djtabs-article-body[data-no="'+(parseInt(inner_accordion_item_no)+1)+'"]').getParent();
						    	if(focus_el.length){
						    		event.preventDefault();
									focus_el[0].focus();
						    	}
						    }
						}
					}
				}
			}
		});
	});
