
    <!--
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Policy Editor</title>
	<link rel="icon" href="../favicon.ico" type="image/png" />
  <link rel="SHORTCUT ICON" href="../favicon.ico" type="image/png" />
-->
    
<!-- YUI -->
<!-- link rel="stylesheet" type="text/css" href="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/yui/reset-fonts-grids/reset-fonts-grids.css" / -->
<link rel="stylesheet" type="text/css" href="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/yui/assets/skins/sam/skin.css" />

<!-- InputEx CSS -->
<link type='text/css' rel='stylesheet' href='<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/inputex/css/inputEx.css' />

<!-- YUI-accordion CSS -->
<link rel="stylesheet" type="text/css" href="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/accordionview/assets/skins/sam/accordionview.css" />

<!-- WireIt CSS -->
<link rel="stylesheet" type="text/css" href="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/css/WireIt.css" />
<link rel="stylesheet" type="text/css" href="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/css/WireItEditor.css" />

<style>
div.WireIt-Container {
	width: 350px; /* Prevent the modules from scratching on the right */
}

div.WireIt-InOutContainer {	
	width: 150px;
}

div.WireIt-InputExTerminal {
	float: left;
	width: 21px;
	height: 21px;
	position: relative;
}
div.WireIt-InputExTerminal div.WireIt-Terminal {
	top: -3px;
	left: -7px;
}
div.inputEx-Group div.inputEx-label {
	width:100px;
}

div.WireIt-ImageContainer {
	width: auto;
}

div.Bubble div.body {
	width: 70px;
	height: 45px;
	opacity: 0.8;
	cursor: move;
}

.WiringEditor-module span {
	position: relative;
	top: -3px;
}

</style>

<!-- YUI -->
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/yui/utilities/utilities.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/yui/resize/resize-min.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/yui/layout/layout-debug.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/yui/container/container-min.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/yui/json/json-min.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/yui/button/button-min.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/yui/tabview/tabview-min.js"></script>

<!-- InputEx with wirable options (WirableField-beta) -->
<script src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/inputex/js/inputex.js"  type='text/javascript'></script>
<script src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/inputex/js/Field.js"  type='text/javascript'></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/js/util/inputex/WirableField-beta.js"></script>
<script src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/inputex/js/Group.js"  type='text/javascript'></script>
<script src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/inputex/js/Visus.js"  type='text/javascript'></script>
<script src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/inputex/js/fields/StringField.js"  type='text/javascript'></script>
<script src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/inputex/js/fields/Textarea.js"  type='text/javascript'></script>
<script src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/inputex/js/fields/SelectField.js"  type='text/javascript'></script>
<script src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/inputex/js/fields/EmailField.js"  type='text/javascript'></script>
<script src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/inputex/js/fields/UrlField.js"  type='text/javascript'></script>
<script src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/inputex/js/fields/ListField.js"  type='text/javascript'></script>
<script src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/inputex/js/fields/CheckBox.js"  type='text/javascript'></script>
<script src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/inputex/js/fields/InPlaceEdit.js"  type='text/javascript'></script>

<!-- YUI-Accordion -->
<script src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/accordionview/accordionview-min.js"  type='text/javascript'></script>

<!-- WireIt -->
<!--[if IE]><script type="text/javascript" src="<= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/excanvas.js"></script><![endif]-->
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/js/WireIt.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/js/CanvasElement.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/js/Wire.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/js/Terminal.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/js/util/DD.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/js/util/DDResize.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/js/Container.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/js/Layer.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/js/util/inputex/FormContainer-beta.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/js/LayerMap.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/js/WiringEditor.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/js/ImageContainer.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/js/InOutContainer.js"></script>
<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/js/adapters/json-rpc.js"></script>

<script type="text/javascript" src="<?= $this->url() ?>apps/bpm/webroot/js/policyEditor.js"></script>

<style>
/* Comment Module */
div.WireIt-Container.WiringEditor-module-comment { width: 200px; }
div.WireIt-Container.WiringEditor-module-comment div.body { background-color: #EEEE66; }
div.WireIt-Container.WiringEditor-module-comment div.body textarea { background-color: transparent; font-weight: bold; border: 0; }
</style>

<script>

// InputEx needs a correct path to this image
inputEx.spacerUrl = "<?= $this->url() ?>apps/bpm/webroot/WireIt-0.5.0/lib/inputex/images/space.gif";

$(function(){
///    alert("oi");
//});

//YAHOO.util.Event.onDOMReady( function() {
    console.debug("carregando editor...");
    //alert("ola");
	//var
        editor = new WireIt.WiringEditor(meicanPolicyLanguage); 
	
	// Open the infos panel
        //editor.accordionView.openPanel(2);
	//editor.accordionView.closePanel(0);
	//editor.accordionView.closePanel(1);
	//editor.accordionView.closePanel(2);
});

</script>

<!-- body class="yui-skin-sam" -->

    <h1><?= _("Policy Editor") ?></h1>
    
    <div id="container">
    
	<div id="top">
		<div id="toolbar"></div>
	</div>


	<div id="left">
	</div>
	
	
	<div id="right">
	  <ul id="accordionView">
		<li>
			<h2>Properties</h2>
			<div>
				<div id="propertiesForm"></div>
			</div>
		</li>
		<li>
			<h2>Minimap</h2>
			<div style='position: relative;'>
				<div id="layerMap"></div>
			</div>
		</li>
		<li>
			<h2>Infos</h2>
			<div>
				<div style="padding: 10px;">
					<p>This example shows how to use the <i>ImageContainer</i> and <i>FormContainer</i> in a language definition.</p>
					<br />
					<p><b>Drag and drop modules from the Module list</b> on the left to the working layer in the middle.</p>
					<br />
					<p><a href="policyEditor" target="_new">Click here to view the language definition for this editor.</a></p>
				</div>
			</div>
		</li>
		
	  </ul>
	</div>

	<div id="center">
	</div>
	
	
	<div id="helpPanel">
	    <div class="hd">Welcome to the WiringEditor demonstration</div>
	    <div class="bd" style="text-align: left;">
					
					<p>This example shows how to use the <i>ImageContainer</i> and <i>FormContainer</i> in a language definition.</p>
					<br />
					<p><b>Drag and drop modules from the Module list</b> on the left to the working layer in the middle.</p>
					<br />
					<p><a href="demo.js" target="_new">Click here to view the language definition for this editor.</a></p>
					<br />
					<p>Close this dialog to test the WiringEditor</p>
	    </div>
	</div>    
    
    </div>

<!-- /body -->