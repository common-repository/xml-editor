<?php
//loads the XML file from disk and converts to several arrays for displaying on Wordpress settings form
	$count = 0;
	$xml_ids = array();
	$xml_products = array();
	$xml_links = array();
	$xml_bricks = array();
	$options = get_option('buybrick_options');
	$file = $options['xmlpath'];
	$numfields = explode(',',$options['numfields']);
	$bricklinks = explode(',',$options['bricklinks']);
	$fullpath = array();
	foreach ($bricklinks as $key=>$val) {
		$fullpath[$key] = $options['linkpath'].$val;
	} 
	$imagespath = $options['imagespath'];
	$pbrickimg = $imagespath.$options['pbrickimg'];
	$upbrickimg = $imagespath.$options['upbrickimg'];
	if (isset($_POST['xmledited'])) {
	//here we reformat the form data into XML...
		$new_xml = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\"?><bricks></bricks>");
		foreach ($_POST as $key=>$val) {
		
			if (strpos($key,"id")!==false) {
				$item = $new_xml->AddChild('item');
				$item->AddAttribute('id',$val);
				$item->AddAttribute('product_name',$_POST['product_'.$count]);
				$item->AddAttribute('link_brick',$_POST['link_'.$count]);
				$item->AddAttribute('bricks',$_POST['brick_'.$count]);
				if ($count==0) {
					$item->AddAttribute('raised',$_POST['total']);
				}
				$count++;
			} // end if statement
		} // end foreach statement
		//aaaand, write to XML file in specified location
		$new_xml->asXML($_SERVER{'DOCUMENT_ROOT'}.$file);
		
?>
<div class="updated"><p><strong><?php _e('File saved.' ); ?></strong></p></div> 
<?php
	} // end xmledited if statement
	// if the form has not been submitted, load the file into arrays...

	if (file_exists($_SERVER{'DOCUMENT_ROOT'}.$file)) {
		$xml = simplexml_load_file($_SERVER{'DOCUMENT_ROOT'}.$file);
		// damn, file is malformed...		
		if (!$xml) {
    		echo "Failed loading XML\n";
    		foreach(libxml_get_errors() as $error) {
        		echo "\n", $error->message;
   		 }
		}
   	foreach ($xml->item as $item) {
			if (isset($item['raised'])) {
				$xml_raised = $item['raised'];
			}
			$xml_ids[] = $item['id'];
			$xml_products[] = $item['product_name'];
			$xml_links[] = $item['link_brick'];
			$xml_bricks[] = $item['bricks'];
		}// end foreach
	} 
	else {
?>
    		<div class="updated"><p><strong><?php _e('Cannot open file.' ); ?></strong></p></div> 
<?php 
	}

	//now put into a nice form
	echo '<div class="wrap"><p><span class="th1"><u>Brick #</u></span><span class="th2"><u>Donor/Message:</u></span><span class="th3"><u>Brick Amount:</u></span><span class="th4"><u>Purchased?</u></span></p>';
	echo '<form method="post" action="';
	echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);
	echo '">';
	echo '<input type="hidden" name="xmledited" value="Y" />';
	// this loop displays XML arrays as form inputs 
	foreach ($xml_ids as $key=>$val) {
		echo '<p><input class="ids" size="8" name="id_'.$key.'" value="'.$val.'" />';
		echo '<input class="products" size="40" name="product_'.$key.'" value="'.$xml_products[$key].'" />';
		echo '<select name="link_'.$key.'">'; 
		foreach ($fullpath as $index=>$value) {
			// if the full link to the brick purchase page from the file matches one of the paths stipulated in the settings...	
			if ($xml_links[$key] == $value) {
				echo '<option selected="selected" value="'.$value.'">$'.$numfields[$index].' Brick</option>';
			}
			else {
				echo '<option value="'.$value.'">$'.$numfields[$index].' Brick</option>';
			}
		}		
		echo '</select>';
		echo '<select name="brick_'.$key.'">';		
		// if the full link to the purchased brick image matches the path stipulated in the settings
		if ($xml_bricks[$key] == $pbrickimg) {
		// write out dropdown option that brick is purchased as the selected option
			echo '<option selected="selected" value="'.$pbrickimg.'">Purchased</option>';
			echo '<option value="'.$upbrickimg.'">Unpurchased</option>';
		}
		else {
			echo '<option selected="selected" value="'.$upbrickimg.'">Unpurchased</option>';
			echo '<option value="'.$pbrickimg.'">Purchased</option>';	
		}	
		echo '</select>';
	} //end foreach statement 

	// Output the total raised so far on the last line of the form
	if (isset($xml_raised)) {
		echo '<p>Total Raised so far:  <input type="text" name="total" value="'.$xml_raised.'"></p>';
	}
	echo '<p class="submit"><input type="submit" name="Save Changes"></p>';
	echo '</form>';
	echo '</div>';
?>
