<!--login popup-->
<div class="popup_wrap d_none" id="login_popup">
	<section class="popup r_corners shadow">
		<button class="bg_tr color_dark tr_all_hover text_cs_hover close f_size_large"><i class="fa fa-times"></i></button>
		<h3 class="m_bottom_20 color_dark">Log In</h3>
		<div id="loginMsg"></div>
		<form action="<?php echo site_url('login');?>" method="post" id="formLogin">
			<ul>
				<li class="m_bottom_15">
					<label for="username" class="m_bottom_5 d_inline_b">Email</label><br>
					<input type="text" name="email" id="email" class="r_corners full_width">
				</li>
				<li class="m_bottom_25">
					<label for="password" class="m_bottom_5 d_inline_b">Password</label><br>
					<input type="password" name="password" id="password" class="r_corners full_width">
				</li>
				<li class="m_bottom_15">
					<input type="checkbox" class="d_none" id="checkbox_10"><label for="checkbox_10">Ingat saya</label>
				</li>
				<li class="clearfix m_bottom_30">
					<button type="submit" class="button_type_4 tr_all_hover r_corners f_left bg_scheme_color color_light f_mxs_none m_mxs_bottom_15">Log In</button>
					<div class="f_right f_size_medium f_mxs_none">
						<a href="<?php echo site_url('pemulihan_password/lupa_password');?>" class="color_dark">Lupa password?</a><br>
						<a href="<?php echo site_url('pemulihan_password/lupa_email');?>" class="color_dark">Lupa email?</a>
					</div>
				</li>
			</ul>
		</form>
		<footer class="bg_light_color_1 t_mxs_align_c">
			<h3 class="color_dark d_inline_middle d_mxs_block m_mxs_bottom_15">Belum Mendaftar?</h3>
			<a href="<?php echo site_url('pendaftaran_akun');?>" role="button" class="tr_all_hover r_corners button_type_4 bg_dark_color bg_cs_hover color_light d_inline_middle m_mxs_left_0">Buat Akun</a>
		</footer>
	</section>
</div>