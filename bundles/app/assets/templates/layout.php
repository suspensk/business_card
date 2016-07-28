<?php $this->layout('app:html');?>
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="/campaigns/list">
                Route Perfect URL Builder
			</a>
		</div>
        <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/campaigns/list">Campaigns <span class="sr-only">(current)</span></a></li>
                <li><a href="/campaigns/new">Add a new campaign</a></li>
            </ul>

            <div class="nav navbar-nav navbar-right">
                <?php if($user): ?>
                    <p class="navbar-text">
                        <?=$user->email?>
                        <a class="navbar-link" href="<?=$this->httpPath(
                            'app.action',
                            array('processor' => 'auth', 'action' => 'logout')
                        )?>"> <span class="glyphicon glyphicon-log-out"></span></a>
                    </p>
                <?php else: ?>
                    <li><a href="<?=$this->httpPath(
                            'app.processor',
                            array('processor' => 'auth')
                        )?>">Login</a></li>
                <?php endif;?>
            </div>
        </div><!-- /.navbar-collapse -->





	</div>
</nav>

<?php $this->childContent(); ?>