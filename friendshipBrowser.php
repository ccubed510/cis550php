<html>
	<head>
		<!-- JIT Library File -->
		<script language="javascript" type="text/javascript" src="/Jit/jit.js"></script>
		<!-- Friendship Visualization -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
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
					Node: {
			          dim: 9,
			          color: "#f00",
			          overridable: true
			      	},
			      	Edge: {
			          lineWidth: 2,
			          color: "#088"
			      	},
			      onCreateLabel: function(domElement, node){
			          domElement.innerHTML = node.name;
			          $jit.util.addEvent(domElement, 'click', function () {
			              ht.onClick(node.id, {
			                  onComplete: function() {
			                      ht.controller.onComplete();
			                  }
			              });
			          });
			      },
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
			          
			          if (node.data.photos) {
			          	var html2 = "<h4>Photos:</h4>";
			          	html2 += "<table>";
			          	var photos = node.data.photos;
			          	for (var key in photos) {
			          		html2 += "<tr><td><img src=\"" + photos[key].url + "\" alt=\"img\" width=\"150\" /></td></tr>";
			          	}
			          	html2 += "</table>";
			          	$jit.id('photos').innerHTML = html2;
			          }
			          else {
			          	$jit.id('photos').innerHTML = "";
			          }
			      }
				})
				//load JSON data.
				ht.loadJSON(json);
				//compute positions and plot.
				ht.refresh();
				//end
				ht.controller.onComplete();
			}
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