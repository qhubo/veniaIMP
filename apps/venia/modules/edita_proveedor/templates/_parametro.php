<div class="row">
    <div  class="col-md-2">
      Token Visa  
    </div>
    <div class="col-md-9   <?php if ($form['token_visa']->hasError()) echo "has-error" ?>">
        <?php echo $form['token_visa'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['token_visa']->renderError() ?>       
        </span>
    </div>
</div>


<div class="row">
    <div  class="col-md-2">
      Token Visa  Test
    </div>
    <div class="col-md-9   <?php if ($form['token_visa_test']->hasError()) echo "has-error" ?>">
        <?php echo $form['token_visa_test'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['token_visa_test']->renderError() ?>       
        </span>
    </div>
</div>

           

<div class="row">
    <div  class="col-md-2">
     Epay  Terminal  
    </div>
    <div class="col-md-3  <?php if ($form['epay_terminal']->hasError()) echo "has-error" ?>">
        <?php echo $form['epay_terminal'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['epay_terminal']->renderError() ?>       
        </span>
    </div>
        <div  class="col-md-2">
    Epay  Merchant 
    </div>
    <div class="col-md-3 <?php if ($form['epay_merchant']->hasError()) echo "has-error" ?>">
        <?php echo $form['epay_merchant'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['epay_merchant']->renderError() ?>       
        </span>
    </div>
            <div  class="col-md-1">
 Test Visa    <?php echo $form['test_visa'] ?> 
    </div>
    
</div>


    
<div class="row">
    <div  class="col-md-2">
     Epay User 
    </div>
    <div class="col-md-3  <?php if ($form['epay_user']->hasError()) echo "has-error" ?>">
        <?php echo $form['epay_user'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['epay_user']->renderError() ?>       
        </span>
    </div>
        <div  class="col-md-2">
     Epay Key
    </div>
    <div class="col-md-3 <?php if ($form['epay_key']->hasError()) echo "has-error" ?>">
        <?php echo $form['epay_key'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['epay_key']->renderError() ?>       
        </span>
    </div>
</div>

      <div class="row">
    <div  class="col-md-2">
    Merchan Id
    </div>
    <div class="col-md-2  <?php if ($form['merchand_id']->hasError()) echo "has-error" ?>">
        <?php echo $form['merchand_id'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['merchand_id']->renderError() ?>       
        </span>
    </div>
        <div  class="col-md-1">
   Org Id
    </div>
    <div class="col-md-2 <?php if ($form['org_id']->hasError()) echo "has-error" ?>">
        <?php echo $form['org_id'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['org_id']->renderError() ?>       
        </span>
    </div>
             <div  class="col-md-1">
   Cliente Vol
    </div>
             <div class="col-md-2 <?php if ($form['numero_cliente_vol']->hasError()) echo "has-error" ?>">
        <?php echo $form['numero_cliente_vol'] ?>          
        <span class="help-block form-error"> 
            <?php echo $form['numero_cliente_vol']->renderError() ?>       
        </span>
    </div>
</div>  
            
             
             
           
              
  