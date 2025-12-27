[?php use_helper('I18N', 'Date') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<div class="row">
    <div class="col-md-12">
        [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]
    </div>
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-list"></i>
                    [?php echo <?php echo $this->getI18NString('list.title') ?> ?]
                </div>
                <div class="actions">
                    <a class="vel_filtros_generator btn btn-info btn-circle">
                        Filtros <span class="vel_badge_filter badge badge-info">0</span>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="scroller">
                    <?php if ($this->configuration->getValue('list.batch_actions')): ?>
                        <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'batch')) ?]" method="post">
                        <?php endif; ?>
                        [?php include_partial('<?php echo $this->getModuleName() ?>/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?]
                        <br/>
                        <div class="row">
                            <div class="col-md-6">
                                <!--[?php include_partial('<?php echo $this->getModuleName() ?>/list_batch_actions', array('helper' => $helper)) ?]-->
                            </div>
                            <div class="col-md-6">
                                [?php include_partial('<?php echo $this->getModuleName() ?>/list_actions', array('helper' => $helper)) ?]
                            </div>
                        </div>
                        <br/>
                        <?php if ($this->configuration->getValue('list.batch_actions')): ?>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <div id="sf_admin_footer">
                [?php include_partial('<?php echo $this->getModuleName() ?>/list_footer', array('pager' => $pager)) ?]
            </div>
        </div>
    </div>
    <div id="filtros" >
        <?php if ($this->configuration->hasFilterForm()): ?>
            [?php include_partial('<?php echo $this->getModuleName() ?>/filters', array('form' => $filters, 'configuration' => $configuration)) ?]
        <?php endif; ?>
    </div>

</div>