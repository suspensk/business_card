<?php $this->layout('app:layout');?>
<div class="container">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4"

            <!-- Nav tabs -->
            <?php $activeTab = $this->get('activeTab', 'login'); ?>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="<?=$activeTab=='login' ? 'active' : ''?>">
                    <a href="#login" aria-controls="login" role="tab" data-toggle="tab">Login</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane <?=$activeTab=='login' ? 'active' : ''?>" id="login">
                    <form method="POST" action="<?=$this->httpPath(
                        'app.processor',
                        array('processor' => 'auth')
                    )?>">
                        <?php if($this->get('loginFailed')): ?>
                            <div class="form-group">
                                <div class="alert alert-warning" role="alert">Login failed</div>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="loginEmail">Email address</label>
                            <input type="email" name="email" class="form-control" id="loginEmail" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label for="loginPassword">Password</label>
                            <input type="password" name="password" class="form-control" id="loginPassword" placeholder="Password">
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="rememberMe"> Remember me
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-default">Submit</button>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>