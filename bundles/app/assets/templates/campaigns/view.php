<?php $this->layout('app:layout');?>

<div class="container">
    <form id="campaignForm" data-toggle="validator" role="form" name="campaign" method="POST" action="<?=$this->httpPath(
        'app.action',
        array('processor' => 'campaigns', 'action' => 'save')
    )?>">
        <?php
        $campaignPagesArr = array();
        if(isset($campaign)):
            foreach($campaign->pages()->asArray(true) as $cPage){
                $campaignPagesArr[] = $cPage -> id;
            }
            $arrResultPages = array();
            foreach($pages as $page){
                if(in_array($page->id, $campaignPagesArr)){
                    if(isset($campaign->default_page()->id) && ($page->id == $campaign->default_page()->id)){
                        array_unshift($arrResultPages, $page);
                    } else{
                        $arrResultPages[] = $page;
                    }
                }
            }
            ?>

            <fieldset class="form-group row" id="multi_pages_ul">
                <?= $this->render(
                    'app:campaigns/pages',
                    array(
                        'pages' =>  $arrResultPages,
                        'campaign_id' => $campaign->id
                    )); ?>

            </fieldset>
        <?php endif; ?>
        <h2 class="section-title">Who</h2>
        <?php if(isset($campaign)): ?>
        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="idInput">Campaign ID</label>
            <div class="col-sm-8">
                <input name="id" readonly type="text" class="form-control" id="idInput"  value="<?= $campaign->id ?>">
            </div>
        </fieldset>
        <?php endif ?>

        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="countries">Country</label>
            <div class="col-sm-8">
            <select name="country"  class="selectpicker changeEntity" data-live-search="true" id="countries" data-default="<?= (isset($campaign) && $campaign->country() ? $campaign->country()->id : '') ?>" >
                <option value="">-- Nothing selected --</option>
                <?php foreach($countries as $country) : ?>
                <option value="<?= $country->id ?>" <?= (isset($campaign) && $campaign->country() && $campaign->country()->id ==  $country->id ? 'selected' : '') ?>><?= $country->name ?></option>
                <?php endforeach; ?>
            </select>
                </div>
            <div class="col-sm-2 buttons-container">
                <button id="countriesBtnAdd" type="button" class="openAddForm glyphicon glyphicon-plus btn-primary btn" data-toggle="modal" data-target="#addCountry" data-type="country" data-types="countries"></button>
                <button id="countriesBtnEdit" <?= (isset($campaign) && $campaign->country() ? '' : 'disabled') ?> type="button" class="openAddForm openEditForm glyphicon glyphicon-pencil btn-primary btn" data-toggle="modal" data-target="#addCountry" data-type="country" data-types="countries"></button>
                <button id="countriesBtnRemove" <?= (isset($campaign) && $campaign->country() ? '' : 'disabled') ?> type="button" class="deleteEntity glyphicon glyphicon-remove btn-danger btn" data-type="country" data-types="countries"></button>
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="cities">City</label>
            <div class="col-sm-8">
            <select name="city" class="selectpicker changeEntity" data-live-search="true" id="cities">
                <option value="">-- Nothing selected --</option>
                <?php foreach($cities as $city) : ?>
                    <option <?= ($campaign->city() && $campaign->city()->id ==  $city->id ? 'selected' : '') ?> value="<?= $city->id ?>"><?= $city->name ?></option>
                <?php endforeach; ?>
            </select>
            </div>
            <div class="col-sm-2 buttons-container">
                <button id="citiesBtnAdd" type="button" class="openAddForm glyphicon glyphicon-plus btn-primary btn" data-toggle="modal" data-target="#addCity" <?= (isset($campaign) && $campaign->country() ? '' : 'disabled') ?> data-type="city" data-types="cities"></button>
                <button id="citiesBtnEdit" <?= (isset($campaign) && $campaign->city() ? '' : 'disabled') ?> type="button" class="openAddForm openEditForm glyphicon glyphicon-pencil btn-primary btn" data-toggle="modal" data-target="#addCity" data-type="city" data-types="cities"></button>
                <button id="citiesBtnRemove" <?= (isset($campaign) && $campaign->city() ? '' : 'disabled') ?> type="button" class="deleteEntity glyphicon glyphicon-remove btn-danger btn" data-type="city" data-types="cities"></button>
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="productInput">Product</label>
            <div class="col-sm-8">
            <input id="productInput" name="product" type="text" class="form-control" placeholder="Enter product" value="<?= isset($campaign) ? $campaign->product: '' ?>">
                </div>
        </fieldset>
        <h2 class="section-title">Where</h2>
        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="mediums">Medium <span style="color:red;">*</span></label>
            <div class="col-sm-8">
                <select name="medium"  class="selectpicker changeEntity" data-live-search="true" id="mediums" data-default="<?= (isset($campaign) && $campaign->medium() ? $campaign->medium()->id : '') ?>" >
                    <option value="">-- Nothing selected --</option>
                    <?php foreach($mediums as $medium) : ?>
                        <option value="<?= $medium->id ?>" <?= (isset($campaign) && $campaign->medium() && $campaign->medium()->id ==  $medium->id ? 'selected' : '') ?>><?= $medium->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-2 buttons-container">
                <button id="mediumsBtnAdd" type="button" class="openAddForm glyphicon glyphicon-plus btn-primary btn" data-toggle="modal" data-target="#addMedium" data-type="medium" data-types="mediums"></button>
                <button id="mediumsBtnEdit" <?= (isset($campaign) && $campaign->medium() ? '' : 'disabled') ?> type="button" class="openAddForm openEditForm glyphicon glyphicon-pencil btn-primary btn" data-toggle="modal" data-target="#addMedium" data-type="medium" data-types="mediums"></button>
                <button id="mediumsBtnRemove" <?= (isset($campaign) && $campaign->medium() ? '' : 'disabled') ?> type="button" class="deleteEntity glyphicon glyphicon-remove btn-danger btn" data-type="medium" data-types="mediums"></button>
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="publishers">Publisher <span style="color:red;">*</span></label>
            <div class="col-sm-8">
                <select name="publisher"  class="selectpicker changeEntity" data-live-search="true" id="publishers" data-default="<?= (isset($campaign) && $campaign->publisher() ? $campaign->publisher()->id : '') ?>" >
                    <option value="">-- Nothing selected --</option>
                    <?php foreach($publishers as $publisher) : ?>
                        <option value="<?= $publisher->id ?>" <?= (isset($campaign) && $campaign->publisher() && $campaign->publisher()->id ==  $publisher->id ? 'selected' : '') ?>><?= $publisher->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-2 buttons-container">
                <button id="publishersBtnAdd" type="button" class="openAddForm glyphicon glyphicon-plus btn-primary btn" data-toggle="modal" data-target="#addPublisher" data-type="publisher" data-types="publishers"></button>
                <button id="publishersBtnEdit" <?= (isset($campaign) && $campaign->publisher() ? '' : 'disabled') ?> type="button" class="openAddForm openEditForm glyphicon glyphicon-pencil btn-primary btn" data-toggle="modal" data-target="#addPublisher" data-type="publisher" data-types="publishers"></button>
                <button id="publishersBtnRemove" <?= (isset($campaign) && $campaign->publisher() ? '' : 'disabled') ?> type="button" class="deleteEntity glyphicon glyphicon-remove btn-danger btn" data-type="publisher" data-types="publishers"></button>
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="ad_groupInput">Ad Group</label>
            <div class="col-sm-8">
            <input name="ad_group" type="text" class="form-control" id="ad_groupInput" placeholder="Enter AD group" value="<?= isset($campaign) ? $campaign->ad_group : '' ?>">
                </div>
        </fieldset>
        <h2 class="section-title">Compensation</h2>
        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="paidInput">Compensation</label>
            <div class="col-sm-8">
            <select name="paid" class="form-control" id="paidInput">
                <option value="paid" <?= (isset($campaign) && $campaign->paid == 'paid' ? 'selected' : '') ?>>paid</option>
                <option value="free" <?= (isset($campaign) && $campaign->paid == 'free' ? 'selected' : '') ?>>free</option>
            </select>
                </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="compensations">Compensation Type</label>
            <div class="col-sm-8">
                <select name="compensation"  class="selectpicker changeEntity" data-live-search="true" id="compensations" data-default="<?= (isset($campaign) && $campaign->compensation() ? $campaign->compensation()->id : '') ?>" >
                    <option value="">-- Nothing selected --</option>
                    <?php foreach($compensations as $compensation) : ?>
                        <option value="<?= $compensation->id ?>" <?= (isset($campaign) && $campaign->compensation() && $campaign->compensation()->id ==  $compensation->id ? 'selected' : '') ?>><?= $compensation->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-2 buttons-container">
                <button id="compensationsBtnAdd" type="button" class="openAddForm glyphicon glyphicon-plus btn-primary btn" data-toggle="modal" data-target="#addCompensation" data-type="compensation" data-types="compensations"></button>
                <button id="compensationsBtnEdit" <?= (isset($campaign) && $campaign->compensation() ? '' : 'disabled') ?> type="button" class="openAddForm openEditForm glyphicon glyphicon-pencil btn-primary btn" data-toggle="modal" data-target="#addCompensation" data-type="compensation" data-types="compensations"></button>
                <button id="compensationsBtnRemove" <?= (isset($campaign) && $campaign->compensation() ? '' : 'disabled') ?> type="button" class="deleteEntity glyphicon glyphicon-remove btn-danger btn" data-type="compensation" data-types="compensations"></button>
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="rateInput">Compensation Rate</label>
            <div class="col-sm-8">
            <input name="rate" type="text" class="form-control" id="rateInput" placeholder="Enter Compensation Rate" value="<?= isset($campaign) ? $campaign->rate : '' ?>">
                </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="payment_terms">Payment Term</label>
            <div class="col-sm-8">
                <select name="payment_term"  class="selectpicker changeEntity" data-live-search="true" id="payment_terms" data-default="<?= (isset($campaign) && $campaign->payment_term() ? $campaign->payment_term()->id : '') ?>" >
                    <option value="">-- Nothing selected --</option>
                    <?php foreach($payment_terms as $payment_term) : ?>
                        <option value="<?= $payment_term->id ?>" <?= (isset($campaign) && $campaign->payment_term() && $campaign->payment_term()->id ==  $payment_term->id ? 'selected' : '') ?>><?= $payment_term->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-2 buttons-container">
                <button id="payment_termsBtnAdd" type="button" class="openAddForm glyphicon glyphicon-plus btn-primary btn" data-toggle="modal" data-target="#addPayment_term" data-type="payment_term" data-types="payment_terms"></button>
                <button id="payment_termsBtnEdit" <?= (isset($campaign) && $campaign->payment_term() ? '' : 'disabled') ?> type="button" class="openAddForm openEditForm glyphicon glyphicon-pencil btn-primary btn" data-toggle="modal" data-target="#addPayment_term" data-type="payment_term" data-types="payment_terms"></button>
                <button id="payment_termsBtnRemove" <?= (isset($campaign) && $campaign->payment_term() ? '' : 'disabled') ?> type="button" class="deleteEntity glyphicon glyphicon-remove btn-danger btn" data-type="payment_term" data-types="payment_terms"></button>
            </div>
        </fieldset>
        <h2 class="section-title">Campaign details</h2>
        <?php

        ?>


        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="multi_pages">Landing pages <span style="color:red;">*</span></label>
            <div class="col-sm-8">
                <select multiple name="multi_page[]"  class="selectpicker changeEntity" data-live-search="true" id="multi_pages" data-default="<?= (!empty($campaignPagesArr) ? implode(',',$campaignPagesArr) : '') ?>" >
                   <!-- <option value="">-- Nothing selected --</option>-->
                    <?php
                    foreach($pages as $page) : ?>
                        <option value="<?= $page->id ?>" <?= (in_array($page->id, $campaignPagesArr) ? 'selected' : '') ?>><?= $page->url ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="pages">Default landing page <span style="color:red;">*</span></label>
            <div class="col-sm-8">
                <select name="page"  class="selectpicker changeEntity" data-live-search="true" id="pages" data-default="<?= (isset($campaign) && isset($campaign->default_page()->id) && $campaign->default_page()->id ? $campaign->default_page()->id : '') ?>" >
                    <option value="">-- Nothing selected --</option>
                    <?php foreach($pages as $page) : ?>
                        <?php if(in_array($page->id, $campaignPagesArr)): ?>
                            <option value="<?= $page->id ?>" <?= (isset($campaign) && $campaign->default_page() && $campaign->default_page()->id ==  $page->id ? 'selected' : '') ?>><?= $page->url ?></option>
                        <?php endif; endforeach; ?>
                </select>
            </div>
            <div class="col-sm-2 buttons-container">
                <button id="pagesBtnAdd" type="button" class="openAddForm glyphicon glyphicon-plus btn-primary btn" data-toggle="modal" data-target="#addPage" data-type="page" data-types="pages"></button>
                <button id="pagesBtnEdit" <?= (isset($campaign) && $campaign->default_page() ? '' : 'disabled') ?> type="button" class="openAddForm openEditForm glyphicon glyphicon-pencil btn-primary btn" data-toggle="modal" data-target="#addPage" data-type="page" data-types="pages"></button>
                <button id="pagesBtnRemove" <?= (isset($campaign) && $campaign->default_page() ? '' : 'disabled') ?> type="button" class="deleteEntity glyphicon glyphicon-remove btn-danger btn" data-type="page" data-types="pages"></button>
            </div>
        </fieldset>
        <fieldset class="form-group row">
        <label class="col-sm-2 form-control-label" for="startInput">Start Date</label>
            <div class="col-sm-8">
        <div class="input-group date" data-provide="datepicker">
            <input name="start" id="startInput" type="text" class="form-control"  placeholder="Start Date" value="<?= isset($campaign) ?  $campaign->start : '' ?>">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>
                </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="endInput">End Date</label>
            <div class="col-sm-8">
            <div class="input-group date" data-provide="datepicker">
                <input id="endInput" name="end" type="text" class="form-control"  placeholder="End Date" value="<?= isset($campaign) ? $campaign->end : '' ?>">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
                </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="reps">Rep</label>
            <div class="col-sm-8">
                <select name="rep"  class="selectpicker changeEntity" data-live-search="true" id="reps" data-default="<?= (isset($campaign) && $campaign->rep() ? $campaign->rep()->id : '') ?>" >
                    <option value="">-- Nothing selected --</option>
                    <?php foreach($reps as $rep) : ?>
                        <option value="<?= $rep->id ?>" <?= (isset($campaign) && $campaign->rep() && $campaign->rep()->id ==  $rep->id ? 'selected' : '') ?>><?= $rep->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-2 buttons-container">
                <button id="repsBtnAdd" type="button" class="openAddForm glyphicon glyphicon-plus btn-primary btn" data-toggle="modal" data-target="#addRep" data-type="rep" data-types="reps"></button>
                <button id="repsBtnEdit" <?= (isset($campaign) && $campaign->rep() ? '' : 'disabled') ?> type="button" class="openAddForm openEditForm glyphicon glyphicon-pencil btn-primary btn" data-toggle="modal" data-target="#addRep" data-type="rep" data-types="reps"></button>
                <button id="repsBtnRemove" <?= (isset($campaign) && $campaign->rep() ? '' : 'disabled') ?> type="button" class="deleteEntity glyphicon glyphicon-remove btn-danger btn" data-type="rep" data-types="reps"></button>
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="col-sm-2 form-control-label" for="remarksInput">Remarks</label>
            <div class="col-sm-8">
            <textarea name="remarks"  class="form-control" rows="5" placeholder="Enter your remarks" id="remarksInput"><?= isset($campaign) ? $campaign->remarks : '' ?></textarea>
                </div>
        </fieldset>

        <fieldset class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <?= isset($campaign) ? '&nbsp;&nbsp;&nbsp;<span id="saveAsNew" class="btn btn-primary ">Save as New</span>' : '' ?>
                <button type="submit" class="btn btn-success save-btn"><?= isset($campaign) ? 'Save' : 'Add' ?></button>
            </div>

        </fieldset>
        </form>

    <!-- Modal -->
    <div class="modal fade modalForm modalFormSimple" id="addEntity" tabindex="-1" role="dialog" aria-labelledby="addEntityLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="addEntityForm" id="addEntityForm"  role="form" method="POST" data-type="" data-types="">
                <input type="hidden" name="id" value = "0">
                <input name="country" id="countryId" type="hidden" value="<?= (isset($campaign) && $campaign->country() ? $campaign->country()->id : '') ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="addEntityLabel">Add\Edit entity</h4>
                    </div>
                    <div class="modal-body">
                        <div class="result">
                        </div>
                        <fieldset class="form-group">
                            <label for="entityName">Entity Name <span style="color:red;">*</span></label>
                            <input  autocomplete="off" name="name" type="text" class="form-control" id="entityName" placeholder="Enter name" value=""  data-minlength="1" required data-error="Please, enter entity Name">
                            <div class="help-block with-errors"></div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <fieldset class="form-group">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </fieldset>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>