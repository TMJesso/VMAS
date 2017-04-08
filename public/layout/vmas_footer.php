		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<p class="text-center">
			<a href="http://tool.motoricerca.info/robots-checker.phtml?checkreferer=1">
			<img src="http://tool.motoricerca.info/pic/valid-robots.png" border="0"
			alt="Valid Robots.txt" width="88" height="31"></a>
		</p>
		
		<br/>
		<div class="row">
			<div class="large-1 medium-1 small-1 columns">
				&nbsp;
			</div>
			<div class="large-10 medium-10 small-10 text-center columns">
				<div style="line-color: #008000;"><hr/></div>
					<footer title="Copyright &#169; <?php echo strftime("%Y", time()); ?> All Rights Reserved">
						<p>
							Copyright &copy; <?php echo strftime("%Y", time()); ?> VMAS All Rights Reserved
							<br/><br/>
							<span id="verNumber" class="version"></span><br/><br/>
							<!-- <a href="http://jigsaw.w3.org/css-validator/check/referer"> <img style="width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" />
							</a> -->
						</p>
					</footer>
			
			</div>
			<div class="large-1 medium-1 small-1 columns">
				&nbsp;
			</div>
		</div>
		<!-- JavaScript -->
		<script src="<?php echo JS_PATH . "vendor/jquery.js"; ?>"></script>
		<script src="<?php echo JS_PATH . "vendor/what-input.js"?>"></script>
		<script src="<?php echo JS_PATH . "vendor/foundation.js"?>"></script>
		<script src="<?php echo JS_PATH . "app.js"?>"></script>

		<script>
			$(document).foundation();
		</script>
		
	</body>
</html>
<?php if (isset($db)) { $db->close_connection(); } ?>
