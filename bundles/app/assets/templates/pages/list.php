<?php $this->layout('app:layout');?>
<div class="container list-container">
<h1>Campaigns list <!--&nbsp;&nbsp;&nbsp; <a href="/campaigns/new" class="btn btn-success">Add a new campaign</a>--></h1>

    <table  class="table table-striped table-bordered" width="100%" cellspacing="0" id="campTbl">
        <thead>
        <tr>
            <th>ID</th>
            <th>Publisher</th>
            <th>AD Group</th>
            <th>Medium</th>
            <th>Creation date</th>
            <th>Country</th>
            <th>City</th>
            <th>Product</th>
            <th>Compensation</th>
            <th>Compensation Type</th>
            <th>Start</th>
            <th>End</th>
            <th>Rep</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($campaigns as $campaign):?>
            <tr>
                <td><a href="/campaigns/view/<?php echo $campaign->id;?>"><?= $campaign->id ?></a></td>
                <td>
                    <?= $campaign->publisher() ? $campaign->publisher()->name : '' ?>
                </td>
                <td>
                    <?= $campaign->ad_group ?>
                </td>
                <td>
                    <?= $campaign->medium() ? $campaign->medium()->name : '' ?>
                </td>
                <td>
                    <?= $campaign->timestamp ?>
                </td>
                <td>
                    <?= $campaign->country() ? $campaign->country()->name : '' ?>
                </td>
                <td>
                    <?= $campaign->city() ? $campaign->city()->name : '' ?>
                </td>
                <td>
                    <?= $campaign->product ?>
                </td>
                <td>
                    <?= $campaign->paid ?>
                </td>
                <td>
                    <?= $campaign->compensation() ? $campaign->compensation()->name : '' ?>
                </td>
                <td>
                    <?= $campaign->start ?>
                </td>
                <td>
                    <?= $campaign->end ?>
                </td>
                <td>
                    <?= $campaign->rep() ? $campaign->rep()->name : '' ?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>