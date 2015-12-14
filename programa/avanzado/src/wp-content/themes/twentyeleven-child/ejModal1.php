		<style>
		/* Z-index of #mask must lower than #boxes .window */
		#mask {
			position:absolute;
			z-index:900;
			background-color:#000;
			display:none;
		}
			 
		#box-modal .window-modal {
			position:fixed;
			width:440px;
			height:200px;
			display:none;
			z-index:999;
			padding:20px;
		}
		 
		 
		/* Customize your modal window here, you can add background image too */
		#boxes #dialog {
			width:375px; 
			height:203px;
		}
		</style>
		<div id="box-modal" class="window-modal">
			<div id="modal-tapiz"></div>
			<!-- Do not remove div#mask, because you'll need it to fill the whole screen --> 
			<div id="mask"></div>
		</div>
		<script>
		$DDP(document).ready(function() {  
		 
				//select all the a tag with name equal to modal
				$DDP('#verModal').click(function(e) {
						//Cancel the link behavior
						e.preventDefault();
						//Get the A tag
						//var id = $(this).attr('href');
				 
						//Get the screen height and width
						var maskHeight = $DDP(document).height();
						var maskWidth = $DDP(window).width();
				 
						//Set height and width to mask to fill up the whole screen
						$DDP('#mask').css({'width':maskWidth,'height':maskHeight});
						 
						//transition effect     
						$DDP('#mask').fadeIn(1000);    
						$DDP('#mask').fadeTo("slow",0.8);  
				 
						//Get the window height and width
						var winH = $DDP(window).height();
						var winW = $DDP(window).width();
									 
						//Set the popup window to center
						//$(id).css('top',  winH/2-$(id).height()/2);
						//$(id).css('left', winW/2-$(id).width()/2);
				 
						//transition effect
						//$(id).fadeIn(2000); 
				 
				});
				 
				//if close button is clicked
				$DDP('.window-modal .close').click(function (e) {
						//Cancel the link behavior
						e.preventDefault();
						$DDP('#mask, .window-modal').hide();
				});     
				 
				//if mask is clicked
				$DDP('#mask').click(function () {
						$DDP(this).hide();
						$DDP('.window-modal').hide();
				});      

				$DDP(document).ready(function () {
					$DDP(window).resize(function () {
						
									var box = $DDP('#boxes-modal .window-modal');
						
									//Get the screen height and width
									var maskHeight = $DDP(document).height();
									var maskWidth = $DDP(window).width();
								 
									//Set height and width to mask to fill up the whole screen
									$DDP('#mask').css({'width':maskWidth,'height':maskHeight});
													
									//Get the window height and width
									var winH = $DDP(window).height();
									var winW = $DDP(window).width();
						
									//Set the popup window to center
									box.css('top',  winH/2 - box.height()/2);
									box.css('left', winW/2 - box.width()/2);
						
					});
				 
				});				
				 
		});
		 
		</script>
		<input type="button" id="verModal" value="ver" >