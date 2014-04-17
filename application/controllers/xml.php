<?php

class Xml extends CI_Controller {
	function __construct()
	{
		parent::__construct();

		$this->load->model('quiz');
		$this->load->model('tour');
		$this->load->model('package');
		
	}
	
	public function index($package_id) {
		$xmlfile = $this->package->findXmlFile($package_id);
		error_log($xmlfile);
		$path = $this->package->findPath($package_id);
		$hotspots = $this->package->getHotspots($package_id);
		$x2 = file_get_contents($_SERVER['DOCUMENT_ROOT'].$xmlfile);
		$x = preg_replace('/url="images\/pano/',"url=\"$path/images/pano",$x2);
		$xml = new SimpleXMLElement($x);


		foreach ($hotspots as $k=>$v) {
			$thething = $xml->hotspots->addChild('hotspot');
			$thething->addAttribute('id','q'.$v['question_order']);
			$thething->addAttribute('skinid','q'.$v['question_order']);
			$thething->addAttribute('pan',$v['pan']);
			$thething->addAttribute('tilt',$v['tilt']);
			$thething->addAttribute('title','');
			$thething->addAttribute('url','');
			$thething->addAttribute('target','');
		}
		

		header('Content-type: text/xml');
		echo $xml->asXML();



#		$xml->hotspots['hotspot']
/*
	$sxe = new SimpleXMLElement('<root><nodeA/><nodeA/><nodeA/><nodeC/><nodeC/><nodeC/></root>');
	// New element to be inserted
	$insert = new SimpleXMLElement("<nodeB/>");
	// Get the last nodeA element
	$target = current($sxe->xpath('//nodeA[last()]'));
	// Insert the new element after the last nodeA
	simplexml_insert_after($insert, $target);
	// Peek at the new XML
	echo $sxe->asXML();
*/

/*
	 	$domelement = dom_import_simplexml($xml);

	    $new = $dom->insertBefore(
	        $dom->ownerDocument->createElement("total"),
	        $dom->firstChild
	    );

	    $newsxml = simplexml_import_dom($new);

		print "<pre>";
		print_r($xml->hotspots);
		print "</pre>";
*/
	}
}
