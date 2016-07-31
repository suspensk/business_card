<?php
foreach($pages as $step => $page) : ?>
    <span class="multi_pages_ul">
                <label class="col-sm-2 form-control-label"><?= $step == 0 ? 'Result URLS <span style="color:red;">*</span>
                <button id="copyAll" type="button" class="btn-success btn-sm"  >copy all</button>' : '' ?></label>
                <div class="col-sm-8<?= $step == 0? ' has-success' : '' ?>" >
                    <div  class="landing-page form-control"><?= $page->url ?>?cid=<?= $campaign_id ?></div>
                </div>
                <div class="col-sm-2 buttons-container">
                    <a target="_blank" href=" <?= $page->url ?>?cid=<?= $campaign_id ?>" class=" btn-info btn" >test</a>
                    <button type="button" class="btn-success btn copyButton"  >copy</button>
                </div>
              </span>
<?php  endforeach; ?>
