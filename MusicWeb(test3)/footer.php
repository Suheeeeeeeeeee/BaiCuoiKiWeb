<div class="class_78" >
		<div class="class_79" >
			<a href="index.php"  class="class_80" >
				Home
			</a>
			<?php
				if(!is_logged_in()):
				?>
			<a href="login.php"  class="class_80" >
				Login
			</a>
			<a href="signup.php"  class="class_80" >
				Signup
			</a>
			<?php
			else:
			?>
			<a href="setting.php"  class="class_80" >
				Settings
			</a>
			<a href="profile.php"  class="class_80" >
				Profile
			</a>
			<?php
			endif
			?>
		</div>
		<div class="class_79" >
			<a href="top-20.php"  class="class_80" >
				Top20
			</a>
			<a href="popular.php"  class="class_80" >
				Popular
			</a>
			<a href="latest.php"  class="class_80" >
				Latest
			</a>
		</div>
		<div class="class_79" >
			<a href="terms.php"  class="class_80" >
				Terms &amp; Conditions
			</a>
			<a href="about-us.php"  class="class_80" >
				About us
			</a>
			<a href="contact-us.php"  class="class_80" >
				Contact us
			</a>
		</div>
	</div>
	</body>
</html>				