<?php 
    $data['name']='Create QIP'; 
    $this->load->view('header',$data); 
?>
<div class="container addQipListContainer">
	<div class="pageHead">
		<h1>Create QIP</h1>		
	</div>
    <div class="editQipContainer">
        <div class="qualityAreaList">
            <?php 
                if (isset($Areas) && !empty($Areas)) {
                    $i = 1;
                    foreach ($Areas as $areas => $area) {
            ?>
            <div class="qualityArea" style="border: 1px solid <?= $area->color; ?>;">
                <h2 class="qualityAreaHead" style="background: <?= $area->color; ?>;">
                    <?= "Quality Area ".$i; ?>
                </h2>            
                <span class="sr-only">50 / 100</span>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%; background: <?= $area->color; ?>;"></div>
                </div>
                <div class="qualityNameHead"><?= $area->title; ?>
                <a href="<?php echo base_url('qip/view'); ?>"><svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" width="20px" height="20px" viewBox="0 0 200.24 165"><defs><style>.cls-1{fill:#231f20;}</style></defs><path class="cls-1" d="M137,36.21l42,42L139.24,118V97.35l-12.47-2.14a101.53,101.53,0,0,0-15.6-1,151.93,151.93,0,0,0-78.87,22.3c19.39-33.12,50.1-52.14,91.3-56.56L137,58.48V36.21M122,0V45C10,57,0,165,0,165c39.76-49.33,88.32-55.83,111.17-55.83a86.16,86.16,0,0,1,13.07.83v44.24l76-76L122,0Z" transform="translate(0)"/></svg></a>
                </div>
            </div>
            <?php  
                        $i++;
                    }
                }else{
                    echo "<h3>No areas found!</h3>";
                }
            ?>
            
        </div>
    </div>
</div>
<?php $this->load->view('footer'); ?>
