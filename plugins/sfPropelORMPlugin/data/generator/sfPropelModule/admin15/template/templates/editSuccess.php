[?php use_helper('I18N', 'Date') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]
<div class="portlet box green-meadow">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil"></i>[?php echo <?php echo $this->getI18NString('edit.title') ?> ?]
        </div>
        <div class="actions">
            <?php foreach (array('new', 'edit') as $action): ?>
                <?php foreach ($this->configuration->getValue($action . '.actions') as $name => $params): ?>
                    <?php if ('_list' == $name): ?>
                        <?php echo $this->addCredentialCondition('[?php echo $helper->linkToList(' . $this->asPhp($params) . ') ?]', $params) ?>
                        <?php break 2; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="portlet-body form">
        [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]

        <div id="sf_admin_header">
            [?php include_partial('<?php echo $this->getModuleName() ?>/form_header', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
        </div>

        <div id="sf_admin_content">
            [?php include_partial('<?php echo $this->getModuleName() ?>/form', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
        </div>
        <div id="sf_admin_footer">
            [?php include_partial('<?php echo $this->getModuleName() ?>/form_footer', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
        </div>
    </div>
</div>