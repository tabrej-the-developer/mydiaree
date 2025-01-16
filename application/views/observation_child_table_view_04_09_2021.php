<div class="serach_key">
    <?php foreach($table_value as $table_key=>$table_value){
        $interval = date_diff($now_date, $datetime2);
        //print_r();
        $color='';
        if($interval->days>$table_value->alter_day){
            $color= 'border-left-color:#ff0000 ! important ;';
        }?>
        <tr>
            <span>
                <div class="container_new">
                    <div class="row">
                        
                        <div class="col1" style=" <?php echo $color?> ">

                        <?php 
                        if( (!file_exists(base_url("api/assets/media/".$table_value->image))) && ($table_value->image!='')  ){
                            $fileName = base_url("api/assets/media/".$table_value->image);
                            }else{
                                $fileName = base_url("assets/images/user.png");
                            }  //$fileName = base_url("assets/images/user.png");
                            //$fileName = base_url("api/assets/media/".$table_value->image);
                            ?>
                            <ul>
                            </ul>
                            <td>
                                <!--<label>-->
                                    <img src='http://localhost/Mykronicle/api/assets/media/chocolate.jpeg' style='width: 4em;border-radius: 50%;margin-left: 2%;' width='10%' height='50%' />

                                    <span style='display: block;margin-left: 20%;margin-top: -9%;font-size: 16px;line-height: 19px;color: #000000;' class='name' > Name: <a href='<?php echo base_url()?>observation/add/<?php echo $table_value->child_name?>' target='_blank'><?php echo $table_value->child_name?></a></span>

                                    <span style='display: block;margin-top: 3%;margin-left: 20%;font-size: 16px;line-height: 19px;color: #000000;' class='category' > Last Observation: <?php echo date("d-m-Y",strtotime($table_value->observation_date));?> </span>
                                <!--</label>-->

                                <p class='check'>
                                            <?php echo $table_value->observation_countid;?>
                                </p>
                        </td>
                            <!-- margin-top: -27%; -->
                            
                            
                            <!-- margin-top: -15%; margin-left: 23%;
                                margin-top:-10%;margin-left: 14%;-->
                            <?php /*<ul class='align' >
                                <li class='name_align' style='' >
                                    <span style=' '> Name: <?php echo $table_value->child_name?></span>
                                </li>
                            </ul>

                            <ul>
                            
                                <li class='observation' style=''><span> Last Observation:<?php echo date("d-m-Y",strtotime($table_value->observation_date));?></span></li>

                            </ul>

                            
                            <p class='check'>
                                    <?php echo $table_value->observation_countid;?>
                            </p>*/?>
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
    /*border:2px solid black;*/
    margin: 0 auto;
    padding:10px;
}
.row {
    height:100px; /*set height*/
    /*border:2px solid blue;
    background: var(--white);*/
    width:100%;
    margin-bottom:10px;
    padding:10px;
    background:#ffffff;
}
.col1 {
    
    width:100%;
    height: 90px;
    /*height: 120px;
    height:100%;   
    border:2px solid red; */
    border-left-style: solid;
}

.check{
    /*margin-top: -17%;
    padding-left: 88%;
    padding-left: 80%;
    margin-top: -10%;
    padding-left: 90%;
    margin-top: -28%;*/
    padding-left: 87%;
    margin-top: -12%;
    color: #6E519D;
}

}

.align{
    /*margin-left: 32%;
    margin-top: -50px;*/
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