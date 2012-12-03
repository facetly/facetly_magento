<?php
 
class Facetly_Find_Adminhtml_ConfigController extends Mage_Adminhtml_Controller_Action
{
    public function apiAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('tab_facetly')
            ->_title($this->__('Configure Facetly API'));

		
		
		$config = Mage::getModel('find/custom');
		$message = $config->setAPI();
		
		
		if($message == 1){
			Mage::getSingleton('core/session')->addSuccess('Configuration saved');
			$this->_initLayoutMessages('core/session');
		}else if($message == 2){
			Mage::getSingleton('core/session')->addError('Failed to save configuration');
			$this->_initLayoutMessages('core/session');
		}

		$action = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		$content_api = '
						<div class="entry-edit">
							<div class="entry-edit-head">
								<h4 class="icon-head head-edit-form fieldset-legend">Configure API</h4>
							</div>
							
							<div class="fieldset fieldset-wide">
								<form action="'.$action.'" method="post" class="form-item">
									 <input name="form_key" type="hidden" value="'.Mage::getSingleton('core/session')->getFormKey().'" />
									<table>
										<tr>
											<td>Consumer Key : </td>
											<td><input type="text" name="facetly_consumer_key" value="'.Mage::getStoreConfig('facetly_consumer_key').'" size="40" /> ex: qhduafdh</td>
										<tr>
										<tr>
											<td>Consumer Secret : </td>
											<td><input type="text" name="facetly_consumer_secret" value="'.Mage::getStoreConfig('facetly_secret_key').'" size="40" /> ex: q5yvmddqntukobeoszi6zuqmwvy9wwsv</td>
										<tr>
										<tr>
											<td>Server Name : </td>
											<td><input type="text" name="facetly_server_name" value="'.Mage::getStoreConfig('facetly_server').'" size="40" /> ex: http://sg1.facetly.com/1</td>
										<tr>
										<tr>
											<td>Search Limit : </td>
											<td><input type="text" name="facetly_search_limit" value="'.Mage::getStoreConfig('facetly_limit').'" size="40" /> ex: 5</td>
										<tr>
										<tr>
											<td>Additional Variable : </td>
											<td><input type="text" name="facetly_additional_variable" value="'.Mage::getStoreConfig('facetly_additional_variable').'" size="40" /> ex: _op[category]=or</td>
										<tr>
										<tr>
											<td colspan=2><input type = "submit" value="Save Configuration"</td>
										<tr>
										
									</table>
								</form>
								
								
								
								
							</div>
						</div>	
							';
		
		
 
		$block = $this->getLayout()
        ->createBlock('core/text', 'field-block')
        ->setText($content_api);

        $this->_addContent($block);

