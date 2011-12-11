<html>
	<head>
		<!-- JIT Library File -->
		<script language="javascript" type="text/javascript" src="/Jit/jit.js"></script>
		<!-- Friendship Visualization -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
		<!--<script language="javascript" type="text/javascript" src="/js/friendshipVisualization.js"></script>-->
		<script type="text/javascript">
			function init(){
				
				xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4) {
						var response = xmlhttp.responseText;
						if (response.trim() == 'error') {
							alert("Unable to upload photo.");
						}
						else {
							//alert(response);
							var obj = jQuery.parseJSON(response);
							getGraph(obj);
						}
					}
				}
				
				xmlhttp.open("GET", "friendshipJSONConverter.php", true);
				xmlhttp.send();
				
			}
			
			function getGraph(json) {
				var infovix = document.getElementById('infovis');
				
				var w = infovis.offsetWidth - 50, h = infovis.offsetHeight - 50;
				
				//init Hypertree
				var ht = new $jit.Hypertree({
					injectInto: 'infovis',
					//canvas width and height
					width: w,
					height: h,
					//Change node and edge styles such as color, width, and dimensions.
					Node: {
			          dim: 9,
			          color: "#f00",
			          overridable: true
			      	},
			      	Edge: {
			          lineWidth: 2,
			          color: "#088"
			      	},
			      	 //Attach event handlers and add text to the
			      //labels. This method is only triggered on label
			      //creation
			      onCreateLabel: function(domElement, node){
			          domElement.innerHTML = node.name;
			          $jit.util.addEvent(domElement, 'click', function () {
			              //addToGraph(ht, node.id, node.name);
			              ht.onClick(node.id, {
			                  onComplete: function() {
			                      ht.controller.onComplete();
			                  }
			              });
			          });
			      },
			      //Change node styles when labels are placed
			      //or moved.
			      onPlaceLabel: function(domElement, node){
			          var style = domElement.style;
			          style.display = '';
			          style.cursor = 'pointer';
			          if (node._depth <= 1) {
			              style.fontSize = "0.8em";
			              style.color = "#eee";
			
			          } else if(node._depth == 2){
			              style.fontSize = "0.7em";
			              style.color = "#555";
			
			          } else {
			              style.display = 'none';
			          }
			
			          var left = parseInt(style.left);
			          var w = domElement.offsetWidth;
			          style.left = (left - w / 2) + 'px';
			      },
			       onComplete: function(){
			         
			          //Build the right column relations list.
			          //This is done by collecting the information (stored in the data property) 
			          //for all the nodes adjacent to the centered node.
			          var node = ht.graph.getClosestNodeToOrigin("current");
			          var html = "<h4>" + node.name + "</h4><b>Connections:</b>";
			          html += "<ul>";
			          node.eachAdjacency(function(adj){
			              var child = adj.nodeTo;
			              if (child.data) {
			                  html += "<li>" + child.name + "</li>";
			              }
			          });
			          html += "</ul>";
			          $jit.id('inner-details').innerHTML = html;
			          
			          var html2 = "<h4>Photos:</h4>";
			          html2 += "<table>";
			          if (node.data.photos) {
			          	var photos = node.data.photos;
			          	for (var key in photos) {
			          		html2 += "<tr><img src=\"" + photos[key].url + "\" alt=\"img\" /></tr>";
			          	}
			          }
			          html2 += "</table>";
			          $jit.id('photos').innerHTML = html2;
			      }
				})
				//load JSON data.
				ht.loadJSON(json);
				//compute positions and plot.
				ht.refresh();
				//end
				ht.controller.onComplete();
			}
			
			/*function addToGraph(ht, userID, name) {
				xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4) {
						var response = xmlhttp.responseText;
						if (response.trim() == 'error') {
							alert("Unable to upload photo.");
						}
						else {
							var content = jQuery.parseJSON(response);
							ht.op.sum(content, { type: "fade:con", fps: 4, duration: 1000, hideLabels: true });
						}
					}
				}
				
				xmlhttp.open("GET", "getNodeAndNeighbors.php?userID=" + userID + "&name=" + name, true);
				xmlhttp.send();
				
			}*/
		</script>
		<style type="text/css">
			.graphColor {
				color:"#000000";
			}
			
			.indent {
				margin-left: 1em;
			}
			
			#container {
			    width: 1000px;
			    height: 600px;
			    margin:0 auto;
			    position:relative;
			}
			
			#left-container, 
			#right-container, 
			#center-container {
			    height:600px;
			    position:absolute;
			    top:0;
			}
			
			#left-container, #right-container {
			    width:200px;
			    color:#686c70;
			    text-align: left;
			    overflow: auto;
			    background-color:#fff;
			    background-repeat:no-repeat;
			    border-bottom:1px solid #ddd;
			}
			
			#left-container {
			    left:0;
			    background-position:center right;
			    border-left:1px solid #ddd;
			    
			}
			
			#right-container {
			    right:0;
			    background-position:center left;
			    border-right:1px solid #ddd;
			}
			
			#center-container {
			    width:600px;
			    left:200px;
			    background-color:#1a1a1a;
			    color:#ccc;
			}
			
			#infovis {
    			position:relative;
			    width:600px;
			    height:600px;
			    margin:auto;
			    overflow:hidden;
			}
		</style>
	</head>
	<body onload="init();">
		<div id="container">
			<div id="left-container">
				<div id="inner-details" class="indent"></div>
			</div>
			<div id="center-container">
				<div id="infovis"></div>
			</div>
			<div id="right-container">
				<div id="photos" class="indent"></div>
			</div>
		</div>
	</body>
</html>