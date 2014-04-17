// Garden Gnome Software - Skin
// Pano2VR 4.0/3102S
// Filename: AASFv1-otherscenes.ggsk
// Generated Thu Jan 17 16:28:22 2013

function pano2vrSkin(player,base) {
	var me=this;
	var flag=false;
	var nodeMarker=new Array();
	var activeNodeMarker=new Array();
	this.player=player;
	this.player.skinObj=this;
	this.divSkin=player.divSkin;
	var basePath="";
	// auto detect base path
	if (base=='?') {
		var scripts = document.getElementsByTagName('script');
		for(var i=0;i<scripts.length;i++) {
			var src=scripts[i].src;
			if (src.indexOf('skin.js')>=0) {
				var p=src.lastIndexOf('/');
				if (p>=0) {
					basePath=src.substr(0,p+1);
				}
			}
		}
	} else
	if (base) {
		basePath=base;
	}
	this.elementMouseDown=new Array();
	this.elementMouseOver=new Array();
	var cssPrefix='';
	var domTransition='transition';
	var domTransform='transform';
	var prefixes='Webkit,Moz,O,ms,Ms'.split(',');
	var i;
	for(i=0;i<prefixes.length;i++) {
		if (typeof document.body.style[prefixes[i] + 'Transform'] !== 'undefined') {
			cssPrefix='-' + prefixes[i].toLowerCase() + '-';
			domTransition=prefixes[i] + 'Transition';
			domTransform=prefixes[i] + 'Transform';
		}
	}
	
	this.player.setMargins(0,0,0,0);
	
	this.updateSize=function(startElement) {
		var stack=new Array();
		stack.push(startElement);
		while(stack.length>0) {
			e=stack.pop();
			if (e.ggUpdatePosition) {
				e.ggUpdatePosition();
			}
			if (e.hasChildNodes()) {
				for(i=0;i<e.childNodes.length;i++) {
					stack.push(e.childNodes[i]);
				}
			}
		}
	}
	
	parameterToTransform=function(p) {
		return 'translate(' + p.rx + 'px,' + p.ry + 'px) rotate(' + p.a + 'deg) scale(' + p.sx + ',' + p.sy + ')';
	}
	
	this.findElements=function(id,regex) {
		var r=new Array();
		var stack=new Array();
		var pat=new RegExp(id,'');
		stack.push(me.divSkin);
//   this is not getting triggered
//		alert('stackpush');
//		alert(me.divSkin);
		while(stack.length>0) {
			e=stack.pop();
			if (regex) {
				if (pat.test(e.ggId)) r.push(e);
			} else {
				if (e.ggId==id) r.push(e);
			}
			if (e.hasChildNodes()) {
				for(i=0;i<e.childNodes.length;i++) {
					stack.push(e.childNodes[i]);
				}
			}
		}
		return r;
	}
	
	this.addSkin=function() {
		// begin add toolbar
		this._toolbarbg=document.createElement('div');
		this._toolbarbg.ggId='ToolBarBG';
		this._toolbarbg.ggParameter={ rx:0,ry:0,a:0,sx:1,sy:1 };
		this._toolbarbg.ggVisible=true;
		this._toolbarbg.ggUpdatePosition=function() {
			this.style[domTransition]='none';
			if (this.parentNode) {
				w=this.parentNode.offsetWidth;
				this.style.left=(-120 + w) + 'px';
			}
		}
		hs ='position:absolute;';
		hs+='left: -120px;';
		hs+='top:  0px;';
		hs+='width: 120px;';
		hs+='height: 40px;';
		hs+=cssPrefix + 'transform-origin: 50% 50%;';
		hs+='visibility: inherit;';
		this._toolbarbg.setAttribute('style',hs);
		this._toolbarbg__img=document.createElement('img');
		this._toolbarbg__img.setAttribute('src',basePath + 'images/toolbarbg.png');
		this._toolbarbg__img.setAttribute('style','position: absolute;top: 0px;left: 0px;');
		me.player.checkLoaded.push(this._toolbarbg__img);
		this._toolbarbg.appendChild(this._toolbarbg__img);
		this._zoomoutbutton=document.createElement('div');
		this._zoomoutbutton.ggId='ZoomOutButton';
		this._zoomoutbutton.ggParameter={ rx:0,ry:0,a:0,sx:1,sy:1 };
		this._zoomoutbutton.ggVisible=true;
		hs ='position:absolute;';
		hs+='left: 68px;';
		hs+='top:  5px;';
		hs+='width: 31px;';
		hs+='height: 24px;';
		hs+=cssPrefix + 'transform-origin: 50% 50%;';
		hs+='visibility: inherit;';
		hs+='cursor: pointer;';
		this._zoomoutbutton.setAttribute('style',hs);
		this._zoomoutbutton__img=document.createElement('img');
		this._zoomoutbutton__img.setAttribute('src',basePath + 'images/zoomoutbutton.png');
		this._zoomoutbutton__img.setAttribute('style','position: absolute;top: 0px;left: 0px;');
		me.player.checkLoaded.push(this._zoomoutbutton__img);
		this._zoomoutbutton.appendChild(this._zoomoutbutton__img);
		this._zoomoutbutton.onclick=function () {
			me.player.changeFovLog(1,true);
		}
		this._toolbarbg.appendChild(this._zoomoutbutton);
		this._zoominbutton=document.createElement('div');
		this._zoominbutton.ggId='ZoomInButton';
		this._zoominbutton.ggParameter={ rx:0,ry:0,a:0,sx:1,sy:1 };
		this._zoominbutton.ggVisible=true;
		hs ='position:absolute;';
		hs+='left: 25px;';
		hs+='top:  5px;';
		hs+='width: 31px;';
		hs+='height: 24px;';
		hs+=cssPrefix + 'transform-origin: 50% 50%;';
		hs+='visibility: inherit;';
		hs+='cursor: pointer;';
		this._zoominbutton.setAttribute('style',hs);
		this._zoominbutton__img=document.createElement('img');
		this._zoominbutton__img.setAttribute('src',basePath + 'images/zoominbutton.png');
		this._zoominbutton__img.setAttribute('style','position: absolute;top: 0px;left: 0px;');
		me.player.checkLoaded.push(this._zoominbutton__img);
		this._zoominbutton.appendChild(this._zoominbutton__img);
		this._zoominbutton.onclick=function () {
			me.player.changeFovLog(-1,true);
		}
		this._toolbarbg.appendChild(this._zoominbutton);
		this.divSkin.appendChild(this._toolbarbg);
		// end add toolbar


		this.divSkin.ggUpdateSize=function(w,h) {
			me.updateSize(me.divSkin);
		}
		this.divSkin.ggViewerInit=function() {
		}
		this.divSkin.ggLoaded=function() {
		}
		this.divSkin.ggReLoaded=function() {
		}
		this.divSkin.ggEnterFullscreen=function() {
		}
		this.divSkin.ggExitFullscreen=function() {
		}
		this.skinTimerEvent();
	};
	this.hotspotProxyClick=function(id) {
	}
	this.hotspotProxyOver=function(id) {
	}
	this.hotspotProxyOut=function(id) {
	}
	this.changeActiveNode=function(id) {
		var newMarker=new Array();
		var i,j;
		var tags=me.player.userdata.tags;
		for (i=0;i<nodeMarker.length;i++) {
			var match=false;
			if (nodeMarker[i].ggMarkerNodeId==id) match=true;
			for(j=0;j<tags.length;j++) {
				if (nodeMarker[i].ggMarkerNodeId==tags[j]) match=true;
			}
			if (match) {
				newMarker.push(nodeMarker[i]);
			}
		}
		for(i=0;i<activeNodeMarker.length;i++) {
			if (newMarker.indexOf(activeNodeMarker[i])<0) {
				if (activeNodeMarker[i].ggMarkerNormal) {
					activeNodeMarker[i].ggMarkerNormal.style.visibility='inherit';
				}
				if (activeNodeMarker[i].ggMarkerActive) {
					activeNodeMarker[i].ggMarkerActive.style.visibility='hidden';
				}
				if (activeNodeMarker[i].ggDeactivate) {
					activeNodeMarker[i].ggDeactivate();
				}
			}
		}
		for(i=0;i<newMarker.length;i++) {
			if (activeNodeMarker.indexOf(newMarker[i])<0) {
				if (newMarker[i].ggMarkerNormal) {
					newMarker[i].ggMarkerNormal.style.visibility='hidden';
				}
				if (newMarker[i].ggMarkerActive) {
					newMarker[i].ggMarkerActive.style.visibility='inherit';
				}
				if (newMarker[i].ggActivate) {
					newMarker[i].ggActivate();
				}
			}
		}
		activeNodeMarker=newMarker;
	}
	this.skinTimerEvent=function() {
		setTimeout(function() { me.skinTimerEvent(); }, 10);
	};

	function SkinHotspotClass(skinObj,hotspot) {
		var me=this;
		var flag=false;
		this.player=skinObj.player;
		this.skin=skinObj;
		this.hotspot=hotspot;
		this.elementMouseDown=new Array();
		this.elementMouseOver=new Array();
		this.__div=document.createElement('div');
		this.__div.setAttribute('style','position:absolute; left:0px;top:0px;visibility: inherit;');
		this.findElements=function(id,regex) {
			return me.skin.findElements(id,regex);
		}

			this.__div=document.createElement('div');
			this.__div.ggId='d'+hotspot.skinid;
			this.__div.ggParameter={ rx:0,ry:0,a:0,sx:1,sy:1 };
			this.__div.ggVisible=true;
			hs ='position:absolute;';
			hs+='left: 80px;';
			hs+='top:  75px;';
			hs+='width: 5px;';
			hs+='height: 5px;';
			hs+=cssPrefix + 'transform-origin: 50% 50%;';
			hs+='visibility: inherit;';
			this.__div.setAttribute('style',hs);
			this.__div.onclick=function () {
				me.skin.hotspotProxyClick(me.hotspot.id);
			}
			this.__div.onmouseover=function () {
				me.player.hotspot=me.hotspot;
				me.skin.hotspotProxyOver(me.hotspot.id);
			}
			this.__div.onmouseout=function () {
				me.player.hotspot=me.player.emptyHotspot;
				me.skin.hotspotProxyOut(me.hotspot.id);
			}
			this._up020=document.createElement('div');
			this._up020.ggId='i'+hotspot.skinid;
			this._up020.setAttribute('id','i'+hotspot.skinid);
			this._up020.ggParameter={ rx:0,ry:0,a:0,sx:1,sy:1 };
			this._up020.ggVisible=true;
			hs ='position:absolute;';
			hs+='left: -49px;';
			hs+='top:  -36px;';
			hs+='width: 80px;';
			hs+='height: 96px;';
			hs+=cssPrefix + 'transform-origin: 50% 50%;';
			hs+='visibility: inherit;';
			this._up020.setAttribute('style',hs);
			this._up020__img=document.createElement('img');
//			this._up020__img.setAttribute('src',basePath + 'images/up020.png');
			this._up020__img.setAttribute('src','/img/other.png');
			this._up020__img.setAttribute('style','position: absolute;top: 0px;left: 0px;');
			me.player.checkLoaded.push(this._up020__img);
			this._up020.appendChild(this._up020__img);
			this._up020.onclick=function (the20) {
//				me.player.openUrl("\/tours\/?s=02","_parent");
				handleClick(this);
			}
			this.__div.appendChild(this._up020);
	};
	this.addSkinHotspot=function(hotspot) {
		return new SkinHotspotClass(me,hotspot);
	}
	this.addSkin();
};