        $this->renderLayout();
    }
 
    public function fieldAction(){
        $this->loadLayout()
            ->_setActiveMenu('tab_facetly')
            ->_title($this->__('Configure Facetly Field'));
		
		//init
		$config = Mage::getModel('find/custom');
		$no_error = 1;
		
		//get field
		$full_field = $config->loadFacetlyField();
		$field = $full_field->field;
		if(empty($field)){
			Mage::getSingleton('core/session')->addError('Cannot connect to server. Please check your API configuration or contact our customer support if problem persist.');
			$no_error = 0;
		}
		
		//get attribute field
		$field_option = $config->loadAttribute();
		if(empty($field_option)){
			Mage::getSingleton('core/session')->addError('Cannot load field attribute');
			$no_error = 0;
		}
		
		//save data field
		$message = $config->setField();
		
		if($message == 1){
			Mage::getSingleton('core/session')->addSuccess('Configuration saved');
		}else if($message == 2){
			Mage::getSingleton('core/session')->addError('Failed to save configuration');
		}
			$this->_initLayoutMessages('core/session');
		
		//print_r($field_option);
		foreach($field as $key => $value){
			$config_name = "field_".$value->name;
			$config_value = Mage::getStoreConfig('facetly_'.$config_name);
			$label_config = ".field.".$value->name;
		
			$option_field .= '<tr><td>'.$label_config.' </td>';
			
			$option_field .= '<td><select name="'.$config_name.'">'; 
			$field_option_configuration = $config_value;
			foreach($field_option as $val => $value2){
				if($field_option_configuration == $value2['code']){
					$select = 'selected="selected"';
				}else{
					$select = '';
				}
				$option_field .= '<option value= "'.$value2['code'].'" '.$select.'>'.$value2['code'].'</option>';
			}
			
			$option_field .= '</select></td>';
			$option_field .= '</tr>';
		}
		
		$option_field .= '<tr><td colspan = 2><input type="submit" value="Save field"></td></tr>';
		
		$action = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		$content_field = '
						<div class="entry-edit">
							<div class="entry-edit-head">
								<h4 class="icon-head head-edit-form fieldset-legend">Configure Field</h4>
							</div>
							
							<div class="fieldset fieldset-wide">
								<form action="'.$action.'" method="post" class="form-item">
									 <input name="form_key" type="hidden" value="'.Mage::getSingleton('core/session')->getFormKey().'" />
									<table>
										'.$option_field.'
									</table>
								</form>	
							</div>
						</div>	
						';
		
		if(!$no_error){
			$content_field = NULL;
		}
 
		$block = $this->getLayout()
        ->createBlock('core/text', 'field-block')
        ->setText($content_field);
		
        $this->_addContent($block);
        $this->renderLayout();
    }
	
	 public function templateAction(){
        $this->loadLayout()
            ->_setActiveMenu('tab_facetly')
            ->_title($this->__('Configure Facetly Field'));
		

		$config = Mage::getModel('find/custom');
		
		$no_error = 1;
		$full_field = $config->loadFacetlyField();
		$field = $full_field->field;
		if(empty($field)){
			Mage::getSingleton('core/session')->addError('Cannot connect to server. Please check your API configuration or contact our customer support if problem persist.');
			$no_error = 0;
		}
		
		$message = $config->setTemplate();
		if(!empty($message)){
			Mage::getSingleton('core/session')->addNotice($message);
		}
		$this->_initLayoutMessages('core/session');
		$default_template = $config->loadFacetlyDefaultTemplate();
		$default_template_facet = $default_template->tplfacet;
		$default_template_search = $default_template->tplsearch;
		
		
		$facetly_search_template = Mage::getStoreConfig('facetly_search_template');
		$facetly_facet_template = Mage::getStoreConfig('facetly_facet_template');
        
		if(empty($facetly_search_template)){
			$facetly_search_template = $default_template_search;
		}
		if(empty($facetly_facet_template)){
			$facetly_facet_template = $default_template_facet;
		}
		
		$action = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		$content_template = '
						<div class="entry-edit">
							<div class="entry-edit-head">
								<h4 class="icon-head head-edit-form fieldset-legend">Configure Template</h4>
							</div>
							
							<div class="fieldset fieldset-wide">
								<form action="'.$action.'" method="post" class="form-item">
									<input name="form_key" type="hidden" value="'.Mage::getSingleton('core/session')->getFormKey().'" />
										<table>
											<tr>
												<td>
													Search Template
												</td>
												<td>
													<textarea name="facetly_search_template" rows="20" cols="90">'.$facetly_search_template.'</textarea>
												</td>
											</tr>
											<tr>
												<td>
													Facet Template
												</td>
												<td>
													<textarea name="facetly_facet_template" rows="20" cols="90">'.$facetly_facet_template.'</textarea>
												</td>
											</tr>
											<tr>
												<td colspan=2>
													<input type="submit" value="Save template" />
												</td>
											</tr>
										</table>
								</form>
							</div>
						</div>	
							';
		if(!$no_error){
			$content_template = NULL;
		}
  
		$block = $this->getLayout()
        ->createBlock('core/text', 'field-block')
        ->setText($content_template);

        $this->_addContent($block);
        $this->renderLayout();
    }
	
	public function reindexAction(){
		 $this->loadLayout()
            ->_setActiveMenu('tab_facetly')
            ->_title($this->__('Configure Facetly Field'));
		
		$no_error = 1;
		$config = Mage::getModel('find/custom');
		$full_field = $config->loadFacetlyField();
		$field = $full_field->field;
		if(empty($field)){
			Mage::getSingleton('core/session')->addError('Cannot connect to server. Please check your API configuration or contact our customer support if problem persist.');
			$this->_initLayoutMessages('core/session');
			$no_error = 0;
		}
		
		$head = Mage::app()->getLayout()->getBlock('head');
		$head->addItem('skin_css', 'css/progressBar.css');
		
		$param = $this->getRequest()->getParams();
		if(!isset($param['page'])){
			$products = Mage::getModel('catalog/product')->getCollection();
			$count_total = count($products);
			
			$products = Mage::getModel('catalog/product')->getCollection();
			$products->addAttributeToFilter('status', 1);
			$count_active = count($products);

			$action = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?page=0';	
			$content_reindex = '
							<div class="entry-edit">
								<div class="entry-edit-head">
									<h4 class="icon-head head-edit-form fieldset-legend">Reindex</h4>
								</div>
								
								<div class="fieldset fieldset-wide">
									<form action="'.$action.'" method="post" class="form-item">
										<input name="form_key" type="hidden" value="'.Mage::getSingleton('core/session')->getFormKey().'" />
											<table>
												<tr>
													<td>
														Size Push Data
													</td>
													<td>
														<input type="text" name="limit_server" value="50" size="40" />
													</td>
												</tr>
												<tr>
													<td>
														Total Product
													</td>
													<td>
														'.$count_total.'
													</td>
												</tr>
												<tr>
													<td>
														Total Active Product
													</td>
													<td>
														'.$count_active.'<input type="text" name="total_active_product" value="'.$count_active.'" size="40" style=display:none />
													</td>
												</tr>
												<tr>
													<td colspan=2>
														<input type="submit" value="Reindex" />
													</td>
												</tr>
											</table>
									</form>
								</div>
							</div>	
								';
			
			
		}
		else if($param['page']==0){
			$temp = rtrim($_SERVER['REQUEST_URI']);
			$temp2 = explode('?',$temp);
			$url = $temp2[0];
			
			$limit_server = $param['limit_server'];
			$next_page = $param['page']+1;
			$total_active_product = $param['total_active_product'];
			$max_page = ceil($total_active_product/$limit_server);
			
			$product = Mage::getModel('find/custom');
			$delete = $product->facetlyTruncate();
			
			$content_reindex = '
								<div class="entry-edit">
									<div class="entry-edit-head">
										<h4 class="icon-head head-edit-form fieldset-legend">Reindex process : Initializing</h4>
									</div>
									
									<div class="fieldset fieldset-wide">
										<div class="meter">
											<span style="width: 0%"></span>
										</div>
									</div>
								</div>
							';
			
			echo '<meta http-equiv="refresh" content="3;URL='.$url.'?page='.$next_page.'&limit_server='.$limit_server.'&max_page='.$max_page.'"> ';
		}
		else if($param['page'] <= $param['max_page']){
			$temp = rtrim($_SERVER['REQUEST_URI']);
			$temp2 = explode('?',$temp);
			$url = $temp2[0];
		
			$limit_server = $param['limit_server'];
			$page = $param['page'];
			$next_page = $page+1;
			$max_page = $param['max_page'];
			$bar_val = round($page/$max_page*100);
			
			$product = Mage::getModel('find/custom');
			$loaded_data = $product->loadGroupProduct($page,$limit_server);
			
			foreach($loaded_data as $val => $data){
				$product->pushItem($data);
			}
			
			$content_reindex = '
								<div class="entry-edit">
									<div class="entry-edit-head">
										<h4 class="icon-head head-edit-form fieldset-legend">Reindex process : '.$bar_val.'%</h4>
									</div>
									
									<div class="fieldset fieldset-wide">
										<div class="meter">
											<span style="width: '.$bar_val.'%"></span>
										</div>
									</div>
								</div>
							';
			if($param['page'] < $max_page){
				echo '<meta http-equiv="refresh" content="3;URL='.$url.'?page='.$next_page.'&limit_server='.$limit_server.'&max_page='.$max_page.'"> ';
			}
			else if($page == $max_page){
				echo '<meta http-equiv="refresh" content="3;URL='.$url.'"> ';
			}
		}
		
		if(!$no_error){
			$content_reindex = NULL;
		}
		
		$block = $this->getLayout()
        ->createBlock('core/text', 'field-block')
        ->setText($content_reindex);

        $this->_addContent($block);
        $this->renderLayout();
	}
}