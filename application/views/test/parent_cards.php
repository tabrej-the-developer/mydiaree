<?php foreach ($parents as $key => $pobj) { ?>
    <div class="col-md-4">
        <div class="card d-flex flex-row mb-4">
            <a class="d-flex" href="<?= base_url("Settings/addParent")."?recordId=".$pobj->userid."&centerid=".$centerid; ?>">
                <?php 
                    $image = empty($pobj->imageUrl)
                        ? "https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_1280.png"
                        : base_url("api/assets/media/").$pobj->imageUrl;
                ?>
                <img alt="Profile" src="<?= $image;?>" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">
            </a>
            <div class="d-flex flex-grow-1 min-width-zero">
                <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                    <div class="min-width-zero">
                        <a href="<?= base_url("Settings/addParent")."?recordId=".$pobj->userid."&centerid=".$centerid; ?>">
                            <p class="list-item-heading mb-1 truncate">
                                <?= ucwords(strtolower($pobj->name)); ?>
                            </p>
                        </a>
                        <ul class="list-unstyled">
                            <li class="users-list-item">
                                <span class="iconsminds-suitcase"></span>
                                <?php if ($pobj->status == 'ACTIVE') { ?>
                                    <span style="color: green; font-weight: bold;">Active</span>
                                <?php } else { ?>
                                    <span style="color: red; font-weight: bold;">Deactivated</span>
                                <?php } ?>
                            </li>
                            <li class="users-list-item">
                                <span class="simple-icon-calendar"></span>
                                <?= date('d-m-y',strtotime($pobj->dob)); ?>
                            </li>
                        </ul>

                        <?php if (!empty($pobj->children)) { ?>
                        <ul class="list-unstyled mt-2">
                            <li class="font-weight-bold">Child/ren:</li>
                            <?php foreach ($pobj->children as $child) { ?>
                            <li class="ml-3">
                                <i class="simple-icon-user"></i>
                                <?= ucwords(strtolower($child->name . ' ' . $child->lastname)); ?>
                                <small class="text-muted">(<?= ucfirst(strtolower($child->relation)); ?>)</small>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php } else { ?>
                        <ul class="list-unstyled mt-2">
                            <li class="ml-3 text-muted">No children linked</li>
                        </ul>
                        <?php } ?>
                    </div>
                </div>

                <div style="margin-right: 15px;margin-top: 10px;">
                    <a href="#" class="delete-link" data-userid="<?= $pobj->userid; ?>">
                        <i class="fa-solid fa-trash fa-fade" style="color: #ff1605;"></i>
                    </a>
                    &nbsp;&nbsp;
                    <?php if ($pobj->status == 'ACTIVE') { ?>
                    <a href="#" class="deactivate-link" data-userid="<?= $pobj->userid; ?>" data-action="deactivate" title="Deactivate">
                        <i class="fa-solid fa-user-check" style="color: #28a745;"></i>
                    </a>
                    <?php } else { ?>
                    <a href="#" class="deactivate-link" data-userid="<?= $pobj->userid; ?>" data-action="activate" title="Activate">
                        <i class="fa-solid fa-user-slash" style="color: #f39c12;"></i>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
