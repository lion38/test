<?php if(!defined("BASE_DS")) die(); ?>
					</div>
					<div class="clear-float"></div>
				</div>
			</section>
		<!-- END #top-layer -->
		</div>
			
		<div class="clear-float"></div>
		
		<div class="wrapper">
			<!-- BEGIN .footer -->
			<div class="footer">

				<div class="footer-top"></div>
				
				<div class="footer-content">

				</div>

				<div class="footer-bottom">
					<div class="left">&copy; Copyright 2018-2019 <strong style="color:white;">Neft-Gaming</strong></div>
					<div class="right">
						<ul>
							<li><a href="index.php">Accueil</a></li>
							<li><a href="#" id="gototopfooter">Retour en haut</a></li>
						</ul>
					</div>
					<div class="clear-float"></div>
				</div>
				
			<!-- END .footer -->
			</div>
		</div>
		<link rel='stylesheet' href='wp-content/datatables/jTPS.css' type='text/css' media='all' />
		<script type='text/javascript' src='wp-content/datatables/jTPS.js'></script>
		<script type='text/javascript' src='jscript/modernizr.custom.50878.js'></script>
		<script type='text/javascript' src='jscript/iscroll.js'></script>
		<script type='text/javascript' src='jscript/dat-menu.js'></script>
		<script type='text/javascript'>
			var strike_featCount = 4;
			var strike_autostart = true;
			var strike_autoTime = 7000;
		</script>
		<script type='text/javascript' src='wp-content/themes/iconiac/js/tooltips.js'></script>
		<script type='text/javascript' src='jscript/tipsy.js'></script>
		<script type='text/javascript' src='wp-content/themes/iconiac/js/jquery.pause.min.js'></script>
		<script type='text/javascript' src='jscript/theme-script.js'></script>
		
		<script type="text/javascript">
		$(document).load($(window).bind("resize", listenWidth));
		var widthBGo = 0;// -1 = phone | 0 = a initialiser | 1 = normal desktop
		
		var breakingPixelToSwitchWith = 750;
		function listenWidth( e )
		{
			var actualWidth = $(window).width();
			
			if(widthBGo == 0)
			{
				if(actualWidth <= breakingPixelToSwitchWith)
				{
					$("#main-box #sidebar").remove().insertAfter($("#main-box #main"));
					widthBGo = -1;
				}
				else
				{
					$("#main-box #sidebar").remove().insertBefore($("#main-box #main"));
					widthBGo = 1;
				}
			}
			else
			{
				if(actualWidth <= breakingPixelToSwitchWith && widthBGo > -1)
				{
					$("#main-box #sidebar").remove().insertAfter($("#main-box #main"));
					widthBGo = -1;
				}
				else if(actualWidth > breakingPixelToSwitchWith && widthBGo < 1)
				{
					$("#main-box #sidebar").remove().insertBefore($("#main-box #main"));
					widthBGo = 1;
				}
			}
		}
		listenWidth(); // For initial without changing the width browser
		  
		$('#gototopfooter').click(function(){$('html').animate({scrollTop:0},'slow');$('body').animate({scrollTop:0},'slow');});

		</script>
</div>
</body>
</html>