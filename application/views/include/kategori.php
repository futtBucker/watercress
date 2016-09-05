	<!--widgets-->
	<figure class="widget animate_ftr shadow r_corners wrapper m_bottom_30">
		<figcaption>
			<h3 class="color_light">Kategori</h3>
		</figcaption>
		<div class="widget_content">
			<!--Categories list-->
			<ul class="categories_list">
			<?php
			foreach($rs_kategori as $row)
			{
			?>
				<li class="active">
					<a href="#" class="f_size_large scheme_color d_block relative">
						<b><?php echo $row->kategori;?></b>
						<span class="bg_light_color_1 r_corners f_right color_dark talign_c"></span>
					</a>
					<?php
					$sql = "SELECT sub_kategori FROM sub_kategori_produk WHERE id_kategori = ".$row->id_kategori;
					$rs_sub_kategori = $this->model_auth->freequery($sql);
					if($rs_sub_kategori)
					{
					?>
					<!--second level-->
					<ul>
						<?php
						foreach($rs_sub_kategori as $sub_row)
						{
						?>
						<li class="active">
							<a href="#" class="d_block f_size_large color_dark relative">
								<?php echo $sub_row->sub_kategori;?>
							</a>
						</li>
						<?php
						}
						?>
					</ul>
					<?php
					}
					?>
				</li>
		<?php
		}
		?>
			</ul>
		</div>
	</figure>