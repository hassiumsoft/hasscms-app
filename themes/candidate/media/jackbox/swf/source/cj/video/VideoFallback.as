package cj.video {
	
	import flash.display.Shape;
	import flash.display.Sprite;
	import flash.display.MovieClip;
	import flash.display.StageDisplayState;
	import flash.display.StageScaleMode;
	import flash.display.StageAlign;
	import flash.text.TextField;
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.events.IOErrorEvent;
	import flash.events.FullScreenEvent;
	import flash.events.NetStatusEvent;
	import flash.events.TimerEvent;
	import flash.media.Video;
	import flash.media.SoundTransform;
	import flash.net.URLRequest;
	import flash.net.NetConnection;
	import flash.net.NetStream;
	import flash.ui.ContextMenu;
	import flash.utils.Timer;
	import flash.utils.setTimeout;
	import flash.external.ExternalInterface;
	
	import fl.transitions.Tween;
	import fl.transitions.easing.Strong;
	
	import cj.video.events.VideosEvent;
	
	public final class VideoFallback extends Sprite {
		
		private var vHolder:Sprite,
		masker:Shape,
		controls:VideoControls,
		bigPlay:BigPlayButton,
		timeText:TextField,
		vidLine:MovieClip,
		volLine:MovieClip,
		vCover:Sprite,
		master:Sprite,
		tw:Tween,
		tw2:Tween,
		
		vid:Video,
		meta:Object,
		st:SoundTransform,
		nc:NetConnection,
		ns:NetStream,

		videoPlayed:Boolean,
		isPlaying:Boolean,
		playAuto:Boolean,
		getOnce:Boolean,
		isFull:Boolean,
		theVolume:Number,
		duration:Number,
		timed:Timer,
		volLineW:int,
		vidLineW:int,
		vWidth:int,
		vHeight:int,
		vHalf:int,
		secs:int,
		mins:Number,
		rightTime:String;
		
		public function VideoFallback() {
			
			(stage == null) ? addEventListener(Event.ADDED_TO_STAGE, added) : added();
			addEventListener(Event.UNLOAD, removed);
			
		}
		
		private function added(event:Event = null):void {
			
			if(event != null) removeEventListener(Event.ADDED_TO_STAGE, added);
			
			stage.scaleMode = StageScaleMode.NO_SCALE;
			stage.align = StageAlign.TOP_LEFT;
			
			this.contextMenu = new ContextMenu();
			this.contextMenu.hideBuiltInItems();
			
			playAuto = root.loaderInfo.parameters["auto"] == "true";
			theVolume = int(root.loaderInfo.parameters["vol"]) || 0.75;
			isPlaying = isFull = false;
			getOnce = true;
			
			st = new SoundTransform(0);
			
			nc = new NetConnection();
			nc.addEventListener(IOErrorEvent.IO_ERROR, catchError);
			nc.connect(null);
			
			meta = new Object();
			meta.onMetaData = runMeta;
			
			ns = new NetStream(nc);
			ns.soundTransform = st;
			ns.client = meta;
			
			vid = new Video();
			vid.attachNetStream(ns);
			vid.width = int(root.loaderInfo.parameters["width"]) || 640;
			vid.height = int(root.loaderInfo.parameters["height"]) || 360;
			
			vHolder = new Sprite();
			vHolder.addChild(vid);
			
			vCover = new Sprite();
			vHolder.addChild(vCover);
			
			masker = new Shape();
			vHolder.mask = masker;
			
			master = new Sprite();
			master.mouseEnabled = false;
			master.alpha = 0;
			
			master.addChild(vHolder);
			master.addChild(masker);
			addChild(master);
			
			ns.addEventListener(IOErrorEvent.IO_ERROR, catchError);
			ns.addEventListener(NetStatusEvent.NET_STATUS, statusEvent);
			ns.play(root.loaderInfo.parameters["url"]);
			
			addEventListener(Event.REMOVED_FROM_STAGE, removed);
		
		}
		
		private function runMeta(info:Object):void {
			
			if(getOnce) {
				
				getOnce = false;
				controls = new VideoControls(kicker, theVolume);
				
				duration = info.duration;
				timeText = controls.myText.timeText;
				
				mins = duration / 60;
				secs = (mins - int(mins)) * 60;
				mins = int(mins);
				
				rightTime = "/" + (mins < 10 ? "0" + mins : mins) + ":" + (secs < 10 ? "0" + secs : secs);
				timeText.text = "00:00" + rightTime;
				
				master.addChild(controls);
				
				bigPlay = new BigPlayButton(playAuto);
				master.addChild(bigPlay);
				
				ns.seek(0);
				ns.pause();
				
				timed = new Timer(3000, 1);
				timed.addEventListener(TimerEvent.TIMER, hideControls);
				
				st.volume = theVolume;
				ns.soundTransform = st;
				
				addEventListener(VideosEvent.CLICKED, videoClick);
				vCover.addEventListener(MouseEvent.CLICK, videoClicking);
				
				if(ExternalInterface.available) {
					
					ExternalInterface.addCallback("videoResized", videoReady);
					ExternalInterface.call("videoReady");
					
				}
				
			}
			
		}
		
		private function videoReady() {
			
			resized();
			stage.addEventListener(Event.RESIZE, resized, false, 0, true);
			tw2 = new Tween(master, "alpha", Strong.easeOut, 0, 1, 0.75, true);
			
			if(playAuto) {
				
				playVid();
				timed.start();
				addListeners();
				
			}
			else {
				
				videoPlayed = false;
				
			}
		
		}
		
		private function resized(event:Event = null):void {
			
			vWidth = stage.stageWidth;
			vHeight = stage.stageHeight;
		
			vidLineW = vWidth - 237;
			vHalf = vWidth >> 1;
			
			vHolder.width = vWidth;
			vHolder.height = vHeight;
			
			with(masker.graphics) {
				
				clear;
				beginFill(0);
				drawRect(0, 0, vWidth, vHeight);
				endFill();
				
			}
			
			with(vCover.graphics) {
				
				clear;
				beginFill(0, 0);
				drawRect(0, 0, vWidth, vHeight);
				endFill();
				
			}
			
			controls.y = vHeight - 28;
		
		}
		
		private function showControls(event:MouseEvent):void {
			
			if(timed.running) timed.stop();
			
			if(controls.alpha != 1) {
				
				if(tw != null) tw.stop();
				tw = new Tween(controls, "alpha", Strong.easeOut, controls.alpha, 1, 0.75, true);
				
			}
			
			if(isFull) timed.start();
			
		}
		
		private function hideControls(event:Event):void {
			
			if(!isFull) {
				
				if(tw != null) tw.stop();
				tw = new Tween(controls, "alpha", Strong.easeOut, controls.alpha, 0, 0.75, true);
				
			}
			
			else {
				
				var stageHalf:int = stage.stageWidth >> 1;
				
				if(event is MouseEvent || event is TimerEvent) {
				
					if(mouseY < stage.stageHeight - 28) {
						
						if(tw != null) tw.stop();
						tw = new Tween(controls, "alpha", Strong.easeOut, controls.alpha, 0, 0.75, true);
						
					}
					else if(mouseX < stageHalf - vHalf || mouseX > stageHalf + vHalf) {
						
						if(tw != null) tw.stop();
						tw = new Tween(controls, "alpha", Strong.easeOut, controls.alpha, 0, 0.75, true);
						
					}
					
				}
				else {
					
					if(tw != null) tw.stop();
					tw = new Tween(controls, "alpha", Strong.easeOut, controls.alpha, 0, 0.75, true);
					
				}
				
			}
			
		}
		
		private function videoClicking(event:MouseEvent):void {
			
			dispatchEvent(new VideosEvent(VideosEvent.CLICKED, controls.playBtn.visible ? "playBtn" : "pauseBtn", 0));
			
		}
		
		private function kicker(videoLine:MovieClip, volumeLine:MovieClip, volLineWid:int):void {
			
			vidLine = videoLine;
			volLine = volumeLine;
			
			volLineW = volLineWid;
			
		}
		
		private function videoClick(event:VideosEvent):void {
			
			switch(event.item) {
				
				case "playBtn":
				
					playVid();
				
				break;
				
				case "pauseBtn":
				
					pauseVid();
				
				break;
				
				case "volOn":
				
					updateV(0);
				
				break;
				
				case "volOff":
				
					updateV(theVolume);
				
				break;
				
				case "fullOn":
				
					goFull();
				
				break;
				
				case "fullOff":
				
					exitFull();
				
				break;
				
				case "volTotal":
				
					updateV(event.xx / volLineW);
				
				break;
				
				case "totalLine":
				
					moveLine(event.xx / vidLineW);
				
				break;
				
			}
			
		}
		
		private function playVid():void {
			
			ns.resume();
			controls.playOn();
			isPlaying = true;
			bigPlay.playIt();
			
			addEventListener(Event.ENTER_FRAME, updateStatus);
			
			if(!videoPlayed) addListeners();
			
		}
		
		private function addListeners():void {
			
			addEventListener(MouseEvent.MOUSE_MOVE, showControls);
			stage.addEventListener(Event.MOUSE_LEAVE, hideControls, false, 0, true);
			
			videoPlayed = true;
			
		}
		
		private function pauseVid():void {
			
			if(!getOnce) {
			
				ns.pause();
				controls.playOff();
				bigPlay.pauseIt();
				
				removeEventListener(Event.ENTER_FRAME, updateStatus);
				
			}
			
		}
		
		private function statusEvent(event:NetStatusEvent):void {
			
			if(event.info.code == "NetStream.Play.Stop") {
					
				removeEventListener(Event.ENTER_FRAME, updateStatus);
				
				ns.seek(0);
				ns.pause();
				
				if(timed.running) timed.stop();
				if(controls.alpha != 1) {
					
					if(tw != null) tw.stop();
					tw = new Tween(controls, "alpha", Strong.easeOut, controls.alpha, 1, 0.75, true);
					
				}
				
				controls.playOff();
				bigPlay.pauseIt();
				
				vidLine.scaleX = 0;
				timeText.text = "00:00" + rightTime;
				
				videoPlayed = isPlaying = false;
				
				removeEventListener(MouseEvent.MOUSE_MOVE, showControls);
				stage.removeEventListener(Event.MOUSE_LEAVE, hideControls);
				
			}
			
		}
		
		private function updateStatus(event:Event):void {
			
			vidLine.scaleX = ns.time / duration;
			
			mins = ns.time / 60;
			secs = (mins - int(mins)) * 60;
			mins = int(mins);
			
			timeText.text = (mins < 10 ? "0" + mins : mins) + ":" + (secs < 10 ? "0" + secs : secs) + rightTime;
			
		}
		
		private function moveLine(num:Number):void {
			
			isPlaying = true;
			controls.playOn();
			bigPlay.playIt();
			
			ns.seek((num * duration) | 0);
			ns.resume();
			
			if(!videoPlayed) addListeners();
			
			addEventListener(Event.ENTER_FRAME, updateStatus);
			
		}
		
		private function updateV(vol:Number):void {
			
			st.volume = vol;
			ns.soundTransform = st;
			
			volLine.scaleX = vol;
			
			(vol > 0) ? controls.volumeOff() : controls.volumeOn();
			
		}
		
		private function goFull():void {
			
			stage.removeEventListener(Event.RESIZE, resized);
			stage.displayState = StageDisplayState.FULL_SCREEN;

			var sw:int = stage.stageWidth, 
			sh:int = stage.stageHeight, 
			theW:int = vWidth, 
			theH:int = vHeight, 
			scalerH:Number = sw / vWidth, 
			scalerW:Number = sh / vHeight, 
			scaleMe:Number;
			isFull = true;
			
			(scalerH <= scalerW) ? scaleMe = scalerH : scaleMe = scalerW;
			
			theW *= scaleMe;
			theH *= scaleMe;
			
			vHolder.width = theW;
			vHolder.height = theH;
			controls.fsOn();
			
			with(masker.graphics) {
				
				clear();
				beginFill(0);
				drawRect(0, 0, sw, sh);
				endFill();
				
			}
			
			vHolder.x = (sw >> 1) - (theW >> 1);
			vHolder.y = (sh >> 1) - (theH >> 1);
			controls.y = sh - 28;
			
			stage.addEventListener(FullScreenEvent.FULL_SCREEN, exitFull, false, 0, true);
					
		}
		
		
		// exits out of full-screen
		private function exitFull(event:Event = null):void {
			
			stage.removeEventListener(FullScreenEvent.FULL_SCREEN, exitFull);
			stage.displayState = StageDisplayState.NORMAL;
						
			vHolder.width = vWidth
			vHolder.height = vHeight;
			isFull = false;
			
			with(masker.graphics) {
						
				clear();
				beginFill(0);
				drawRect(0, 0, vWidth, vHeight);
				endFill();
						
			}
			
			vHolder.x = vHolder.y = 0;
			controls.y = vHeight - 28;
			
			controls.fsOff();
			stage.addEventListener(Event.RESIZE, resized, false, 0, true);
			
		}
		
		private function checkPound(st:String):Boolean {
			
			if(st != "" && st != null) {
				
				if(st.toLowerCase() == "true") {
					return true;
				}
				else {
					return false;
				}
				
			}
			else {
				return false;
			}
			
		}
		
		private function catchError(event:IOErrorEvent):void {};
		
		private function removed(event:Event):void {
			
			removeEventListener(Event.UNLOAD, removed);
			removeEventListener(Event.REMOVED_FROM_STAGE, removed);
			removeEventListener(Event.ADDED_TO_STAGE, added);
			
			if(vHolder != null) {
				
				removeEventListener(Event.ENTER_FRAME, updateStatus);
				nc.removeEventListener(IOErrorEvent.IO_ERROR, catchError);
				ns.removeEventListener(IOErrorEvent.IO_ERROR, catchError);
				ns.removeEventListener(NetStatusEvent.NET_STATUS, statusEvent);
				vCover.removeEventListener(MouseEvent.CLICK, videoClicking);
				removeEventListener(VideosEvent.CLICKED, videoClick);
				removeEventListener(MouseEvent.MOUSE_MOVE, showControls);
				
				ns.pause();
				
				try {
					ns.close();
				}
				catch(event:*){};
				
				try {
					nc.close();
				}
				catch(event:*){};
				
				vid.clear();
				vCover.graphics.clear();
				masker.graphics.clear();
				
				if(stage != null) {
					
					stage.removeEventListener(Event.MOUSE_LEAVE, hideControls);
					stage.removeEventListener(FullScreenEvent.FULL_SCREEN, exitFull);
					stage.removeEventListener(Event.RESIZE, resized);
					
				}
				
				if(timed != null) {
				
					timed.removeEventListener(TimerEvent.TIMER, hideControls);
					timed.stop();
					timed = null;
					
				}
				
				if(tw != null) tw.stop();
				if(tw2 != null) tw2.stop();
				
				while(vHolder.numChildren) vHolder.removeChildAt(0);
				while(master.numChildren) master.removeChildAt(0);
				while(this.numChildren) removeChildAt(0);
				
				vHolder = null;
				masker = null;
				master = null;
				controls = null;
				bigPlay = null;
				vidLine = null;
				volLine = null;
				vCover = null;
				vid = null;
				meta = null;
				tw2 = null;
				st = null;
				nc = null;
				ns = null;
				
			}
			
		}
		
	}
	
}










