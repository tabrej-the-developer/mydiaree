<div class="serach_key">
    <?php foreach($table_value as $table_key=>$table_value){
        $interval = date_diff($now_date, $table_value->observation_date);

        $diff = abs(strtotime($now_date)-strtotime($table_value->observation_date));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        
        $change_url = base_url().'observation/viewChild?childid='.$table_value->childid;
        
        $color='';
        
        if($days>$table_value->alter_day){
            $color= 'border-left-color:#ff0000 ! important ;';
        }?>
        <tr>
            <span>
                <div class="container_new">
                    <div class="row1">
                        
                        <div class="col1" style=" <?php echo $color?> ">

                        <?php 
                        if( (!file_exists(base_url("api/assets/media/".$table_value->image))) && ($table_value->image!='')  ){
                            $fileName = base_url("api/assets/media/".$table_value->image);
                            }else{
                                $fileName = base_url("assets/images/user.png");
                            }  
                            
                            ?>
                            <ul>
                                <li>
                                    <img src='<?php echo $fileName?>' width='60px' height='60px' />
                                    <span class="descList">
                                        <span  class='name' > Name: <a href='<?php echo base_url()?>observation/add/<?php echo $table_value->child_name?>' target='_blank'><?php echo $table_value->child_name?></a></span>
                                        <span  class='category' > Last Observation: <?php echo date("d-m-Y",strtotime($table_value->observation_date));?> </span>
                                    </span>

                                    <p class='check'>
                                       <a href='<?php echo $change_url?>'> <?php echo $table_value->observation_countid;?> </a>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
           </span>
        </tr>

    <?php }?>
</div>
<style>
    * {
    box-sizing: border-box;
}

.col1 ul{
    list-style-type: none;
}

.container_new {
    width:100%;
    max-width:600px;
    margin: 0 auto;
    padding:10px;
}
.row1 {
    height:100px; 
    width:100%;
    margin-bottom:10px;
    padding:10px;
    background:#ffffff;
}
.col1 {
    
    width:100%;
    height: 90px;
    border-left-style: solid;
}

.check{
    padding-left: 87%;
    margin-top: -12%;
    color: #6E519D;
}

}

.align{
    display: inline;
	margin: 20px;

}

.name_align{
    margin-top: -23%;
    margin-left: 38%;
}

.observation{
    margin-top: 4%;
    padding-left: 14%;
}
.count{

}
</style>