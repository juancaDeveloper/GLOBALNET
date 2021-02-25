<?php
/**
 * @package Sj Megamenu
 * @version 3.1.1
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;
$instance	= rand().time();
$menu_class_sfx = $params->get('moduleclass_sfx');
$menu_id = $menu_tag_id."_".$instance;
$detect = new Mobile_Detect();
$doc 	= JFactory::getDocument();
if ($params->get('bg_menu')) {
	$bg_menu = 'style="background-color: '.$params->get('bg_menu').'"';
}
else {
	$bg_menu = '';	
}
?>

<!--[if lt IE 9]><div id="<?php echo $menu_id; ?>" class="sambar msie lt-ie9 <?php echo $params->get('style_layout', 'layout1')?>" data-sam="<?php echo $instance; ?>"><![endif]-->
<!--[if IE 9]><div id="<?php echo $menu_id; ?>" class="sambar msie  <?php echo $params->get('style_layout', 'layout1')?>" data-sam="<?php echo $instance; ?>"><![endif]-->
<!--[if gt IE 9]><!--><div id="<?php echo $menu_id; ?>" class="sambar <?php echo $params->get('style_layout', 'layout1')?>" data-sam="<?php echo $instance; ?>"><!--<![endif]-->
	<div class="sambar-inner menu_<?php echo $params->get('megamenutype', 'horizontal')?>">
		<a class="btn-sambar" id="<?php echo $menu_id?>trigger" data-sapi="collapse" href="javascript:void(0)">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		<?php if ($params->get('show_heading_title', 1) && $params->get('heading_title') != '') {?>
		<h3 class="title-mod">
			<i class="fa fa-align-left" aria-hidden="true"></i>
			<?php echo $params->get('heading_title')?>
		</h3>
		<?php }?>
		<?php
			$class = '';
			if ($params->get('css_style', 1)) {
				$class .= ' '.$params->get('sub_animation', '');
			}
		?>
		<div <?php echo $bg_menu?> class="sj-megamenu <?php echo $class?> <?php echo $params->get('mobilemenutype')?> <?php echo $menu_class_sfx; ?> <?php if( $params->get('menu_event') == 'hover' ){if ( !$detect->isMobile() && !$detect->isTablet() ) { echo "sj-megamenu-hover";}}?>" data-jsapi="on">
			<?php echo $megamenu;?>
		</div>
		<div class="offcanvas-menu menu_<?php echo $params->get('mobilemenutype', 'sidebar')?>" id="<?php echo $menu_id?>sj-pusher">
			<a href="#" class="close-offcanvas"><i class="fa fa-remove"></i></a>
			<div class="offcanvas-inner">
				<?php require JModuleHelper::getLayoutPath('mod_sj_megamenu_res', 'default_mobile');?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		<?php if ($params->get('megamenutype') == 'vertical') {?>
			$('#<?php echo $menu_id; ?> .menu_vertical .sj-megamenu-vertical .sj-dropdown.sj-menu-left').each(function(){
				$(this).css('top', '0px');	
				$(this).css('right', 'auto');	
				$(this).css('left', '-'+$(this).outerWidth()+'px');
			});
			$('#<?php echo $menu_id; ?> .menu_vertical .sj-megamenu-vertical .sj-dropdown.sj-menu-right').each(function() {
				$(this).css('top', '0px');
				$(this).css('left', 'auto');
				$(this).css('right', '-'+$(this).outerWidth()+'px');
			});
		<?php }?>

	})
</script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		<?php if ($params->get('mobilemenutype') !== 'dropdown') {?>
	    	$('<div class="offcanvas-overlay"></div>').insertBefore('#<?php echo $menu_id?> .offcanvas-menu');
	    <?php }?>
		$(document).on('click', '#<?php echo $menu_id?> a.btn-sambar', function (event) {
			if ($(this).parent('.sambar-inner').hasClass('offcanvas')) {
				$(this).parent('.sambar-inner').removeClass('offcanvas');
			}
			else {
				$(this).parent('.sambar-inner').removeClass('offcanvas').addClass('offcanvas');
			}

			if ($('body').hasClass('js-close-any')) {
				$('body').removeClass('js-close-any')
				$(this).parent('.sambar-inner').find('.offcanvas-overlay').removeClass('opened');
			}
			else {
				$('body').removeClass('js-close-any').addClass('js-close-any');
				$(this).parent('.sambar-inner').find('.offcanvas-overlay').removeClass('opened').addClass('opened');
			}
	    });

		$(document).on('click', '.close-offcanvas, .offcanvas-overlay', function(event) {
            event.preventDefault();
            $('.sambar-inner').removeClass('offcanvas');
            $('body').removeClass('offcanvas');
            $('.offcanvas-overlay').removeClass('opened');            
        });

		// Close any
		$( document ).on( 'click', '.js-close-any', function ( event ) {
			$('.btn-sambar').removeClass('open');
			$('body').removeClass('js-close-any');
			$('body').removeClass('offcanvas');
			$('.sambar-inner').removeClass('offcanvas');
			$('.offcanvas-overlay').removeClass('opened');			
		})

		<?php if ($params->get('mobilemenutype') == 'dropdown') {?>
			$('ul.nav li.parent .touch-button').on('click', function(e) {
	        	if ($(this).hasClass('opened')) {
	        		$(this).removeClass('opened');
	        	}
	        	else {
	        		$(this).removeClass('opened').addClass('opened');
	        	}
	        	$sub = $(this).parent('li.parent').find('>ul');
	        	if ($sub.hasClass('flexnav-show') === true) {
	        		$sub.removeClass('flexnav-show').slideUp(250);
	        	}
	        	else {
	        		$sub.addClass('flexnav-show').slideDown(250);
	        	}

	        	return false;
	        })
	    <?php }?>

	    <?php if ($params->get('mobilemenutype') == 'push') {?>
	    	;( function( window ) {
	
				'use strict';

				function extend( a, b ) {
					for( var key in b ) { 
						if( b.hasOwnProperty( key ) ) {
							a[key] = b[key];
						}
					}
					return a;
				}

				// taken from https://github.com/inuyaksa/jquery.nicescroll/blob/master/jquery.nicescroll.js
				function hasParent( e, id ) {
					if (!e) return false;
					var el = e.target||e.srcElement||e||false;
					while (el && el.id != id) {
						el = el.parentNode||false;
					}
					return (el!==false);
				}

				// returns the depth of the element "e" relative to element with id=id
				// for this calculation only parents with classname = waypoint are considered
				function getLevelDepth( e, id, waypoint, cnt ) {
					cnt = cnt || 0;
					if ( e.id.indexOf( id ) >= 0 ) return cnt;
					if( classie.has( e, waypoint ) ) {
						++cnt;
					}
					return e.parentNode && getLevelDepth( e.parentNode, id, waypoint, cnt );
				}

				// http://coveroverflow.com/a/11381730/989439
				function mobilecheck() {
					var check = false;
					(function(a){if(/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
					return check;
				}

				// returns the closest element to 'e' that has class "classname"
				function closest( e, classname ) {
					if( classie.has( e, classname ) ) {
						return e;
					}
					return e.parentNode && closest( e.parentNode, classname );
				}

				function mlPushMenu( el, trigger, options ) {
					this.el = el;
					this.trigger = trigger;
					this.options = extend( this.defaults, options );
					// support 3d transforms
					this.support = Modernizr.csstransforms3d;
					if( this.support ) {
						this._init();
					}
				}

				mlPushMenu.prototype = {
					defaults : {
						// overlap: there will be a gap between open levels
						// cover: the open levels will be on top of any previous open level
						type : 'overlap', // overlap || cover
						// space between each overlaped level
						levelSpacing : 40,
						// classname for the element (if any) that when clicked closes the current level
						backClass : 'sj-back'
					},
					_init : function() {
						// if menu is open or not
						this.open = false;
						// level depth
						this.level = 0;
						// the moving wrapper
						this.wrapper = document.getElementById( '<?php echo $menu_id?>sj-pusher' );
						// the sj-level elements
						this.levels = Array.prototype.slice.call( this.el.querySelectorAll( 'div.sj-level' ) );
						// save the depth of each of these sj-level elements
						var self = this;
						this.levels.forEach( function( el, i ) { el.setAttribute( 'data-level', getLevelDepth( el, self.el.id, 'sj-level' ) ); } );
						// the menu items
						this.menuItems = Array.prototype.slice.call( this.el.querySelectorAll( 'li' ) );
						// if type == "cover" these will serve as hooks to move back to the previous level
						this.levelBack = Array.prototype.slice.call( this.el.querySelectorAll( '.' + this.options.backClass ) );
						// event type (if mobile use touch events)
						this.eventtype = mobilecheck() ? 'touchstart' : 'click';
						// add the class sj-overlap or sj-cover to the main element depending on options.type
						classie.add( this.el, 'sj-' + this.options.type );
						
						// initialize / bind the necessary events
						this._initEvents();
					},
					_initEvents : function() {
						
						var self = this;

						// the menu should close if clicking somewhere on the body
						var bodyClickFn = function( el ) {
							self._resetMenu();
							el.removeEventListener( self.eventtype, bodyClickFn );
						};

						// open (or close) the menu
						this.trigger.addEventListener( this.eventtype, function( ev ) {
							ev.stopPropagation();
							ev.preventDefault();
							if( self.open ) {
								self._resetMenu();
							}
							else {
								self._openMenu();
								// the menu should close if clicking somewhere on the body (excluding clicks on the menu)
								document.addEventListener( self.eventtype, function( ev ) {
									if( self.open && !hasParent( ev.target, self.el.id ) ) {
										bodyClickFn( this );
									}
								} );
							}
						} );

						// opening a sub level menu
						this.menuItems.forEach( function( el, i ) {
							// check if it has a sub level
							var subLevel = el.querySelector( 'div.sj-level' );
							if( subLevel ) {
								el.querySelector( 'a' ).addEventListener( self.eventtype, function( ev ) {
									ev.preventDefault();
									var level = closest( el, 'sj-level' ).getAttribute( 'data-level' );
									if( self.level <= level ) {
										ev.stopPropagation();
										classie.add( closest( el, 'sj-level' ), 'sj-level-overlay' );
										self._openMenu( subLevel );
									}
								} );
							}
						} );

						// closing the sub levels :
						// by clicking on the visible part of the level element
						this.levels.forEach( function( el, i ) {
							el.addEventListener( self.eventtype, function( ev ) {
								ev.stopPropagation();
								var level = el.getAttribute( 'data-level' );
								if( self.level > level ) {
									self.level = level;
									self._closeMenu();
								}
							} );
						} );

						// by clicking on a specific element
						this.levelBack.forEach( function( el, i ) {
							el.addEventListener( self.eventtype, function( ev ) {
								ev.preventDefault();
								var level = closest( el, 'sj-level' ).getAttribute( 'data-level' );
								if( self.level <= level ) {
									ev.stopPropagation();
									self.level = closest( el, 'sj-level' ).getAttribute( 'data-level' ) - 1;
									self.level === 0 ? self._resetMenu() : self._closeMenu();
								}
							} );
						} );	
					},
					_openMenu : function( subLevel ) {
						// increment level depth
						++this.level;
						
						// move the main wrapper
						var levelFactor = ( this.level - 1 ) * this.options.levelSpacing,
							translateVal = this.options.type === 'overlap' ? this.el.offsetWidth + levelFactor : this.el.offsetWidth;
						
						this._setTransform( 'translate3d(' + translateVal + 'px,0,0)' );

						if( subLevel ) {
							// reset transform for sublevel
							this._setTransform( '', subLevel );
							// need to reset the translate value for the level menus that have the same level depth and are not open
							for( var i = 0, len = this.levels.length; i < len; ++i ) {
								var levelEl = this.levels[i];
								if( levelEl != subLevel && !classie.has( levelEl, 'sj-level-open' ) ) {
									this._setTransform( 'translate3d(-100%,0,0) translate3d(' + -1*levelFactor + 'px,0,0)', levelEl );
								}
							}				
						}
						// add class sj-pushed to main wrapper if opening the first time
						if( this.level === 1 ) {
							classie.add( this.wrapper, 'sj-pushed' );
							this.open = true;
						}
						// add class sj-level-open to the opening level element
						classie.add( subLevel || this.levels[0], 'sj-level-open' );
					},
					// close the menu
					_resetMenu : function() {
						this._setTransform('translate3d(0,0,0)');
						this.level = 0;
						// remove class sj-pushed from main wrapper
						classie.remove( this.wrapper, 'sj-pushed' );
						this._toggleLevels();
						this.open = false;
					},
					// close sub menus
					_closeMenu : function() {
						var translateVal = this.options.type === 'overlap' ? this.el.offsetWidth + ( this.level - 1 ) * this.options.levelSpacing : this.el.offsetWidth;
						this._setTransform( 'translate3d(' + translateVal + 'px,0,0)' );
						this._toggleLevels();
					},
					// translate the el
					_setTransform : function( val, el ) {
						el = el || this.wrapper;
						el.style.WebkitTransform = val;
						el.style.MozTransform = val;
						el.style.transform = val;
					},
					// removes classes sj-level-open from closing levels
					_toggleLevels : function() {
						for( var i = 0, len = this.levels.length; i < len; ++i ) {
							var levelEl = this.levels[i];
							if( levelEl.getAttribute( 'data-level' ) >= this.level + 1 ) {
								classie.remove( levelEl, 'sj-level-open' );
								classie.remove( levelEl, 'sj-level-overlay' );
							}
							else if( Number( levelEl.getAttribute( 'data-level' ) ) == this.level ) {
								classie.remove( levelEl, 'sj-level-overlay' );
							}
						}
					}
				}

				// add to global namespace
				window.mlPushMenu = mlPushMenu;

			} )( window );

	    	new mlPushMenu( document.getElementById( '<?php echo $menu_id?>sj-pusher' ), document.getElementById( '<?php echo $menu_id?>trigger' ), {
				type : 'cover'
			});
		<?php }?>
    });
</script>

<?php if( $params->get('css_style') == 0 ){?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			var window_w = $(window).width();
			$('#<?php echo $menu_id; ?> .sj-megamenu').each(function() {
				var $menu = $(this);
				var clearMenus = function( el ){
					var parents = $(el).parents();
					$menu.find('.actived').not(parents).not(el).each( function(){
						$(this).removeClass('actived');
						$(this).children('.sj-dropdown').slideUp(0);
					});
				};
				<?php if( $params->get('menu_event') == 'click' ){?>
					$('.sj-menu-item > a', $menu).click( function(e){
						e.preventDefault();
						$parent = $(this).parent();						
						$sub = $(this).next();						
						clearMenus($parent);
						$parent.toggleClass('actived');
						
						if($parent.hasClass('actived')){
							$sub.stop().animate( { height: "show", "opacity" : "1" }, <?php echo $params->get('moofxtimeout', '1500')?>, '<?php echo $params->get("moofx", "easeInOutCirc")?>' );
						}else{
							$sub.stop().animate( { height: "hide", "opacity" : "0" }, 500, 'easeInQuad' );
						}
						
						if ($parent.find('li.sj-menu-item').length > 0)
							return false;
						else
							window.location.href = $(this).attr('href');
					});
				<?php }else {?>
					if(window_w <= 980) {
						$('.sj-menu-item > a', $menu).click( function(e){
							e.preventDefault();
							$parent = $(this).parent();						
							$sub = $(this).next();						
							clearMenus($parent);
							$parent.toggleClass('actived');
							
							if($parent.hasClass('actived')){
								$sub.stop().animate( { height: "show", "opacity" : "1" }, <?php echo $params->get('moofxtimeout', '1500')?>, '<?php echo $params->get("moofx", "easeInOutCirc")?>' );
							}else{
								$sub.stop().animate( { height: "hide", "opacity" : "0" }, <?php echo $params->get('moofxtimeout', '1500')?>, '<?php echo $params->get("moofx", "easeInOutCirc")?>' );
							}
							
							if ($parent.find('li.sj-menu-item').length > 0)
								return false;
							else
								window.location.href = $(this).attr('href');
						});
					}
					else {
						$( '.sj-menu-item', $menu ).hover(function(){
							$parent = $(this);
							$sub = $(this).children('.sj-dropdown');
							$parent.removeClass('actived').addClass('actived');
							if( $parent.hasClass('actived') && !$(this).hasClass('mega-pinned') ){
								$sub.stop().animate( { height: "show", "opacity" : "1" }, <?php echo $params->get('moofxtimeout', '1000')?>, '<?php echo $params->get("moofx", "easeInOutCirc")?>' );
							}
						}).mouseleave(function(){
							$parent = $(this);
							$sub = $(this).children('.sj-dropdown');
							$(this).removeClass('actived');
							if( !$(this).hasClass('mega-pinned') ){
								$sub.stop().animate( { height: "hide", "opacity" : "0" }, <?php echo $params->get('moofxtimeout', '1000')?>, '<?php echo $params->get("moofx", "easeInOutCirc")?>' );
							}
						});
						return false;
					}
				<?php }?>
			})
		})
	</script>
<?php }?>