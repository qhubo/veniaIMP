
<?php

class sfWidgetFormSchemaFormatterVelformat extends sfWidgetFormSchemaFormatter
{
  protected
    $xrowFormat       = "<div class=\"form_row\">
                        %label% \n %error% <br/> %field%
                        %help% %hidden_fields%\n</div>\n",
    $rowFormat       = "<div class='sf_admin_form control-group form_field%error_class%'>
        <label class='control-label'>%label%</label>
        <div class='form-field-content controls'>
          %field%
          %error%
          %help% %hidden_fields%\n
        </div>
      </div>
",

    $errorRowFormat  = "<div>%errors%</div>",
    $labelRowFormat     = '<div class="control-label>%label%</label>',
    $helpFormat      = '<span class="form_help help-inline">%help%</span>',
    $decoratorFormat = "<div>\n  %content%</div>";

  public function formatRow($label, $field, $errors = array(), $help = '', $hiddenFields = null)
  {
    $row = parent::formatRow(
      $label,
      $field,
      $errors,
      $help,
      $hiddenFields
    );

    return strtr($row, array(
      '%error_class%' => (count($errors) > 0) ? ' error' : '',
    ));
  }
}
