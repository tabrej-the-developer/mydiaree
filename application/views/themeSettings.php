<?php

	$data['name']='Theme Settings'; 
	$this->load->view('header',$data);
?>
<style>
	.settingsView form {
		flex-direction: column;
	}
	.main-theme-container {
		display: flex;
		align-items: center;
		justify-items: flex-start;
		width: 100%;
		flex-wrap: wrap;
	}
	.main-theme-container .theme-block {
		margin-left: 30px;
		margin-bottom: 30px;
		flex: 0 0 calc(20% - 25px);
	}
	.main-theme-container .theme-block:first-child {
		margin-left: 0;
	}
	.main-theme-container .theme-block:nth-child(5n+1) {
		margin-left: 0;
	}
	.flexNameTheme {
		display: flex;
		align-items: center;
		justify-content: space-between;
	}
	.main-theme-container .theme-block label img {
		border: 2px solid var(--grey5);
		border-radius: 5px;
		-o-border-radius: 5px;
		-webkit-border-radius: 5px;
		width: 100%;
	}
	.main-theme-container .theme-block input:checked + label img {
		border: 2px solid var(--blue2);
	}
	.button-area{
		display: inline-block;
		text-align: right;
		width: 100%;
	}
</style>
<div class="container settingsContainer">
    <div class="pageHead">
		<h1>Settings</h1>
    </div>
	<div class="settingsView">
		<div class="sideMenu">
			<?php $this->load->view('settings-menu-sidebar'); ?>
		</div>
		<div class="rightFOrmSection">
			<h3><?php echo $data['name']; ?></h3>
			<form action="<?= base_url("Settings/saveThemeSettings"); ?>" method="post">
				<div class="main-theme-container">
					<?php foreach ($themeList as $key => $theme) { ?>
					<div class="theme-block">
						<label for="theme<?= $theme->id; ?>">
							<div class="flexNameTheme">
								<input 
								id="theme<?= $theme->id; ?>" 
								class="tweakcss" 
								type="radio" 
								name="theme" 
								data-container="<?= $theme->cssname;?>"
								data-layout="<?= $theme->layoutcss;?>"
								value="<?= $theme->id; ?>" <?= $theme->selected; ?>
								>
								<div class="theme-name">
									<?= $theme->name; ?>
								</div>
							</div>
							<div class="theme-preview">
								<img src="<?= base_url("api/assets/media/").$theme->image; ?>" alt="">
							</div>							
						</label>
					</div>			
					<?php } ?>
				</div>
				<div class="button-area">
					<button class="btn btnBlue" type="submit">Apply Now</button>
				</div>
			</form>	
		</div>
	</div>
</div>


<?php $this->load->view('footer'); ?>
<script>
	$(document).ready(function(){
		$(document).on('change', '.tweakcss', function() {
			let concssurl = "<?= base_url('assets/css/');?>"+$(this).data("container");
			let layoutcss = "<?= base_url('assets/css/');?>"+$(this).data("layout");
			$("head link#csscontainer").attr("href", concssurl);
			$("head link#csslayout").attr("href", layoutcss);
			// $('.app .app-container').css('background', '#edeff0');
			// $('.app-sidebar').css('background', 'linear-gradient(180deg, #0a0010 0%, #3f0d93 100%)');
			// $('.sideMenu ul li a').css('color', 'color: #3f0d93;');
			// $('.float.floatButton img').css('background', '#3f0d93');
			// $('.btnBlue, .btnBlue:hover').css({
			// 	background: '#3f0d93',
			// 	border: '1px solid #2d0078'
			// });
		});
	});
</script>